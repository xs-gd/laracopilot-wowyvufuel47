<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Librarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'phone',
        'department',
        'active',
        'hire_date',
    ];

    protected $casts = [
        'active'    => 'boolean',
        'hire_date' => 'date',
    ];

    public function referenceTransactions()
    {
        return $this->hasMany(ReferenceTransaction::class);
    }
}