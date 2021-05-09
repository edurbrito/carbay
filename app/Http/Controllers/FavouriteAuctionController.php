<?php

namespace App\Http\Controllers;

use App\Models\FavouriteAuction;
use App\Models\Auction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FavouriteAuctionController extends Controller
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
            'auction' => 'required|numeric|min:1',
        ]);

        $auctionid = $request->input("auction");
        $auction = Auction::where("id", $auctionid);
        
        if($validator->fails() || !$auction->exists() || Auth::user()->hasFavouriteAuction($auction->first()->id))
        {
            return json_encode(["result" => "error", "content" => [$validator->errors(), $auction->exists(), Auth::user()->hasFavouriteAuction($auction->first()->id)]]);
        }

        try{
            $favouriteAuction = new FavouriteAuction();
            $favouriteAuction->userid = Auth::user()->id;
            $favouriteAuction->auctionid = $auction->first()->id;
            $favouriteAuction->save();
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
     * @param  \App\Models\FavouriteAuction  $favouriteAuction
     * @return \Illuminate\Http\Response
     */
    public function show(FavouriteAuction $favouriteAuction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FavouriteAuction  $favouriteAuction
     * @return \Illuminate\Http\Response
     */
    public function edit(FavouriteAuction $favouriteAuction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FavouriteAuction  $favouriteAuction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FavouriteAuction $favouriteAuction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FavouriteAuction  $favouriteAuction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(!Auth::check())
            return json_encode(["result" => "login"]);

        $validator = Validator::make($request->all(), [
            'auction' => 'required|numeric|min:1',
        ]);

        $auctionid = $request->input("auction");
        $auction = Auction::where("id", $auctionid);
        
        if($validator->fails() || !$auction->exists() || !Auth::user()->hasFavouriteAuction($auction->first()->id))
        {
            return json_encode(["result" => "error", "content" => [$validator->errors(), $auction->exists(), Auth::user()->hasFavouriteAuction($auction->first()->id)]]);
        }

        try{
            $favouriteAuction = FavouriteAuction::where("userid", Auth::user()->id)->where("auctionid", $auction->first()->id)->first();
            $deleted = $favouriteAuction->delete();
            if(!$deleted)
                throw new Exception("Favourite Auction not removed");
        }
        catch(\Throwable $th)
        {
            return json_encode(["result" => "error", "content_throw" => [$th->getMessage()]]);
        }

        return json_encode(["result" => "success"]);
    }
}
