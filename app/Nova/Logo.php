<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;
use Intervention\Image\Facades\Image as Cropper;
use Illuminate\Support\Str;
use MichielKempen\NovaOrderField\Orderable;
use MichielKempen\NovaOrderField\OrderField;

class Logo extends Resource
{
    use Orderable;

    public static $defaultOrderField;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Logo::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Logos');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Logo');
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
    public static $title = 'purchased_domain';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'purchased_domain',
    ];

    /**
     * The pagination per-page options configured for this resource.
     *
     * @return array
     */
    public static $perPageOptions = [100];

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

            Boolean::make('Aktiv?', 'active')->rules('required'),

            Image::make('Logo', 'logo')
                ->store(function (Request $request) {

                    $fileName = Str::uuid() . '.' . $request->logo->extension();

                    $storagePath = 'public/logos/';

                    $path = storage_path('app/' . $storagePath . $fileName);

                    if (!Storage::disk('local')->exists($storagePath)) {
                        Storage::disk('local')->makeDirectory($storagePath);
                    }

                    Cropper::make($request->logo)->resize(80, 40, function ($c) {
                        $c->aspectRatio();
                    })->resizeCanvas(80, 40, 'center', false, array(255, 255, 255, 0))
                        ->save($path);

                    return '/logos/' . $fileName;
                })
                ->maxWidth(80)
                ->creationRules('required'),

            Text::make('Verkaufte Domain', 'purchased_domain')
                ->sortable()
                ->rules('required', 'max:255'),

            OrderField::make('Sortierung', 'sort'),
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
        return [];
    }
}
