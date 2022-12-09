<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Logo extends Model implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'created_at', 'updated_at',
    ];

    public static function deleteLogo($id)
    {
        return Logo::find($id)->delete();
    }

    public static function getLogo($id)
    {
        return Logo::find($id);
    }

    public static function saveLogo($logoArray)
    {
        if (isset($logoArray['id']))
            $logo = Logo::find($logoArray['id']);
        else
            $logo = new Logo();
        foreach ($logoArray as $logo_col => $logo_val) {
            $logo->$logo_col = $logo_val;
        }
        $logo->save();
    }

    public static function getLastSortNumber()
    {
        $leastSortRecords = Logo::orderBy('sort', 'desc')->first();
        return $leastSortRecords->sort;
    }

    public static function sortLogo($mode, $id)
    {
        $logo = Logo::find($id);
        if (isset($logo->id) && !empty($logo->id)) {
            $currentSort = $logo->sort;
            if ($mode == 'up') {
                $newSort = ($currentSort - 1);
            } elseif ($mode == 'down') {
                $newSort = ($currentSort + 1);
            }
            if (isset($newSort)) {
                $sortedLogo = Logo::where('sort', $newSort)->first();
                if (isset($sortedLogo->id) && !empty($sortedLogo->id)) {
                    $sortedLogo->sort = $currentSort;
                    $sortedLogo->save();
                }
                $logo->sort = $newSort;
                $logo->save();
            }
        }
    }
}
