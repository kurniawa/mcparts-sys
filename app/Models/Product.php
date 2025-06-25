<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the supplier that owns the product.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the parent category tree that owns the product.
     */
    public function parentCategoryTree()
    {
        return $this->belongsTo(CategoryTree::class, 'parent_id');
    }

    /**
     * Get the category tree that owns the product.
     */
    public function categoryTree()
    {
        return $this->belongsTo(CategoryTree::class, 'category_id');
    }
}
