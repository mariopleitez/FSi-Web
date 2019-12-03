<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\DatesTranslator;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use Userstamps, SoftDeletes, DatesTranslator;
    

    protected $table = 'posts';
    //
    protected $fillable = [
        'name', 'active', 'image', 'thumbnail', 'comment', 'posts_type_id', 'video', 'lat', 'lng', 'city_id', 'end_date', 'goal', 'producto_stripe_id'
    ];

     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function post_type(){
        return $this->belongsTo(PostsType::class, "posts_type_id");
    }

    public function ciudad(){
        return $this->belongsTo(City::class, "city_id");
    }
    
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function transactions_total()
    {
        return $this->hasMany(Transaction::class)
                    ->selectRaw('SUM(amount) as total, post_id')
                    ->groupBy('post_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'transactions', 'post_id', 'user_id')->distinct();
    }


    public function likes()
    {
        return $this->belongsToMany(Relation::class, 'posts_relations_users', 'post_id', 'relation_id')->wherePivot('active', 1)->wherePivot('relation_id', 1);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'authors_posts', 'post_id', 'author_id')->distinct();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'posts_tags', 'post_id', 'tag_id');
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plans_posts', 'post_id', 'plan_id')->withPivot("codigo");
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] =  Carbon::createFromFormat('d/m/Y H:i A', $value)->format('Y-m-d H:i:s');
    }

    // public function getEndDateAttribute($value)
    // {
    //     return isset($value) ? Carbon::parse($value)->format('d/m/Y H:i A') : NULL;
    // }
}
