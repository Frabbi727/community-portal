<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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
        'profile_photo_path',
        'joined_on',
        'is_public',
        'is_active',
    ];

    protected $appends = ['profile_photo_url'];

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

    public function getProfilePhotoUrlAttribute(): ?string
    {
        if (! $this->profile_photo_path) {
            return null;
        }

        return Storage::url($this->profile_photo_path);
    }
}
