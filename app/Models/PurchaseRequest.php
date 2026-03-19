<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pr_number',
        'user_id',
        'office_department',
        'purpose',
        'request_date',
        'needed_date',
        'status',
        'total_amount',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

    public function attachments()
    {
        return $this->hasMany(PurchaseRequestAttachment::class);
    }

    public function histories()
    {
        return $this->hasMany(PurchaseRequestHistory::class);
    }
}
