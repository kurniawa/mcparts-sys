<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTree extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the parent category tree that owns the category tree.
     */
    public function parentCategoryTree()
    {
        return $this->belongsTo(CategoryTree::class, 'parent_id');
    }

    /**
     * Get the products associated with the category tree.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
