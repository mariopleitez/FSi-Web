<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use Userstamps, SoftDeletes;

    protected $table = 'images';
    //
    protected $fillable = [
        'name', 'active', 'image', 'thumbnail', 'post_id'
    ];
     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
