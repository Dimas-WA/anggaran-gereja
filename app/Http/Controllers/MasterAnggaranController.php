<?php

namespace App\Http\Controllers;

use App\Models\MasterAnggaran;
use Illuminate\Http\Request;

class MasterAnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('master_anggaran.index')->with('anggarans', MasterAnggaran::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('master_anggaran.create');
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
                'sawal' => 'required',
                'sakir' => 'required',
            ],
            [
                'name.required' => 'Please input name, Thank You.',
                'sawal.required' => 'Please select status, Thank You.',
                'sakir.required' => 'Please select status, Thank You.',
            ]
        );
        // dd($request->all());

        $anggaran = new MasterAnggaran([
            'name' => $request->name,
            'saldo_awal' => $request->sawal,
            'saldo_akhir' => $request->sakir,
            'created_by' => auth()->user()->id,
        ]);

        $anggaran->save();

        session()->flash('message', ' Master Anggaran was created successfully.');
        return redirect(route('master-anggaran.index'));


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterAnggaran  $masterAnggaran
     * @return \Illuminate\Http\Response
     */
    public function show(MasterAnggaran $masterAnggaran)
    {
        //
        return view('master_anggaran.detail')->with('anggaran', $masterAnggaran);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterAnggaran  $masterAnggaran
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterAnggaran $masterAnggaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterAnggaran  $masterAnggaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterAnggaran $masterAnggaran)
    {
        //
        $this->validate(
            $request,
            [
                'name' => 'required',
                'sawal' => 'required',
                'sakir' => 'required',
            ],
            [
                'name.required' => 'Please input name, Thank You.',
                'sawal.required' => 'Please select status, Thank You.',
                'sakir.required' => 'Please select status, Thank You.',
            ]
        );
        // dd($request->all());

        $masterAnggaran->update([
            'name' => $request->name,
            'saldo_awal' => $request->sawal,
            'saldo_akhir' => $request->sakir,
            'updated_by' => auth()->user()->id,
        ]);

        $masterAnggaran->save();

        session()->flash('message', ' Master Anggaran was updated successfully.');
        return redirect(route('master-anggaran.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterAnggaran  $masterAnggaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterAnggaran $masterAnggaran)
    {
        //
    }
}
