<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';

    protected $fillable = [
        'title',
        'info',
        'target_url',
        'image',
        'short_order',
        'type',
        'is_active',
    ];

    //  Data Mutators/Casts
    protected $casts = [
        'is_active' => 'boolean',
        'short_order' => 'integer',
    ];
}
