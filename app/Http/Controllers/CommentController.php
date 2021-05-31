<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CommentController extends Controller
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
            return json_encode(["result" => "error", "content" => "Non numeric id provided"]);
        }

        $comments = Comment::where("auctionid", "=", $id)->orderBy("datehour", "desc")->limit(10)->get();

        if ($request->acceptsHtml()) {
            $result = "";
            foreach ($comments as $comment) {
                $result .= view("partials.auction.comment", ["comment" => $comment])->render() . "\n";
            }

            return json_encode(["result" => "success", "content" => $result]);
        }

        return json_encode(["result" => "success", "content" => $comments]);
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
            return json_encode(["result" => "login"]);
        else if(Auth::user()->banned)
            return json_encode(["result" => "error", "content" => ['This action is not available for banned users.']]);

        $this->authorize('create', Comment::class);
                
        $auction = Auction::find($id);

        if($auction->suspend)
        {
            return json_encode(["result" => "error", "content" => ['This auction is suspended.']]);
        }
        
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|min:1|max:300',
        ]);

        try {

            if(!is_numeric($id) || $validator->fails() || is_null(Auction::find($id)))
                throw new Error();

            $comment = new Comment();
            $comment->text = $request->input("comment");
            $comment->authorid = Auth::user()->id;
            $comment->auctionid = $id;
            $comment->save();
        } catch (\Throwable $th) {
            return json_encode(["result" => "error", "content" => $validator->errors()]);
        }

        return json_encode(["result" => "success"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
