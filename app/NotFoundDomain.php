<?php

namespace App;

use App\Traits\SetGetDomain;
use Illuminate\Database\Eloquent\Model;

class NotFoundDomain extends Model
{
    use SetGetDomain;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'created_at', 'updated_at',
    ];

    public static function saveDomain($domainArray)
    {
        if (isset($domainArray['id']))
            $domain = NotFoundDomain::find($domainArray['id']);
        else
            $domain = new NotFoundDomain();
        foreach ($domainArray as $domain_col => $domain_val) {
            if ($domain_col == 'created_at')
                $domain->$domain_col = date('Y-m-d H:i:s', strtotime($domain_val));
            else
                $domain->$domain_col = $domain_val;
        }
        $domain->save();
    }

    public static function getDomain($id)
    {
        return NotFoundDomain::find($id);
    }

    public static function deleteDomain($id)
    {
        return NotFoundDomain::find($id)->delete();
    }

    public static function deleteAllDomain()
    {
        return NotFoundDomain::truncate();
    }
}
