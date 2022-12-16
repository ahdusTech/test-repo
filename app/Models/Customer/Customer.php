<?php

namespace App\Models\Customer;

use App\Models\Admin\Auction;
use App\Models\Admin\CommonSetting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Customer extends  Authenticatable
{
    use Notifiable, SoftDeletes;

    public  static $guardType = 'customer';
    protected $guard = 'customer';
    protected $with = ['last_ip'];

    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_code',
        'phone_number',
        'phone_number_verified',
        'tax_no',
        'company',
        'road',
        'post_code',
        'place',
        'country',
        'lang',
        'verification_document',
        'account_approved'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function customer_login_security()
    {
        return $this->hasOne(CustomerLoginSecurity::class , 'customer_id', 'id');
    }

    public function full_name()
    {
        return "{$this->first_name}  {$this->last_name}";
    }

    public function last_ip(){
        return $this->hasMany(CustomerLogin::class, 'customer_id', 'id')->latest();
    }
    public function first_ip(){
        return $this->hasOne(CustomerLogin::class, 'customer_id', 'id')->latest();
    }

    public function auctions(){
        return $this->hasMany(CustomerAuction::class, 'customer_id', 'id');
    }

    public function current_level(){
        $customer = $this;
        $current_level = 1;
        if($customer->is_free_email()){
            return $current_level;
        }
        if(!$customer->is_free_email() and ($customer->road and $customer->post_code and $customer->place and $customer->country)){
            $current_level = 2;
            /*return $current_level;*/
        }
        if($customer->phone_number_verified){
            $current_level = 3;
            /*return $current_level;*/
        }
        if($customer->account_approved){
            $current_level = 4;
            /*return $current_level;*/
        }
        return $current_level;

    }

    public function is_free_email(){
        $customer = $this;
        $customer_email_provider = explode('@', $customer->email)[1];
        $black_list = CommonSetting::where('key', 'black_list')->first();
        $black_list = $black_list ? $black_list->value : '';
        return str_contains($black_list, $customer_email_provider);
    }

    public static function check_free_email($email){
        $customer_email_provider = explode('@', $email)[1];
        $black_list = CommonSetting::where('key', 'black_list')->first();
        $black_list = $black_list ? $black_list->value : '';
        return str_contains($black_list, $customer_email_provider);
    }

    public function watchlist(){
        return $this->hasMany(CustomerAuction::class, 'customer_id', 'id')->whereStatus(CustomerAuction::$watchlist);
    }
    public function favourite(){
        return $this->hasMany(CustomerAuction::class, 'customer_id', 'id')->whereStatus(CustomerAuction::$favourite);
    }

    public function domains(){
       return $this->hasMany(Auction::class, 'sold_to', 'id');
    }

    public function favourite_planned_auctions(){
        $user = Auth::guard(Customer::$guardType)->user();
        $user_id = $user->id;
        $now = Carbon::now()->format('Y-m-d H:i:s');
        return CustomerAuction::whereHas('auction',function($q) use ($now) {
                    $q->where('start_date', '>', $now)
                        ->where('sold_at', null)->orderBy('sold_at', 'asc');
                })
                ->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id])
                ->get();
    }

    public function watchlist_planned_auctions(){
        $user = Auth::guard(Customer::$guardType)->user();
        $user_id = $user->id;
        $now = Carbon::now()->format('Y-m-d H:i:s');
        return CustomerAuction::whereHas('auction',function($q) use ($now) {
                    $q->where('start_date', '>', $now)
                        ->where('sold_at', null)->orderBy('sold_at', 'asc');
                })
                ->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id])
                ->get();
    }
    public function my_planned_auctions(){
        $user = Auth::guard(Customer::$guardType)->user();
        $user_id = $user->id;
        $now = Carbon::now()->format('Y-m-d H:i:s');
        return  CustomerAuction::whereHas('auction',function($q) use ($now) {
                    $q->where('start_date', '>', $now)
                        ->where('sold_at', null);
                })
                ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                ->get();
    }
    public function all_planned_auctions(){
        $user = Auth::guard(Customer::$guardType)->user();
        $now = Carbon::now()->format('Y-m-d H:i:s');
        return  Auction::where(function ($q) use ($now) {
                    $q->where('start_date', '>', $now);
                    $q->where('end_date', '>', $now);
                })->where('sold_to', null)->get();
    }

}
