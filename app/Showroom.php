<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Showroom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'museum_id', 'createdBy', 'updatedBy'
    ];

    protected $dates = ['deleted_at'];
}
