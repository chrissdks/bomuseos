<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Artifact_Showroom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'artifact_id', 'showroom_id', 'createdBy', 'updatedBy'
    ];

    protected $dates = ['deleted_at'];
}
