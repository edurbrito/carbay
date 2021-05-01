<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Auction;
use Error;
use Illuminate\Support\Facades\Validator;

class BidController extends Controller
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
    public function create(Request $request, $id)
    {
        $auction = Auction::find($id);
        $auctionHighestBid = $auction->highest_bid();
        $auctionLastBid = !is_null($auctionHighestBid) ? $auctionHighestBid->value + 0.01 : $auction->startingprice;

        Validator::validate($request->all(), [
            'value' => 'required|numeric|min:' . $auctionLastBid,
        ]);

        if (!Auth::check())
            return redirect('/login');
            
        $this->authorize('create', Bid::class);
        
        try {

            if(is_null($auction) || Auth::user()->id == $auction->sellerid || $auction->finaldate < now() || (!is_null($auctionHighestBid) && $auctionHighestBid->authorid == Auth::user()->id))
                throw new Error();

            $bid = new Bid();
            $bid->datehour = now();
            $bid->value = $request->input('value');
            $bid->auctionid = $id;
            $bid->authorid = Auth::user()->id;
            $bid->save();
        } catch (\Throwable $th) {
            return back()->withErrors(['value' => 'You are not allowed to perform that action']);
        }

        return redirect()->to('auctions/'.$request->input('id'));
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
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function show(Bid $bid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function edit(Bid $bid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bid $bid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bid $bid)
    {
        //
    }
}
