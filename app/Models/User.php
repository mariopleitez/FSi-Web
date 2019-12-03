<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes, Billable;


    const USUARIO_VERIFICADO    = '1';
    const USUARIO_NO_VERIFICADO = '0';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
       return $this->hasOne(Profile::class);
    }

    public function role()
    {
       return $this->belongsToMany(Role::class, "roles_users","user_id", "role_id");
    }


    public function subscripcion()
    {
        return $this->hasMany(Subscription::class);
    }


    public function getsubscripcions()
    {
        return $this->hasMany(Subscription::class)->whereNull('ends_at');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function hasAnyRole($roles)
    {

        if (!$roles) {
           return false;
        }elseif (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        }else{
            if ($this->hasRole($roles)) {
                    return true;
            }
        }

        return false;
    }

    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }

    public function hasRole($role)
    {
       if ($this->role()->where("name", $role)->first()) {
            return true;
        }
        return false;
    }

    public function userIsActivated()
    {
        if ($this->active) {
            return true;
        }
        return false;
    }

    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }

    public function esVerificado()
    {
        return $this->active == User::USUARIO_VERIFICADO;
    }

    public static function generarVerificationToken()
    {
        return str_random(40);
    }

    public function like()
    {
        return $this->belongsToMany(Relation::class, "posts_relations_users", "user_id", "relation_id");        
    }

}
