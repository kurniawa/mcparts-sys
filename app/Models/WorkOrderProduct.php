<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrderProduct extends Model
{
    protected $guarded = [];

    /**
     * Get the work order that owns the product.
     */
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }

    /**
     * Get the product associated with the work order product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
