<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Colour;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

        $colourLastID = Colour::latest()->id;
        $brandLastID = Brand::latest()->id;
        $sellerLastID = User::latest()->id;

        $validator = Validator::make($request->all(), [
            'full-text' => 'nullable|string',
            'sort-by' => Rule::in(['0','1','2']),
            'order' => Rule::in(['0','1']),
            'buy-now' => Rule::in(['true','false']),
            'ended-auctions' => Rule::in(['true','false']),
            'colour' => 'nullable|numeric|between:-1,' . $colourLastID,
            'brand' => 'nullable|numeric|between:-1,' . $brandLastID,
            'scale' => Rule::in(['-1','0','1','2','3']),
            'seller' => 'nullable|numeric|between:-1,' . $sellerLastID,
            'min-bid' => 'nullable|numeric|lt:maxBid|gt:0',
            'max-bid' => 'nullable|numeric|gt:minBid',
            'min-buy-now' => 'nullable|numeric|lt:maxBuyNow|gt:0',
            'max-buy-now' => 'nullable|numeric|gt:minBuyNow',
        ]);

        if ($validator->fails()) {
            return json_encode(["auctions" => [], "errors" => $validator->errors()]);
        }

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

        $auctions = Auction::all();

        if($seller != "-1") {
            // SELECT * FROM Auction WHERE sellerID = $seller;
            $auctions = $auctions->where("sellerid","=",$seller)->get();
        }

        

        if ($buyNow) {
            // SELECT * FROM Auction WHERE buyNow IS NOT NULL;
            
        }

        // $afterSortBy = sortBy($sortBy);
        // $afterOrder = sortBy($order);

        return json_encode(["auctions" => $auctions, "errors" => []]);
    }

    public function create_page() {
        return view('pages.create');
    }
}
