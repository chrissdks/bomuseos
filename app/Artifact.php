<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artifact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'marker_path','type_id','description','video_url','image_path','target_id', 'createdBy', 'updatedBy'
    ];

    protected $dates = ['deleted_at'];

}
