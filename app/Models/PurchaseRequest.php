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
        'activity_title',
        'office_department',
        'fund_source',
        'purpose',
        'request_date',
        'target_date',
        'needed_date',
        'estimated_amount',
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
