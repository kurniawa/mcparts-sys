<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the product that owns the feature.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the work order products associated with the feature.
     */
    public function workOrderProducts()
    {
        return $this->hasMany(WorkOrderProduct::class, 'feature_id');
    }
}
