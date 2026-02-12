<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'slug',
        'role',
        'email',
        'phone',
        'location',
        'occupation',
        'bio',
        'joined_on',
        'is_public',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'joined_on' => 'date',
            'is_public' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_public', true)->where('is_active', true);
    }
}
