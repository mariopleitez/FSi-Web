<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostsRelationsUser extends Model
{
    use Userstamps, SoftDeletes;

    protected $table = 'posts_relations_users';
}
