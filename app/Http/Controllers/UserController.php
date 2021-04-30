<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Auction;
use App\Models\FavouriteSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  String  $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = User::where("username", "=", $username)->first();

        $view = !is_null($user) ? view('pages.profile', ['user' => $user]) : view('errors.404');

        return $view;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function fav_auctions(Request $request, $username)
    {
        $user = User::where("username", "=", $username)->first();
        $fav_auctions = $user->favouriteAuctions;

        if($request->acceptsHtml()) {
            $result = "";

            foreach($fav_auctions as $fav_auction) {
                $result .= view("partials.profile.fav-auction", ["auction" => $fav_auction->auction])->render() . "\n";
            }

            return $result;
        }

        return json_encode($fav_auctions);
    }

    public function sellers(Request $request)
    {
        $id = Auth::check() ? Auth::user()->id : -1;

        $fav_sellers = User::whereIn('id', FavouriteSeller::where('user1id','=',$id)->get('user2id'));

        if($request->acceptsHtml()) {
            $result = "";

            foreach($fav_sellers->get() as $fav_seller) {
                $result .= view("partials.profile.fav-seller", ["seller" => $fav_seller])->render() . "\n";
            }

            return $result;
        }

        $sellers = ['favourites' => $fav_sellers->get(),
                    'all' => User::whereIn('id', Auction::all(['sellerid']))->whereNotIn('id', $fav_sellers->get('id'))->get()];

        return json_encode($sellers);
    }

    public function bids(Request $request, $username)
    {
        $user = User::where("username", "=", $username)->first();
        $bids = $user->bids;

        if($request->acceptsHtml()) {
            $result = "";

            foreach($bids as $bid) {
                $result .= view("partials.profile.bid", ["bid" => $bid])->render() . "\n";
            }

            return $result;
        }

        return json_encode($bids);
    }

    public function auctions(Request $request, $username)
    {
        $user = User::where("username", "=", $username)->first();
        $auctions = $user->auctions;

        if($request->acceptsHtml()) {
            $result = "";

            foreach($auctions as $auction) {
                $result .= view("partials.profile.auction", ["auction" => $auction])->render() . "\n";
            }

            return $result;
        }

        return json_encode($auctions);
    }
}
