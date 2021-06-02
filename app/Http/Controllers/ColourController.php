<?php

namespace App\Http\Controllers;

use App\Models\Colour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'search' => 'nullable|string|min:3|max:255'
        ]);
        
        if($validated->fails())
            return json_encode(["error" => "success", "content" => $validated->errors()]);

        $search = strtolower($request->input('search'));
        $colours = Colour::whereRaw('LOWER(name) LIKE ?',["%{$search}%"])->orderBy('name')->limit(5)->get();

        return json_encode(["result" => "success", "content" => $colours]);
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
     * @param  \App\Models\Colour  $colour
     * @return \Illuminate\Http\Response
     */
    public function show(Colour $colour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Colour  $colour
     * @return \Illuminate\Http\Response
     */
    public function edit(Colour $colour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Colour  $colour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Colour $colour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Colour  $colour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colour $colour)
    {
        //
    }
}
