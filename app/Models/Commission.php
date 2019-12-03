<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model
{
    use Userstamps, SoftDeletes;

    protected $table = 'commissions';
    //
    protected $fillable = [
        'payments_provider_id', 'percentage', 'additional','active'
    ];

     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function transactions()
    {
    	return $this->belongsToMany(Transaction::class, 'commissions_transactions');
    }

    public function providers()
    {
    	return $this->belongsTo(PaymentsProvider::class, 'payments_provider_id');
    }
}
