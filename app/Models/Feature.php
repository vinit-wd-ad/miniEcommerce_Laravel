<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table = 'features';

    protected $fillable = [
        'category_id',
        'feature_name',
        'is_active',
        'short_order'
    ];

    public function category() 
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productFeatures()
    {
        return $this->hasMany(ProductFeature::class, 'feature_id');
    }
}
