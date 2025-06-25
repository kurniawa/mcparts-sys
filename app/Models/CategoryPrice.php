<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPrice extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the category tree that owns the category price.
     */
    public function categoryTree()
    {
        return $this->belongsTo(CategoryTree::class, 'category_tree_id');
    }

    /**
     * Get the product associated with the category price.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
