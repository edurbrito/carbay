<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
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
    public function store(Request $request, $id)
    {
        if(!Auth::check())
            return redirect('login');
        else if(Auth::user()->banned)
            return back()->withErrors(['value' => 'This action is not available for banned users.']);

        $this->authorize('rate', Auction::class);

        $auction = Auction::find($id);

        if(is_null($auction))
            return abort(404);

        
        if($auction->suspend)
        {
            return back()->withErrors(['value' => 'This auction is suspended.']);
        }

        Validator::validate($request->all(), [
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string|min:1'
        ]);

        $rr = $request->input('rating');
        $cc = $request->input('comment');

        try {
            if($auction->finaldate > now())
                throw new \Error('You are not allowed to perform that action ');

            $rating = new Rating();
            $rating->auctionid = $auction->id;
            $rating->winnerid = Auth::user()->id;
            $rating->value = $rr;
            $rating->comment = $cc;

            $rating->save();

        } catch (\Throwable $th) {
            return $th->getMessage();
            return back()->withErrors(['value' => 'You are not allowed to perform that action']);
        }

        return back()->withSuccess(['You gave a rating to this auction!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
