<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class DomainTitle extends Filter
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
    public $name = 'Titel vorhanden?';

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
                $query->whereNotNull('title')
                    ->where('title', '!=', '');
            });
        }

        if ($value == 'no') {
            return $query->where(function($query) {
                $query->whereNull('title')
                    ->orWhere('title', '');
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
