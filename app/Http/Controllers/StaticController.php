<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function imprint() {
        return view('static.imprint');
    }

    public function dataPrivacy() {
        return view('static.data_privacy');
    }
    public function agb() {
        return view('static.agb');
    }
    public function imageLicences() {
        return view('static.imageLicences');
    }
}
