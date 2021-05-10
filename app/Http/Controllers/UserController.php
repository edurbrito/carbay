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
    public function index(Request $request)
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
     * @param  String  $username
     * @return \Illuminate\Http\Response
     */
    public function edit($username)
    {
        if (!Auth::check())
            return redirect('login');

        $this->authorize('update', User::class);

        $user = Auth::user();

        return view('pages.edit-profile', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $username)
    {
        if (!Auth::check())
            return redirect('/login');

        $this->authorize('update', User::class);

        $user = Auth::user();

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

        return redirect()->to('users/' . $user->username);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($username)
    {
        if(!Auth::check())
            return redirect('login');

        $this->authorize('delete', User::class);

        $userid = Auth::user()->id;

        try {
            User::destroy($userid);
            Auth::logout();
        } catch(\Throwable $qe) {
            return back()->withErrors(['error' => "You can't delete your account if you still have active auctions or any highest bid!"]);
        }

        return redirect('/');
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

            return json_encode(["result" => "success", "content" => $result]);
        }

        return json_encode(["result" => "success", "content" => $fav_auctions]);
    }

    // TODO: Review this maybe separate into two: 1 for the search api and other for the profile
    public function sellers(Request $request)
    {
        $id = Auth::check() ? Auth::user()->id : -1;

        $fav_sellers = User::whereIn('id', FavouriteSeller::where('user1id','=',$id)->get('user2id'));

        if($request->acceptsHtml()) {
            $result = "";

            foreach($fav_sellers->get() as $fav_seller) {
                $result .= view("partials.profile.fav-seller", ["seller" => $fav_seller])->render() . "\n";
            }

            return json_encode(["result" => "success", "content" => $result]);
        }

        $sellers = ['favourites' => $fav_sellers->get(),
                    'all' => User::whereIn('id', Auction::all(['sellerid']))->whereNotIn('id', $fav_sellers->get('id'))->get()];

        return json_encode(["result" => "success", "content" => $sellers]);
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

            return json_encode(["result" => "success", "content" => $result]);
        }

        return json_encode(["result" => "success", "content" => $bids]);
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

            return json_encode(["result" => "success", "content" => $result]);
        }

        return json_encode(["result" => "success", "content" => $auctions]);
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

            return json_encode(["result" => "success", "content" => $result]);
        }

        return json_encode(["result" => "success", "content" => $ratings]);
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

            return json_encode(["result" => "success", "content" => $result]);
        }

        return json_encode(["result" => "success", "content" => $rated]);
    }

    public function admin()
    {
        if(!Auth::check())
            return redirect('login');

        $this->authorize('admin', User::class);

        return Auth::user()->admin ? view('pages.admin') : abort(404);
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
