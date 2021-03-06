<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Museum extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'address',  'phone', 'createdBy', 'updatedBy'
    ];

    protected $dates = ['deleted_at'];
}
