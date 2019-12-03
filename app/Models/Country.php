<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use Userstamps, SoftDeletes;
    

    protected $table = 'countries';
    //
    protected $fillable = [
        'name', 'active'
    ];

}
