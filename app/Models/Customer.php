<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $tenantId = Auth::user()->tenant_id;

            $sequence = DB::table('tenant_sequences')
                ->where('tenant_id', $tenantId)
                ->where('entity_type', 'customers')
                ->first();

            if (!$sequence) {
                DB::table('tenant_sequences')->insert([
                    'tenant_id' => $tenantId,
                    'entity_type' => 'customers',
                    'last_sequence_value' => 1
                ]);
                $sequentialId = 1;
            } else {
                $sequentialId = $sequence->last_sequence_value + 1;
                DB::table('tenant_sequences')
                    ->where('tenant_id', $tenantId)
                    ->where('entity_type', 'customers')
                    ->update(['last_sequence_value' => $sequentialId]);
            }

            $model->sequential_id = $sequentialId;
        });
    }
}
