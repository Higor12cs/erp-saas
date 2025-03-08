<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::query()
            ->with('section')
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return inertia('Groups/Index', [
            'groups' => $groups,
            'filters' => request()->only(['search']),
        ]);
    }

    public function create()
    {
        return inertia('Groups/Create');
    }

    public function store(GroupRequest $request)
    {
        Group::create($request->validated());

        return to_route('groups.index');
    }

    // public function show(Group $group)
    // {
    //     //
    // }

    public function edit(Group $group)
    {
        return inertia('Groups/Edit', [
            'group' => $group,
        ]);
    }

    public function update(GroupRequest $request, Group $group)
    {
        $group->update($request->validated());

        return to_route('groups.index');
    }

    public function destroy(Group $group)
    {
        // TODO: Check if the group has any related data before deleting it

        abort(403, 'Forbidden');

        $group->delete();

        return to_route('groups.index');
    }
}
