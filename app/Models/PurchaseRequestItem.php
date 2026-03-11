<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_request_id',
        'item_description',
        'unit',
        'qty',
        'estimated_unit_cost',
        'total_amount',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'qty' => 'integer',
            'estimated_unit_cost' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
    }
}