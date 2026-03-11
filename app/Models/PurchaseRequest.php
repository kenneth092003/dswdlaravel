<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doc_number',
        'activity_title',
        'division_office',
        'fund_source',
        'activity_date',
        'expected_venue',
        'priority_level',
        'purpose_justification',
        'expected_output',
        'estimated_total',
        'status',
        'current_step',
        'date_filed',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
            'date_filed' => 'date',
            'estimated_total' => 'decimal:2',
        ];
    }

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