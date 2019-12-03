<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use Userstamps, SoftDeletes;
    

    protected $table = 'cities';
    //
    protected $fillable = [
        'name', 'active'
    ];

    public function departamento(){
        return $this->belongsTo(State::class, "state_id");
    }
}
