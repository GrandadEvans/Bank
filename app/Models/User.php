<?php

namespace Bank\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'badges' => 'object'
    ];


//    public function getBadgesAttribute()
//    {
//        return json_encode($this->badges);
//    }

    public function transactions()
    {
        return $this->hasMany('Bank\Transaction');
    }

    public function regulars()
    {
        return $this->hasMany('Bank\Regular');
    }
}
