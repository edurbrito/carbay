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

        $view = !is_null($user) ? view('pages.profile', ['user' => $user]) : abort(404);

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

    public function ratings(Request $request, $username)
    {
        $user = User::where("username", "=", $username)->first();
        $ratings = $user->ratings();

        if($request->acceptsHtml()) {
            $result = "";

            foreach($ratings as $rating) {
                $user_rating = User::where('id','=',$rating->winnerid)->first();
                $result .= view("partials.profile.rating", ["rating" => $rating, "user" => $user_rating])->render() . "\n";
            }

            return $result;
        }

        return json_encode($ratings);
    }

    public function rated(Request $request, $username)
    {
        $user = User::where("username", "=", $username)->first();
        $rated = $user->rated;

        if($request->acceptsHtml()) {
            $result = "";

            foreach($rated as $rate) {
                $auction = Auction::where('id','=',$rate->auctionid)->first();
                $result .= view("partials.profile.rated", ["rated" => $rate, "seller" => $auction->seller])->render() . "\n";
            }

            return $result;
        }

        return json_encode($rated);
    }

    public function admin()
    {
        if(!Auth::check())
            return redirect('login');

        $this->authorize('admin', User::class);

        return Auth::user()->admin ? view('pages.admin') : abort(404);
    }

    public function users(Request $request)
    {
        if(!Auth::check())
            return json_encode(["result" => "login"]);

        $this->authorize('admin', User::class);

        $users = User::where('admin', false)->orderBy('name')->paginate(12);

        if($request->acceptsHtml()){
            $html_users = "";

            foreach($users as $user) {
                $html_users .= view("partials.admin.user-management", ["user" => $user])->render() . "\n";
            }

            $html_links = view("partials.admin.links", ['objects' => $users])->render();

            return json_encode(["result" => "success", "content" => ["users" => $html_users, "links" => $html_links]]);
        }

        return json_encode(["result" => "success", "content" => $users]);
    }

    public function make_admin($username)
    {
        if(!Auth::check())
            return redirect('login');

        $this->authorize('admin', User::class);

        $user = User::where('username',"=",$username)->first();

        if (!$user->admin)
        {
            $user->admin = true;
            $user->save();
        }

        return redirect('/admin');
    }

    public function ban($username){
        
        if(!Auth::check())
            return redirect('login');

        $this->authorize('admin', User::class);

        $user = User::where('username',"=",$username)->first();

        $user->banned = !$user->banned;
        $user->save();

        return redirect('/admin');
    }
}
