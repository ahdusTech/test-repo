<?php

namespace App\Nova;

use App\Nova\Actions\AnonymizeInquiry;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\DateTime;

class Inquiry extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Inquiry::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Anfragen');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Anfrage');
    }

    public static function getParent()
    {
        return 'Resources';
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'email';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'email',
    ];

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'domain' => ['domain'],
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            DateTime::make('Uhrzeit', 'created_at')
                ->format('YYYY-MM-DD HH:mm')
                ->pickerDisplayFormat('Y-m-d H:i')
                ->readonly(),
            BelongsTo::make('Domain'),
            Select::make('Anrede', 'gender')->options([
                'm' => 'Herr',
                'f' => 'Frau',
            ])->displayUsingLabels()->rules('required'),
            Text::make('Vorname', 'prename')->rules('nullable', 'min:2', 'regex:/^[\pL\s\-]+$/u', 'max:255'),
            Text::make('Nachname', 'surname')->rules('required', 'min:2', 'regex:/^[\pL\s\-]+$/u', 'max:255'),
            Text::make('Webseiten-Sprache', 'website_language')->rules('required', 'max:255'),
            Text::make('Browser-Sprache', 'browser_language')->rules('required', 'max:255'),
            Text::make('E-Mail', 'email')->rules('required', 'email:rfc,dns', 'max:255'),
            Text::make('IP', 'ip')->rules('required', 'max:255'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            AnonymizeInquiry::make()->showOnTableRow()
        ];
    }
}
