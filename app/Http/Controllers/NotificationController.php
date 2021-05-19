<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
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
        //
    }

    public function get_text(Notification $notification)
    {
        if(!is_null($notification->contextrating))
            return sprintf("%d", $notification->contextrating);
        else if(!is_null($notification->contextfavseller))
            return ["url" => "/auctions/" . $notification->contextfavseller, "text" => sprintf("The seller %s has just created an auction!", $notification->fav_seller->seller->username)];
        else if(!is_null($notification->contextbid))
            return ["url" => "/auctions/" . $notification->contextbid, "text" => sprintf("Your bid in the auction %s has just been surpassed!", $notification->bid->title)];
        else if(!is_null($notification->contextfavauction))
            return ["url" => "/auctions/" . $notification->contextfavauction, "text" => sprintf("The auction %s has 10 minutes left!", $notification->fav_auction->title)];
        else
            return ["url" => "/", "text" => "Do not miss our best auctions!"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if(!Auth::check())
            return json_encode(["result" => "login"]);

        $notifications = Notification::where("recipientid", "=", Auth::user()->id)->whereRaw("viewed = FALSE")->limit(5)->orderBy("id", "desc")->get();
        $result = [];

        foreach($notifications as $notification){
            
            if(is_null($notification->contexthelpmessage))
                array_push($result, ["id" => $notification->id , "content" => $this->get_text($notification)]);
        }

        return json_encode(["result" => "success", "content" => $result]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!Auth::check())
            return json_encode(["result" => "login"]);

        $validated = Validator::make($request->all(), [
            'id' => 'required|numeric|min:1',
        ]);

        if($validated->fails())
            return json_encode(["result" => "error", "content" => "Invalid notification id."]);
        
        $notification = Notification::find($request->input('id'));

        if($notification->recipientid == Auth::user()->id){
            $notification->viewed = "TRUE";
            $notification->save();
            return $this->show();
        }
        return json_encode(["result" => "error", "content" => "Invalid notification id."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
