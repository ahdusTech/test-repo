<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword; // Or the location that you store your notifications (this is default).

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'position',
        'name',
        'last_name',
        'company',
        'road',
        'post_code',
        'place',
        'country',
        'lang',
        'email',
        'transfer_out_code',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected const SuperAdmin = 0;
    protected const Admin = 1;
    const Customer = 2;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function loginSecurity()
    {
        return $this->hasOne('App\LoginSecurity');
    }

    public static function clearSession($session_name)
    {
        $session_datas = session()->all();
        foreach ($session_datas as $key => $session_data) {
            if (strpos($key, "_table") !== false && $key != $session_name) {
                session([$key => []]);
            }
        }
    }

    public static function addUser($user_detail_array)
    {
        $user = new User();
        foreach ($user_detail_array as $user_col => $user_val)
            $user->$user_col = $user_val;
        $user->save();
    }

    public static function updateUser($user_detail_array, $id)
    {
        $user = User::find($id);
        foreach ($user_detail_array as $user_col => $user_val)
            $user->$user_col = $user_val;
        $user->save();
    }

    public static function deleteUser($id)
    {
        return User::find($id)->delete();
    }

    public static function getUser($id)
    {
        return User::find($id);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function isAdmin(){
        if($this->role != 2) return true;
        return false;
    }
    public function isCustomer(){
        if($this->role == 2) return true;
        return false;
    }

    public function full_name()
    {
        return "{$this->name}  {$this->last_name}";
    }



}
