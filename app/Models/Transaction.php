<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    // Define any relationships or methods related to transactions here
    // For example, if a transaction belongs to a user or has many items
    // public function user() {
    //     return $this->belongsTo(User::class);
    // }
}
