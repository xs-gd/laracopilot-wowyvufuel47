<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferenceTransaction extends Model
{
    protected $fillable = [
        'transaction_date',
        'transaction_time',
        'librarian_id',
        'patron_type',
        'channel',
        'transaction_type',
        'subject_area',
        'question_summary',
        'response_summary',
        'resources_used',
        'duration_minutes',
        'status',
        'complexity_level',
        'follow_up_required',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'transaction_date'   => 'date',
        'follow_up_required' => 'boolean',
        'duration_minutes'   => 'integer',
    ];

    public function librarian()
    {
        return $this->belongsTo(Librarian::class);
    }
}