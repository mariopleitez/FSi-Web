<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use Userstamps, SoftDeletes;
    

    protected $table = 'states';
    //
    protected $fillable = [
        'name', 'active'
    ];

    public function pais(){
        return $this->belongsTo(Country::class, "country_id");
    }
}
