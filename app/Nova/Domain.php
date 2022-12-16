<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
// use Spatie\NovaTranslatable\Translatable;

class Domain extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Domain::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Domains');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Domain');
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
    public static $title = 'domain';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'domain',
        'title',
        'adomino_com_id',
        'landingpage_mode',
        'info'
    ];

    public static $perPageOptions = [2000];

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
            Text::make('Info', function () {
                $info = '';
                if (!empty($this->getTranslation('info', 'de'))) {
                    $info .= 'd';
                }
                if (!empty($this->getTranslation('info', 'en'))) {
                    $info .= 'e';
                }
                return $info;
            }),
            Text::make('Domain')->rules('required', 'max:255')->sortable(),
            Text::make('Titel', 'title')->rules('max:255'),
            Number::make('adomino.com ID', 'adomino_com_id')->rules('unique:domains,adomino_com_id,' . $this->id)->sortable(),
//                ->rules('min:0')->readonly(),
            Select::make('Landingpage-Modus', 'landingpage_mode')->options([
                'price_evaluation' => 'Domain Preis-Evaluierung',
                'review' => 'Domain in Prüfung',
                'request_offer' => 'Angebot anfordern',
                'sold' => 'Domain verkauft',
                'auction_preparing' => 'Auktion in Vorbereitung',
                'auction_soon' => 'Auktion startet in Kürze',
                'auction_active' => 'Auktion Aktiv',
                'auction_not_sold' => 'Auktion beendet ohne Verkauf',
                'auction_sold' => 'Auktion Domain verkauft',
            ])->displayUsingLabels()->default('request_offer'),
            Translatable::make([
                Textarea::make('Info'),
            ]),
            HasMany::make('Anfragen', 'inquiries', Inquiry::class),
            Boolean::make('Brandable', 'brandable')
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
        return [
            new Filters\DomainInfoDe,
            new Filters\DomainInfoEn,
            new Filters\DomainTitle
        ];
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
        return [];
    }
}
