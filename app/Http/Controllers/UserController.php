<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Auction;
use App\Models\FavouriteSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
     * @param  String  $username
     * @return \Illuminate\Http\Response
     */
    public function edit_profile($username)
    {
        if (!Auth::check() || Auth::user()->username != $username)
            return redirect('users/' . $username);

        $user = User::where("username", "=", $username)->first();

        // $this->authorize('create', Auction::class);

        $view = !is_null($user) ? view('pages.edit-profile', ['user' => $user]) : view('errors.404');

        return $view;
    }

    /**
     * Get the data from the form for editing the specified resource.
     *
     * @param  String  $username
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $username)
    {
        if (!Auth::check() || Auth::user()->username != $username)
            return redirect('/login');

        $user = User::where("username", "=", $username)->first();

        $validated = Validator::validate($request->all(), [
            'name' => 'string|max:255',
            'email' => 'unique:user,email,' . $user->id,
            'current_password' => 'required|string|min:6',
            'new_password' => 'nullable|string|min:6|same:confirm_password',
            'confirm_password' => 'nullable|string|min:6|same:new_password',
            'image-input' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (!password_verify($request->input('current_password'), $user->password)) {
            return back()->withErrors(['match' => 'Wrong Password'])->withInput();
        }

        User::where('id', $user->id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if($request->input('new_password') != null) {
            User::where('id', $user->id)->update([
                'password' => bcrypt($request->input('new_password')),
            ]);
        }

        if ($request->hasFile('image-input')) {
            $image = $request->file('image-input');
            if ($image->isValid()) {
                $image_name = date('mdYHis') . "-" . uniqid() . "-" . Auth::user()->id . ".png";
                $path = base_path() . '/public/images/users';
                $image->move($path, $image_name);

                User::where('id', $user->id)->update([
                    'image' => '/images/users/' . $image_name,
                ]);
            } else {
                return redirect()->back()->with('error', 'Image not valid: ' . $image);
            }
        }

        return redirect()->to('users/' . $username);
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
}
