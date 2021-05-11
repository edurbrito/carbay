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
    public function index(Request $request)
    {
        if(!Auth::check())
            return json_encode(["result" => "login"]);

        $this->authorize('admin', User::class);
        
        $validated = Validator::make($request->all(), [
            'search' => 'nullable|string|max:255'
        ]);

        if($validated->fails())
            return json_encode(["result" => "error", "content" => $validated->errors()]);

        $auctions = Auction::whereRaw('finaldate > NOW()');

        $search = $request->input('search');
        if(!is_null($search) && !empty($search)){
            $auctions = $auctions->whereRaw('(auction.search @@ plainto_tsquery(\'english\', ?) OR auction.title LIKE ?)', array(strtolower($search), '%' . $search . '%'));
        }

        $auctions = $auctions->paginate(12);

        if($request->acceptsHtml()){
            $html_auctions = "";

            foreach($auctions as $auction) {
                $html_auctions .= view("partials.admin.auction-management", ["auction" => $auction])->render() . "\n";
            }

            $html_links = view("partials.admin.links", ['objects' => $auctions])->render();

            return json_encode(["result" => "success", "content" => ["auctions" => $html_auctions, "links" => $html_links]]);
        }

        return json_encode(["result" => "success", "content" => $auctions]);
    }

    /**
     * Display a listing of the featured resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function featured(Request $request)
    {
        $featured = Auction::whereRaw('finaldate > NOW()')->orderBy('finaldate')->limit(5)->get()->sortBy(function ($auction, $key) {
            return count($auction->bids);
        });

        if ($request->acceptsHtml()) {
            $result = "";
            $active = true;

            foreach ($featured->reverse() as $auction){
                $result .= view("partials.home.featured", ["auction" => $auction, "active" => $active])->render() . "\n";
                $active = false;
            }
            return json_encode(["result" => "success", "content" => $result]);
        }

        return json_encode(["result" => "success", "content" => $featured]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::check())
            return redirect('/login');
        else if(Auth::user()->banned)
            return redirect('/users/' . Auth::user()->username);

        $this->authorize('create', Auction::class);

        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::check())
            return redirect('/login');
        else if(Auth::user()->banned)
            return redirect('/users/' . Auth::user()->username);
        
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
        
        date_default_timezone_set("Europe/Lisbon");

        $date = date('Y-m-d H:i:s');

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
     * Display the specified resource.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!is_numeric($id)) {
            return abort(404);
        }

        $auction = Auction::find($id);

        $view = !is_null($auction) ? view('pages.auction', ['auction' => $auction]) : abort(404);

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
        return json_encode(["result" => "success", "content" => AuctionController::$scales]);
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
            return json_encode(["result" => "error", "content" => $validator->errors()]);
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

        date_default_timezone_set("Europe/Lisbon");

        if (is_null($fullText))
            $auctions = Auction::where("id",">","-1");
        else
            $auctions = Auction::whereRaw('auction.search @@ plainto_tsquery(\'english\', ?)', array(strtolower($fullText)));


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
            $auctions = $auctions->whereNotNull("highestbid")->where("highestbid", ">=", $minBid);
        }

        if (!is_null($maxBid)) {
            $auctions = $auctions->whereNotNull("highestbid")->where("highestbid", "<=", $maxBid);
        }

        if (!is_null($minBuyNow)) {
            $auctions = $auctions->whereNotNull("buynow")->where("buynow", ">=", $minBuyNow);
        }

        if (!is_null($maxBuyNow)) {
            $auctions = $auctions->whereNotNull("buynow")->where("buynow", "<=", $maxBuyNow);
        }

        if (strcmp($buyNow, "false") == 0) {
            $auctions = $auctions->whereNull("buynow");
        }

        if (strcmp($endedAuctions, "false") == 0) {
            $auctions = $auctions->where('finaldate', '>', now());
        }
        
        $html_auctions = "";
        $html_total = "No Auction found";
        $html_links = "";

        if($auctions->count() == 0){
            
            if ($request->acceptsHtml()) {
                return json_encode(["result" => "success", "content" => ["auctions" => $html_auctions, "total" => $html_total, "links" => $html_links]]);       
            }

            return json_encode(["result" => "success", "content" => ""]);
        }

        $order = strcmp($order, "0") == 0 ? "asc" : "desc";

        $sort = "finaldate";

        switch (strcmp($sortBy, "1")){
                case -1:
                    $sort = "finaldate";
                    break;
                case 0:
                    $sort = "highestbid";
                    $auctions = $auctions->whereNotNull("highestbid");
                    break;
                case 1:
                    $sort = "buynow";
                    $auctions = $auctions->whereNotNull("buynow");
                    break;
                default:
                    break;
        }
        $auctions = $auctions->orderBy($sort, $order);

        $auctions = $auctions->paginate(12);

        if ($request->acceptsHtml()) {
            $html_auctions = "";
            $html_total = view("partials.search.total", ["auctions" => $auctions])->render();
            $html_links = view("partials.search.links", ["auctions" => $auctions])->render();
            foreach ($auctions as $a) {
                $html_auctions .= view("partials.search.auction", ["auction" => $a])->render() . "\n";
            }

            return json_encode(["result" => "success", "content" => ["auctions" => $html_auctions, "total" => $html_total, "links" => $html_links]]);
        }

        return json_encode(["result" => "success", "content" => $auctions]);
    }
}