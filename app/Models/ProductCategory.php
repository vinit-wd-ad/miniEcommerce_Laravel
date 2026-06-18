<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'image',
        'description',
        'is_active'
    ];

    public function parent() // Parent Category
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children() // Child Categories
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function products() // Category's Products
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}