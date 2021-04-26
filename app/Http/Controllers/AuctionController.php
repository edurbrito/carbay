<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function scales() {
        return json_encode([
            ['id' => 0, 'name' => '1:8'],
            ['id' => 1, 'name' => '1:18'],
            ['id' => 2, 'name' => '1:43'],
            ['id' => 3, 'name' => '1:64']]);
    }

    public function search(Request $request) {
        $fullText = $request->input('full-text');
        $sortBy = $request->input('sort-by');
        $order = $request->input('order');
        $buyNow = $request->input('buy-now');
        $endedAuctions = $request->input('ended-auctions');
        $colour = $request->input('colour');
        $brand = $request->input('brand');
        $scale = $request->input('scale');
        $seller = $request->input('seller');
        $minBid = $request->input('min-bid');
        $maxBid = $request->input('max-bid');
        $minBuyNow = $request->input('min-buy-now');
        $maxBuyNow = $request->input('max-buy-now');

        $afterSortBy = sortBy($sortBy)
        $afterOrder = sortBy($order)

        $colourLastID = Colour::latest()->id;
        $brandLastID = Brand::latest()->id;
        $colourLastID = Colour::latest()->id;
        $sellerLastID = Seller::latest()->id;

        $validated = $request->validate([
            'full-text' => 'nullable|string',
            'sort-by' => Rule::in(['0','1','2']),
            'order' => Rule::in(['0','1']),
            'buyNow' => Rule::in(['0','1']),
            'endedAuctions' => Rule::in(['0','1']),
            'colour' => 'nullable|numeric|between:0,' . $colourLastID,
            'brand' => 'nullable|numeric|between:0,' . $brandLastID,
            'scale' => Rule::in(['0','1','2','3']),
            'seller' => 'nullable|numeric|between:0,' . $sellerLastID,
            'minBid' => 'nullable|numeric|lt:maxBid|gt:0',
            'maxBid' => 'nullable|numeric|gt:minBid',
            'minBuyNow' => 'nullable|numeric|lt:maxBuyNow|gt:0',
            'maxBuyNow' => 'nullable|numeric|gt:minBuyNow',
        ]);

        return json_encode($request);
    }

    public function create_page() {
        return view('pages.create');
    }
}
