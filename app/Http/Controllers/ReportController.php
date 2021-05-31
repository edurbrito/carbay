<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
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

        $reports = Report::where('statetype', 'Waiting')->join('user','report.reportedid','=','user.id')->select('report.*','user.username');

        $search = $request->input('search');
        if(!is_null($search) && !empty($search)){
            $search = strtolower($search);
            $reports = $reports->whereRaw('LOWER(username) LIKE ?', array('%' . $search . '%'));
        }

        $reports = $reports->orderBy('datehour')->paginate(5);

        if($request->acceptsHtml()){
            $html_reports = "";

            foreach($reports as $report) {
                $html_reports .= view("partials.admin.report", ["report" => $report])->render() . "\n";
            }

            $html_links = view("partials.admin.links", ['objects' => $reports])->render();

            return json_encode(["result" => "success", "content" => ["reports" => $html_reports, "links" => $html_links]]);
        }

        return json_encode(["result" => "success", "content" => $reports]);
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
    public function store(Request $request, $username)
    {
        if(!Auth::check())
            return redirect('login');
        
        $validated = Validator::make($request->all(), [
            'reason' => 'required|string|min:1',
            'id' => 'required|numeric|min:1',
            'location' => 'required|numeric|min:1|max:3',
        ]);

        if($validated->fails() || Auth::user()->banned || Auth::user()->username == $username)
            return redirect()->back()->withErrors("You are not allowed to report that user!");

        $user = User::where('username',"=",$username)->first();

        try{
            if(!is_null($user)){
                $report = new Report();
                $report->reason = $request->input('reason');
                $report->datehour = now();
                $report->reporterid = Auth::user()->id;
        
                if ($request->input('location') == 1)
                    $report->locationregisteredid = $user->id;
                else if ($request->input('location') == 2)
                    $report->locationauctionid = $request->input('id');
                else if ($request->input('location') == 3)
                    $report->locationcommentid = $request->input('id');
                else
                    throw "You are not allowed to report that user!";

                $report->reportedid = $report->reported()->id;
                $report->save();
            }
            else{
                throw "You are not allowed to report that user!";
            }
        }
        catch(\Throwable $e){
            return redirect()->back()->withErrors("You are not allowed to report that user!");
        }
        return redirect()->back()->withSuccess(["User successfully reported!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
