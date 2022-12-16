<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class DomainInfoEn extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Info-Text (EN) vorhanden?';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if ($value == 'yes') {
            return $query->where(function($query) {
                $query->whereNotNull('info->en')
                    ->where('info->en', '!=', '');
            });
        }

        if ($value == 'no') {
            return $query->where(function($query) {
                $query->whereNull('info->en')
                    ->orWhere('info->en', '');
            });
        }
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Ja' => 'yes',
            'Nein' => 'no',
        ];
    }
}
