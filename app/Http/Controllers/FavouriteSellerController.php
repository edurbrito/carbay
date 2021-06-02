<?php

namespace App\Http\Controllers;

use App\Models\FavouriteSeller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FavouriteSellerController extends Controller
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
        if(!Auth::check())
            return json_encode(["result" => "login"]);

        $validator = Validator::make($request->all(), [
            'seller' => 'required|string|min:1',
        ]);

        $seller = $request->input("seller");
        $user2 = User::where("username", "=", $seller);
        
        if($validator->fails() || !$user2->exists() || Auth::user()->hasFavouriteSeller($user2->first()->id))
        {
            return json_encode(["result" => "error", "content" => [$validator->errors(), $user2->exists(), Auth::user()->hasFavouriteSeller($user2->first()->id)]]);
        }

        try{
            $favouriteSeller = new FavouriteSeller();
            $favouriteSeller->user1id = Auth::user()->id;
            $favouriteSeller->user2id = $user2->first()->id;
            $favouriteSeller->save();
        }
        catch(\Throwable $th)
        {
            return json_encode(["result" => "error", "content" => [$th->getMessage()]]);
        }

        return json_encode(["result" => "success"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FavouriteSeller  $favouriteSeller
     * @return \Illuminate\Http\Response
     */
    public function show(FavouriteSeller $favouriteSeller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FavouriteSeller  $favouriteSeller
     * @return \Illuminate\Http\Response
     */
    public function edit(FavouriteSeller $favouriteSeller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FavouriteSeller  $favouriteSeller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FavouriteSeller $favouriteSeller)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FavouriteSeller  $favouriteSeller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(!Auth::check())
            return json_encode(["result" => "login"]);

        $validator = Validator::make($request->all(), [
            'seller' => 'required|string|min:1',
        ]);

        $seller = $request->input("seller");
        $user2 = User::where("username", "=", $seller);
        
        if($validator->fails() || !$user2->exists() || !Auth::user()->hasFavouriteSeller($user2->first()->id))
        {
            return json_encode(["result" => "error", "content" => [$validator->errors(), $user2->exists(), Auth::user()->hasFavouriteSeller($user2->first()->id)]]);
        }

        try{
            $favouriteSeller = FavouriteSeller::where("user1id", Auth::user()->id)->where("user2id", $user2->first()->id)->first();
            $deleted = $favouriteSeller->delete();
            if(!$deleted)
                throw new Exception("Favourite Seller not removed");
        }
        catch(\Throwable $th)
        {
            return json_encode(["result" => "error", "content_throw" => [$th->getMessage()]]);
        }

        return json_encode(["result" => "success"]);
    }
}
