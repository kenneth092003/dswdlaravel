<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_request_id',
        'file_type',
        'file_name',
        'file_path',
        'remarks',
    ];

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }
}