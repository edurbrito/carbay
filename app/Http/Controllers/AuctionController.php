<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Image;
use App\Models\Colour;
use App\Models\Brand;
use App\Models\User;
use App\Models\Bid;
use App\Models\Comment;
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

    public static function featured()
    {
        $featured = Auction::whereRaw('finaldate > NOW()')->orderBy('finaldate')->limit(5)->get()->sortBy(function ($auction, $key) {
            return count($auction->bids);
        });

        $result = "";
        $active = true;

        foreach ($featured->reverse() as $auction){
            $result .= view("partials.home.featured", ["auction" => $auction, "active" => $active])->render() . "\n";
            $active = false;
        }

        return $result;
    }

    public function create_page()
    {
        if (!Auth::check())
            return redirect('/login');

        $this->authorize('create', Auction::class);

        return view('pages.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!Auth::check())
            return redirect('/login');
        
        $this->authorize('create', Auction::class);

        $validated = Validator::validate($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1023',
            'starting-price' => 'required|numeric|min:1',
            // 'startDate' => 'required|date',
            'duration' => 'required|numeric|min:1|max:7',
            'buy-now' => 'nullable|numeric|gt:starting-price',
            'scale' => Rule::in(['1:8','1:18','1:43','1:64']),
            'brand' => 'required|string|min:1',
            'colour' => 'required|string|min:1'
        ]);

        $auction = new Auction();
        $auction->title = $request->input('title');
        $auction->description = $request->input('description');
        $auction->startingprice = $request->input('starting-price');

        $duration = $request->input('duration');
        $date = now();

        $auction->startdate = $date;
        $auction->finaldate = date('Y-m-d H:i:s', strtotime($date . ' + ' .  $duration . ' days'));
        $auction->suspend = false;

        $auction->buynow = $request->input('buy-now');
        $auction->scaletype = $request->input('scale');

        $brand = Brand::where("name", "=", $request->input("brand"))->first();

        if(is_null($brand)){
            $brand = new Brand();
            $brand->name = $request->input("brand");
            $brand->save();
        }

        $colour = Colour::where("name", "=", $request->input("colour"))->first();

        if(is_null($colour)){
            $colour = new Colour();
            $colour->name = $request->input("colour");
            $colour->save();
        }

        $auction->brandid = $brand->id;
        $auction->colourid = $colour->id;
        
        $auction->sellerid = Auth::user()->id;
        $auction->save();

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $image_name = date('mdYHis') . "-" . uniqid() . "-" . Auth::user()->id . ".png";
                    $path = base_path() . '/public/images/auctions';
                    $image->move($path, $image_name);

                    $img = new Image();
                    $img->url = '/images/auctions/' . $image_name;
                    $img->auctionid = $auction->id;
                    $img->save();
                } else {
                    $auction->delete();
                    return redirect()->back()->with('error', 'Image not valid: ' . $image);
                }
            }
        }
        else{
            $auction->delete();
            return redirect()->back()->with('error', 'Images are required');
        }

        return redirect()->to('auctions/' . $auction->id);
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
        if (!is_numeric($id)) {
            return view('errors.404');
        }

        $auction = Auction::find($id);

        $view = !is_null($auction) ? view('pages.auction', ['auction' => $auction]) : view('errors.404');

        return $view;
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

    public static $scales = [
        ['id' => 0, 'name' => '1:8'],
        ['id' => 1, 'name' => '1:18'],
        ['id' => 2, 'name' => '1:43'],
        ['id' => 3, 'name' => '1:64']
    ];

    public function scales()
    {
        return json_encode(AuctionController::$scales);
    }

    public function get_scale($id)
    {
        if (!is_null($id) && $id >= 0 && $id <= 3)
            return AuctionController::$scales[$id]["name"];
    }

    public function search(Request $request)
    {

        $colourLastID = Colour::max("id");
        $brandLastID = Brand::max("id");
        $sellerLastID = User::max("id");

        $validator = Validator::make($request->all(), [
            'full-text' => 'nullable|string',
            'sort-by' => Rule::in(['0', '1', '2']),
            'order' => Rule::in(['0', '1']),
            'buy-now' => Rule::in(['true', 'false']),
            'ended-auctions' => Rule::in(['true', 'false']),
            'colour' => 'nullable|numeric|between:-1,' . $colourLastID,
            'brand' => 'nullable|numeric|between:-1,' . $brandLastID,
            'scale' => Rule::in(['-1', '0', '1', '2', '3']),
            'seller' => 'nullable|numeric|between:-1,' . $sellerLastID,
            'min-bid' => 'nullable|numeric|gt:0',
            'max-bid' => 'nullable|numeric',
            'max-bid' => 'exclude_unless:min-bid,gt:min-bid',
            'min-buy-now' => 'nullable|numeric|gt:0',
            'max-buy-now' => 'nullable|numeric',
            'max-buy-now' => 'exclude_unless:min-buy-now,gt:min-buy-now'
        ]);

        if ($validator->fails()) {
            return json_encode(["auctions" => [], "errors" => $validator->errors()]);
        }

        $fullText = $request->input('full-text');
        $sortBy = $request->input('sort-by');
        $order = $request->input('order-by');
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

        $auctions = [];

        if (is_null($fullText))
            $auctions = Auction::all();
        else
            $auctions = Auction::whereRaw('auction.search @@ plainto_tsquery(\'english\', ?)', array(strtolower($fullText)))->get();


        if ($seller != "-1") {
            $auctions = $auctions->where("sellerid", "=", $seller);
        }

        if ($colour != "-1") {
            $auctions = $auctions->where("colourid", "=", $colour);
        }

        if ($brand != "-1") {
            $auctions = $auctions->where("brandid", "=", $brand);
        }

        if ($scale != "-1") {
            $auctions = $auctions->where("scaletype", "=", $this->get_scale($scale));
        }

        if (!is_null($minBid)) {
            $auctions = $auctions->filter(function ($auction) use ($minBid) {
                $bid = $auction->highest_bid();
                $value = !is_null($bid) ? $bid->value : -1;
                return $value >= intval($minBid);
            });
        }

        if (!is_null($maxBid)) {
            $auctions = $auctions->filter(function ($auction) use ($maxBid) {
                $bid = $auction->highest_bid();
                $value = !is_null($bid) ? $bid->value : -1;
                return $value <= intval($maxBid);
            });
        }

        if (!is_null($minBuyNow)) {
            $auctions = $auctions->filter(function ($auction) use ($minBuyNow) {
                $buyNow = $auction->buynow;
                $buyNow = !is_null($buyNow) ? $buyNow : -1;
                return $buyNow >= intval($minBuyNow);
            });
        }

        if (!is_null($maxBuyNow)) {
            $auctions = $auctions->filter(function ($auction) use ($maxBuyNow) {
                $buyNow = $auction->buynow;
                $buyNow = !is_null($buyNow) ? $buyNow : -1;
                return $buyNow <= intval($maxBuyNow);
            });
        }

        if (strcmp($buyNow, "false") == 0) {
            $auctions = $auctions->whereNull("buynow");
        }

        if (strcmp($endedAuctions, "false") == 0) {
            $auctions = $auctions->where('finaldate', '>', now());
        }

        $order_ad = strcmp($order, "0") == 0 ? false : true;

        $auctions = $auctions->sortBy(function ($a) use ($sortBy) {
            switch (strcmp($sortBy, "1")) {
                case -1:
                    return $a->finaldate;
                case 0:
                    $highest_bid = $a->highest_bid();
                    return !is_null($highest_bid) ? $highest_bid->value : 0;
                case 1:
                    return $a->buynow;
                default:
                    break;
            }
            return $a->finaldate;
        }, SORT_REGULAR, $order_ad);

        if ($request->acceptsHtml()) {
            $result = "";
            foreach ($auctions as $a) {
                $result .= view("partials.auction", ["auction" => $a])->render() . "\n";
            }

            return $result;
        }

        return json_encode(["auctions" => $auctions, "count" => count($auctions), "errors" => []]);
    }

    public function bids(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return;
        }

        $bids = Bid::where("auctionid", "=", $id)->orderBy("value", "desc")->get();

        if ($request->acceptsHtml()) {
            $result = "";
            foreach ($bids as $bid) {
                $result .= view("partials.auction.bid", ["bid" => $bid])->render() . "\n";
            }

            return $result;
        }

        return json_encode($bids);
    }

    public function comments(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return;
        }

        $comments = Comment::where("auctionid", "=", $id)->orderBy("datehour", "desc")->get();

        if ($request->acceptsHtml()) {
            $result = "";
            foreach ($comments as $comment) {
                $result .= view("partials.auction.comment", ["comment" => $comment])->render() . "\n";
            }

            return $result;
        }

        return json_encode($comments);
    }
}
