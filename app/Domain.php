<?php

namespace App;

use App\Models\Admin\Auction;
use App\Traits\SetGetDomain;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Domain extends Model
{
//    use SoftDeletes, HasTranslations, SetGetDomain;
    use SoftDeletes;

//    public $translatable = ['info'];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain',
        'landingpage_mode',
        'title',
    ];
    protected $guarded = [
        'created_at', 'updated_at',
    ];
    public static $price_evaluation = 'price_evaluation';
    public static $review = 'price_evaluation';
    public static $request_offer = 'request_offer';
    public static $sold = 'sold';
    public static $auction_preparing = 'auction_preparing';
    public static $auction_soon = 'auction_soon';
    public static $auction_active = 'auction_active';
    public static $auction_not_sold = 'auction_not_sold';
    public static $auction_sold = 'auction_sold';
    public static $auction_ended = 'auction_ended';

/*
            'auction_soon' => 'Auktion startet in Kürze',
            'auction_active' => 'Auktion Aktiv',
            'auction_not_sold' => 'Auktion beendet ohne Verkauf',
            'auction_sold' => 'Auktion Domain verkauft',*/

    public static function getCountAllDomain()
    {
        return Domain::count();
    }

    public static function findDomainByName($domain)
    {
        return Domain::where('domain', $domain)->first();
    }

    public static function displayDomain($domain, $domainId)
    {
        return "<a  href='" . route('edit-domain', [$domainId]) . "'><img src='" . url('/img/wpage.gif') . "' style='margin-right:10px;' /></a>&nbsp;" . '<a style="color:rgb(0 0 153)" href="http://' . $domain . '" target="_blank">' . $domain . '</a>';
    }

    public static function deleteDomain($id)
    {
        return Domain::find($id)->delete();
    }

    public static function getDomain($id)
    {
        return Domain::find($id);
    }

    public static function getAllDomain($paginate = false)
    {
        if ($paginate) {
            return Domain::select('id', 'domain as text')->paginate(2000);
        }
    }

    public static function saveDomain($domainArray)
    {
        if (isset($domainArray['id']))
            $domain = Domain::find($domainArray['id']);
        else
            $domain = new Domain();
        foreach ($domainArray as $domain_col => $domain_val) {
            $domain->$domain_col = $domain_val;
        }
        $domain->save();
    }

    public static function getLandingPageMode()
    {
        return [
            'price_evaluation' => 'Domain Preis-Evaluierung',
            'review' => 'Domain in Prüfung',
            'request_offer' => 'Angebot anfordern',
            'sold' => 'Domain verkauft',
            'auction_preparing' => 'Auktion in Vorbereitung',
            'auction_soon' => 'Auktion startet in Kürze',
            'auction_active' => 'Auktion Aktiv',
            'auction_not_sold' => 'Auktion beendet ohne Verkauf',
            'auction_sold' => 'Auktion Domain verkauft',
            'auction_ended' => 'Beendete Auktion',
        ];
    }

    /**
     * Get the inquiries for the domain.
     */
    public function inquiries()
    {
        return $this->hasMany('App\Inquiry');
    }

    /**
     * Get the visits for the domain.
     */
    public function visits()
    {
        return $this->hasMany('App\Visit');
    }

    /**
     * Get the visits for the domain.
     */
    public function dailyVisits()
    {
        return $this->hasMany('App\DailyVisit');
    }

    /**
     * Get the visits per day record associated with the user.
     */
    public function visitsPerDay()
    {
        return $this->hasOne('App\VisitsPerDay');
    }


    public function isInPlannedAuction(): int
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $domain =  $this->domain;
        $auctions = Auction::where('domain', $domain)->where(function ($q) use ($now) {
            $q->where('start_date', '>', $now);
            $q->where('end_date', '>', $now);
        })->where('sold_to', null)->get();
        /*$auctions = Auction::where('domain', $domain)->where('status', Auction::$planned)->where('sold_to', null)->get();*/
        return count($auctions)  ;
    }
    public function isInActiveAuction(): int
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $domain =  $this->domain;
        $auctions = Auction::where('domain', $domain)->where('start_date', '<', $now)->where('end_date', '>', $now)->where('sold_to', null)->get();
        /*$auctions = Auction::where('domain', $domain)->where('status', Auction::$planned)->where('sold_to', null)->get();*/
        return count($auctions)  ;
    }
    public function isSold(): int
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $domain =  $this->domain;
        $auctions = Auction::where('domain', $domain)->where('end_date', '<', $now)->whereNotNull('sold_to')->get();
        /*$auctions = Auction::where('domain', $domain)->where('status', Auction::$planned)->where('sold_to', null)->get();*/
        return count($auctions)  ;
    }
}
