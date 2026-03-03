<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Librarian extends Model
{
    protected $fillable = [
        'name',
        'email',
        'employee_id',
        'department',
        'specialization',
        'phone',
        'hire_date',
        'active',
        'role',
        'role_notes',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'active'    => 'boolean',
    ];

    /**
     * All available roles with Italian labels and badge colors.
     */
    public static function roles(): array
    {
        return [
            'librarian'            => ['label' => 'Bibliotecario',              'color' => 'bg-blue-100 text-blue-800'],
            'senior_librarian'     => ['label' => 'Bibliotecario Senior',       'color' => 'bg-indigo-100 text-indigo-800'],
            'department_head'      => ['label' => 'Responsabile di Sezione',    'color' => 'bg-purple-100 text-purple-800'],
            'reference_specialist' => ['label' => 'Specialista di Riferimento', 'color' => 'bg-teal-100 text-teal-800'],
            'cataloger'            => ['label' => 'Catalogatore',               'color' => 'bg-green-100 text-green-800'],
            'systems_librarian'    => ['label' => 'Bibliotecario di Sistema',   'color' => 'bg-orange-100 text-orange-800'],
            'archivist'            => ['label' => 'Archivista',                 'color' => 'bg-yellow-100 text-yellow-800'],
            'trainee'              => ['label' => 'Tirocinante',                'color' => 'bg-gray-100 text-gray-600'],
        ];
    }

    /**
     * Human-readable Italian label for the current role.
     */
    public function getRoleLabelAttribute(): string
    {
        return self::roles()[$this->role]['label'] ?? ucfirst($this->role);
    }

    /**
     * Tailwind badge classes for the current role.
     */
    public function getRoleColorAttribute(): string
    {
        return self::roles()[$this->role]['color'] ?? 'bg-gray-100 text-gray-600';
    }

    public function transactions()
    {
        return $this->hasMany(ReferenceTransaction::class);
    }
}