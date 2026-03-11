<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_request_id',
        'status_key',
        'status_label',
        'remarks',
        'acted_by',
        'acted_at',
        'step_no',
        'is_current',
    ];

    protected function casts(): array
    {
        return [
            'acted_at' => 'datetime',
            'step_no' => 'integer',
            'is_current' => 'boolean',
        ];
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'acted_by');
    }
}