<?php

namespace App\Http\Controllers;

use App\Models\TahunAnggaran;
use Illuminate\Http\Request;

class TahunAnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('tahun_anggaran.index')->with('tahun_anggrans', TahunAnggaran::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('tahun_anggaran.create');
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
                'tahun' => 'required|unique:tahun_anggarans,tahun',
                'status' => 'required',
            ],
            [
                'tahun.required' => 'Please input tahun, Thank You.',
                'status.required' => 'Please select status, Thank You.',
            ]
        );
        // dd($request->all());

        if ($request->status == 1) {
            # code...
            $updateStatusAll = TahunAnggaran::where('status', 1)->update(['status' => 0]);

        }

        $Tanggaran = new TahunAnggaran([
            'tahun' => $request->tahun,
            'status' => $request->status,
            'created_by' => auth()->user()->id,
        ]);

        $Tanggaran->save();

        session()->flash('message', ' Tahun Anggaran was created successfully.');
        return redirect(route('tahun-anggaran.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TahunAnggaran  $tahunAnggaran
     * @return \Illuminate\Http\Response
     */
    public function show(TahunAnggaran $tahunAnggaran)
    {
        //
        // dd($tahunAnggaran);
        return view('tahun_anggaran.detail')->with('t_anggaran', $tahunAnggaran);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TahunAnggaran  $tahunAnggaran
     * @return \Illuminate\Http\Response
     */
    public function edit(TahunAnggaran $tahunAnggaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TahunAnggaran  $tahunAnggaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TahunAnggaran $tahunAnggaran)
    {
        //
        $this->validate(
            $request,
            [
                'tahun' => 'required|unique:tahun_anggarans,tahun,'.$tahunAnggaran->id,
                'status' => 'required',
            ],
            [
                'tahun.required' => 'Please input tahun, Thank You.',
                'status.required' => 'Please select status, Thank You.',
            ]
        );
        // dd($request->all());
        if ($request->status == 1) {
            # code...
            $updateStatusAll = TahunAnggaran::where('status', 1)->update(['status' => 0]);

        }
        $tahunAnggaran->update([
            'tahun' => $request->tahun,
            'status' => $request->status,
            'updated_by' => auth()->user()->id,
        ]);

        $tahunAnggaran->save();

        session()->flash('message', ' Tahun Anggaran was updated successfully.');
        return redirect(route('tahun-anggaran.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TahunAnggaran  $tahunAnggaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(TahunAnggaran $tahunAnggaran)
    {
        //
    }
}
