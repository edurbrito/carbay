<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        date_default_timezone_set("Europe/Lisbon");

        $auctions = Auction::whereRaw('finaldate > NOW()')->orderBy('finaldate')->get();
        return view('pages.search', ['total' => sizeof($auctions), 'auctions' => $auctions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $auction = new Auction();
        $auction->title = $request->input('title');
        $auction->description = $request->input('description');
        $auction->startingprice = $request->input('startingPrice');
        $auction->startdate = $request->input('startDate');
        $duration = $request->input('duration');
        $date = $request->input('startDate');
        $auction->finaldate = date('Y-m-d', strtotime($date. ' + ' .  $duration . ' days'));
        $auction->suspend = false;
        $auction->buynow = $request->input('buyNow');
        $auction->scaletype = $request->input('scaleType');
        $auction->brandid = $request->input('brandID');
        $auction->colourid = $request->input('colourID');
        $auction->sellerid = Auth::user()->id;
        $auction->save();
        return redirect()->to('auctions/'.$auction->id);
    }

     /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1023',
            'startingPrice' => 'required|number|min:1|max:100000',
            'startDate' => 'required|date',
            'duration' => 'required|int|min:1|max:7',
            'buyNow' => 'required|number|min:0|max:1000000',
            'scaleType' => 'string',
            'brandID' => 'required|int|min:0',
            'coulourID' => 'required|int|min:0' 
        ]);
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $auction = Auction::find($id);

        return view('pages.auction', ['auction' => $auction]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function edit(Auction $auction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auction $auction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction $auction)
    {
        //
    }

    public function search(Request $request) {
        return json_encode($request);
    }

    public function create_page(){
        return view('pages.create');
    }
}
