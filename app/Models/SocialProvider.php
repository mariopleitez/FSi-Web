<?php

namespace App\Models;

use App\Models\User;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
  
   use Userstamps, SoftDeletes;

   protected $fillable = ["provider_id", "provider"];

   protected $table = "social_providers";


    
   /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
   
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
