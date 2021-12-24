<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use DB;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    protected $guard = 'admin';
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','created_at', 'updated_at', 'isActive', 'isDelete'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function update_role($user_id, $role_id)
    {
        return DB::table('role_user')->updateOrInsert( ['user_id' => $user_id],['role_id' => $role_id]);
    }
}
