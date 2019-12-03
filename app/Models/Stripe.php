<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stripe extends Model
{

    use Userstamps, SoftDeletes;

    protected $table = 'stripes';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice', 'object', 'active', 'balance_transaction', 'stripe_id', 'amount', 'lastfour', 'stripe_created', 'brand', 'exp_year', 'exp_month','zip', 'funding', 'description'
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
