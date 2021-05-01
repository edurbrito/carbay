<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Error;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|min:5|max:300',
        ]);

        if(!Auth::check())
            return redirect('/login');

        $this->authorize('create', Comment::class);

        try {

            if(!is_numeric($id) || $validator->fails() || is_null(Auction::find($id)))
                throw new Error();

            $comment = new Comment();
            $comment->datehour = now();
            $comment->text = $request->input("comment");
            $comment->authorid = Auth::user()->id;
            $comment->auctionid = $id;
            $comment->save();
        } catch (\Throwable $th) {
            return json_encode(["result" => $validator->errors()]);
        }

        return json_encode(["result" => "success"]);
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
