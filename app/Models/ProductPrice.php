<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the product that owns the product price.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the work order products associated with the product price.
     */
    public function workOrderProducts()
    {
        return $this->hasMany(WorkOrderProduct::class, 'product_price_id');
    }
}
