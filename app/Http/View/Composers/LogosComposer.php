<?php

namespace App\Http\View\Composers;

use App\Logo;
use Illuminate\View\View;

class LogosComposer
{
    /**
     * The logos.
     *
     * @var Logo
     */
    protected $logos;

    /**
     * Create a new logos composer.
     *
     * @param  Logo  $logos
     * @return void
     */
    public function __construct(Logo $logos)
    {
        $this->logos = $logos;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('logos', $this->logos->orderBy('sort')->get());
    }
}
