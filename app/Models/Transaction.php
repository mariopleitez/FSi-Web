<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use Userstamps, SoftDeletes;

    protected $table = 'transactions';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice', 'payments_provider_id', 'stripe_id', 'amount', 'amount_less_commissions', 'comment'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
   

    public function provider()
    {
    	return $this->belongsTo(PaymentsProvider::class, 'payments_provider_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
    	return $this->belongsTo(Post::class, 'post_id');
    }
}
