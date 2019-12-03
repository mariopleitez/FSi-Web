<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use Userstamps, SoftDeletes;

    protected $table = 'authors';
    //
    protected $fillable = [
        'name', 'active', 'imagen', 'thumbnail'
    ];
     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'posts_authors', 'author_id', 'post_id');
    }
}
