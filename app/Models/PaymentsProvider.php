<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentsProvider extends Model
{
    use Userstamps, SoftDeletes;

    protected $table = 'payments_providers';
    //
    protected $fillable = [
        'name' , 'active', ''
    ];

     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function transactions()
    {
    	return $this->hasMany(Transaction::class);
    }

    public function active_commision()
    {
        return $this->hasMany(Commission::class)->where("active", "=", 1);
    }
}
