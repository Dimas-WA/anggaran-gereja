<?php

namespace App\Http\Controllers;

use App\Models\RoutingApproval;
use App\Models\User;
use Illuminate\Http\Request;

class RoutingApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('routing_approval.index')->with('approvals', RoutingApproval::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('routing_approval.create')
        ->with('users', User::all());
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
        // dd($request->all());
        $this->validate(
            $request,
            [
                'user' => 'required',
                'user_id_app_2' => 'required',
                'user_id_app_3' => 'required',
            ],
            [
                'user.required' => 'Please select name, Thank You.',
                'user_id_app_2.required' => 'Please select name, Thank You.',
                'user_id_app_3.required' => 'Please select name, Thank You.',
            ]
        );
        // dd($request->user[0]);

        $routingApproval = new RoutingApproval([
            'user_id' => $request->user[0],
            'user_id_app_2' => $request->user_id_app_2,
            'user_id_app_3' => $request->user_id_app_3,
            'user_id_app_4' => $request->user_id_app_4,
            'user_id_app_5' => $request->user_id_app_5,
            'user_id_app_6' => $request->user_id_app_6,
            'user_id_app_7' => $request->user_id_app_7,
            'user_id_app_8' => $request->user_id_app_8,
            'user_id_app_9' => $request->user_id_app_9,
            'created_by' => auth()->user()->id,
        ]);

        $routingApproval->save();

        session()->flash('message', 'Routing Approval Anggaran was created successfully.');
        return redirect(route('routing-approvals.index'));


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoutingApproval  $routingApproval
     * @return \Illuminate\Http\Response
     */
    public function show(RoutingApproval $routingApproval)
    {
        //
        // dd($routingApproval);
        return view('routing_approval.show')->with('app', $routingApproval)
        ->with('users', User::all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RoutingApproval  $routingApproval
     * @return \Illuminate\Http\Response
     */
    public function edit(RoutingApproval $routingApproval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoutingApproval  $routingApproval
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoutingApproval $routingApproval)
    {
        //
        $this->validate(
            $request,
            [
                'user_id_app_2' => 'required',
                'user_id_app_3' => 'required',
            ],
            [
                'user_id_app_2.required' => 'Please select name, Thank You.',
                'user_id_app_3.required' => 'Please select name, Thank You.',
            ]
        );
        // dd($request->all());

        $routingApproval->update([
            'user_id_app_2' => $request->user_id_app_2,
            'user_id_app_3' => $request->user_id_app_3,
            'user_id_app_4' => $request->user_id_app_4,
            'user_id_app_5' => $request->user_id_app_5,
            'user_id_app_6' => $request->user_id_app_6,
            'user_id_app_7' => $request->user_id_app_7,
            'user_id_app_8' => $request->user_id_app_8,
            'user_id_app_9' => $request->user_id_app_9,
            'active' => $request->status,
            'updated_by' => auth()->user()->id,
        ]);

        $routingApproval->save();

        session()->flash('message', 'Routing Approval Anggaran was updated successfully.');
        return redirect(route('routing-approvals.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoutingApproval  $routingApproval
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoutingApproval $routingApproval)
    {
        //
    }
}
