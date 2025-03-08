<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::query()
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return inertia('Sections/Index', [
            'sections' => $sections,
            'filters' => request()->only(['search']),
        ]);
    }

    public function create()
    {
        return inertia('Sections/Create');
    }

    public function store(SectionRequest $request)
    {
        Section::create($request->validated());

        return to_route('sections.index');
    }

    // public function show(Section $section)
    // {
    //     //
    // }

    public function edit(Section $section)
    {
        return inertia('Sections/Edit', [
            'section' => $section,
        ]);
    }

    public function update(SectionRequest $request, Section $section)
    {
        $section->update($request->validated());

        return to_route('sections.index');
    }

    public function destroy(Section $section)
    {
        // TODO: Check if the section has any related data before deleting it

        abort(403, 'Forbidden');

        $section->delete();

        return to_route('sections.index');
    }

    public function search(Request $request)
    {
        if ($request->has('ids')) {
            $ids = explode(',', $request->ids);
            $sections = Section::whereIn('id', $ids)
                ->get(['id', 'name']);

            return response()->json([
                'data' => $sections,
            ]);
        }

        $query = $request->search ?? '';

        $sections = Section::query()
            ->where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'name']);

        return response()->json([
            'data' => $sections,
        ]);
    }
}
