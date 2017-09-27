<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artifact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'marker_path', 'marker_Id','type_id','description','video_url', 'createdBy', 'updatedBy'
    ];

    protected $dates = ['deleted_at'];

}
