<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlansPost extends Model
{
    use Userstamps, SoftDeletes;

    protected $table = 'plans_posts';

    protected $fillable = [
        'plan_id', 'post_id', 'codigo', 'active'
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
