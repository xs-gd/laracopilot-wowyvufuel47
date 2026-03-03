<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReferenceTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'librarian_id',
        'patron_name',
        'question',
        'answer',
        'type',
        'duration',
        'notes',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    public function librarian()
    {
        return $this->belongsTo(Librarian::class);
    }
}