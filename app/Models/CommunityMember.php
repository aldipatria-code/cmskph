<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityMember extends Model
{
    protected $fillable = [
        'name',
        'email',
        'age',
        'hepatitis_a',
        'hepatitis_b',
        'hepatitis_c',
        'phone',
        'city',
        'occupation',
        'reason',
        'consent',
        'status',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'consent' => 'boolean',
            'age' => 'integer',
            'hepatitis_a' => 'boolean',
            'hepatitis_b' => 'boolean',
            'hepatitis_c' => 'boolean',
        ];
    }
}
