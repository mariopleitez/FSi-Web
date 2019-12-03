<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommissionsTransaction extends Model
{
    use Userstamps, SoftDeletes;

    protected $table = 'commissions_transactions';
    //
    protected $fillable = [
        'commission_id', 'transaction_id', 'amount' , 'comission','active'
    ];

     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
