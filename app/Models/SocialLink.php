<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialLink extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * (Laravel automatically pluralizes model name, but explicitly defining it is a good practice)
     */
    protected $table = 'social_links';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'platform',
        'url',
        'icon',
        'is_active',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope a query to only include active social links ordered by sort_order.
     * * Usage in Controller: SocialLink::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }
}