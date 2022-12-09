<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class AnonymizeInquiry extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Anfrage anonymisieren';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->update([
                'prename' => !$model->prename ?: str_replace(substr($model->prename, '2'), str_repeat('*', strlen($model->prename) - 2), $model->prename),
                'surname' => str_replace(substr($model->surname, '2'), str_repeat('*', strlen($model->surname) - 2), $model->surname),
                'email' => str_replace(substr($model->email, '2'), str_repeat('*', strlen($model->email) - 2), $model->email),
                'ip' => !$model->ip ?: str_replace(substr($model->ip, '2'), str_repeat('*', strlen($model->ip) - 2), $model->ip),
            ]);

            $model->delete();
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
