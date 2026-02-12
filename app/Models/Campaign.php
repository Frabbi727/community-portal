<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'status',
        'start_date',
        'end_date',
        'target_amount',
        'current_amount',
        'is_public',
        'contact_email',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'target_amount' => 'decimal:2',
            'current_amount' => 'decimal:2',
            'is_public' => 'boolean',
        ];
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }
}
