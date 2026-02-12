<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'address',
        'occupation',
        'interests',
        'motivation',
        'status',
        'review_notes',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
        ];
    }
}
