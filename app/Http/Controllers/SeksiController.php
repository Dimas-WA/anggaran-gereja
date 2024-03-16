<?php

namespace App\Http\Controllers;

use App\Models\Seksi;
use Illuminate\Http\Request;

class SeksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('seksi.index')->with('seksis', Seksi::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('seksi.create');
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

        $this->validate(
            $request,
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Please input name, Thank You.',
            ]
        );



        $seksi = new Seksi([
            'name' => $request->name,
            'created_by' => auth()->user()->id,
        ]);
        $seksi->save();

        session()->flash('message', ' seksi was created successfully.');
        return redirect(route('seksi.index'));


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seksi  $seksi
     * @return \Illuminate\Http\Response
     */
    public function show(Seksi $seksi)
    {
        //
        return view('seksi.detail')->with('seksi', $seksi);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seksi  $seksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Seksi $seksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seksi  $seksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seksi $seksi)
    {
        //
        $this->validate(
            $request,
            [
                'name' => 'required',
                'status' => 'required',
            ],
            [
                'name.required' => 'Please input name, Thank You.',
                'status.required' => 'Please select status, Thank You.',
            ]
        );
        // dump($request->all());
        // dd($seksi);

        $seksi->update([
            'name' => $request->name,
            'status' => $request->status,
            'updated_by' => auth()->user()->id,
        ]);
        $seksi->save();
        session()->flash('message', ' seksi was updated successfully.');
        return redirect(route('seksi.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seksi  $seksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seksi $seksi)
    {
        //
    }
}
