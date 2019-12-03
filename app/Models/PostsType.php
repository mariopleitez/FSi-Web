<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostsType extends Model
{
    use Userstamps, SoftDeletes;

    protected $table = 'posts_types';
    //
    protected $fillable = [
        'name', 'active', 'color'
    ];

     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
