<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class StaticController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Static Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles redirects to static pages.
    |
    */

    public function home() {
        return view('pages.home');
    }

    public function about() {
        return view('pages.about');
    }

    public function faqs() {
        return view('pages.faqs');
    }

    public function search()
    {
        return view('pages.search');
    }
}
