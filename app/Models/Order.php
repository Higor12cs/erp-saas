<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\Sequential;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory, HasUuids, BelongsToTenant, Sequential;

    protected $fillable = [
        'tenant_id',
        'sequential_id',
        'customer_id',
        'issue_date',
        'total_cost',
        'discount',
        'fees',
        'total_price',
        'observation',
        'created_by',
    ];

    protected $casts = [
        'issue_date' => 'datetime',
        'total_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'fees' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
