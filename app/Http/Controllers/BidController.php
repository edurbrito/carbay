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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return;
        }

        $bids = Bid::where("auctionid", "=", $id)->orderBy("value", "desc")->limit(10)->get();

        if ($request->acceptsHtml()) {
            $result = "";
            foreach ($bids as $bid) {
                $result .= view("partials.auction.bid", ["bid" => $bid])->render() . "\n";
            }

            return json_encode(["result" => "success", "content" => $result]);
        }

        return json_encode(["result" => "success", "content" => $bids]);
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
    public function store(Request $request, $id)
    {
        if (!Auth::check())
            return redirect('/login');
        else if(Auth::user()->banned)
            return back()->withErrors(['value' => 'This action is not available for banned users.']);

        $this->authorize('create', Bid::class);
        
        $auction = Auction::find($id);
        $auctionHighestBid = $auction->highest_bid();
        $auctionLastBid = !is_null($auctionHighestBid) ? $auctionHighestBid->value + 0.01 : $auction->startingprice;

        Validator::validate($request->all(), [
            'value' => 'required|numeric|min:' . $auctionLastBid,
        ]);
        
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
