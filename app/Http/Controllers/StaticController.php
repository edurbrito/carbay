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

        $featured = AuctionController::featured();

        return view('pages.home', ["featured" => $featured]);
    }

    public function about() {
        return view('pages.about');
    }

    public function faqs() {
        return view('pages.faqs');
    }
}
