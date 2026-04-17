<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'reported_by',
        'full_name',
        'email',
        'role',
        'source',
        'reporter_name',
        'reporter_email',
        'reporter_role',
        'issue_type',
        'priority',
        'subject',
        'description',
        'affected_module',
        'status',
    ];

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
