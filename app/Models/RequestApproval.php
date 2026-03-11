<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_request_id',
        'approved_by',
        'role_name',
        'status',
        'comments',
        'acted_at',
    ];

    protected $casts = [
        'acted_at' => 'datetime',
    ];

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}