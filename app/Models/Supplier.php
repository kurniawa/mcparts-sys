<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the products associated with the supplier.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the work orders associated with the supplier.
     */
    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }
}
