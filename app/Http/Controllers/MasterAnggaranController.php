<?php

namespace App\Http\Controllers;

use App\Models\MasterAnggaran;
use App\Models\Seksi;
use App\Models\TahunAnggaran;
use App\Models\TrxAnggaranDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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

        if (auth()->user()->type == 'user') {
            # code...
            // dd(auth()->user()->profile->seksi_id);
            return view('master_anggaran.index')->with('anggarans', MasterAnggaran::where('seksi_id', auth()->user()->profile->seksi_id)->get());
        } else {
            # code...
            return view('master_anggaran.index')->with('anggarans', MasterAnggaran::all());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('master_anggaran.create')->with('seksis', Seksi::all())->with('tahun', TahunAnggaran::where('status', 1)->first());
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
                'seksi_id' => 'required',
                'name' => 'required',
                'sawal' => 'required',
                'sakir' => 'required',
                'tahun' => 'required',
            ],
            [
                'name.required' => 'Please input name, Thank You.',
                'seksi_id.required' => 'Please input seksi_id, Thank You.',
                'tahun.required' => 'Please input tahun, Thank You.',
                'sawal.required' => 'Please select sawal, Thank You.',
                'sakir.required' => 'Please select sakir, Thank You.',
            ]
        );
        // dd($request->all());


        try {


            $nameAnggaran = strtoupper($request->name);

            $cekName = MasterAnggaran::where('name', )->firstOrFail();

        } catch (\Throwable $th) {
            //throw $th;
            // session()->flash('message', 'Error Create Master Anggaran, Please Try Again');
            return Redirect::back()->withErrors(['message' => 'Error Create Master Anggaran, Please Try Again']);

        }

        try {
            $cekTahun = TahunAnggaran::where('id', $request->tahun)->firstOrFail();

        } catch (\Throwable $th) {
            //throw $th;
            // session()->flash('message', 'Error Create Master Anggaran, Please Try Again');
            return Redirect::back()->withErrors(['message' => 'Error Create Master Anggaran, Please Try Again']);

        }

        $anggaran = new MasterAnggaran([
            'name' => $request->name,
            'saldo_awal' => $request->sawal,
            'saldo_akhir' => $request->sakir,
            'tahun_anggaran_id' => $request->tahun,
            'seksi_id' => $request->seksi_id,
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
        if (auth()->user()->type == 'user') {
            # code...
            return view('master_anggaran.detail')->with('anggaran', $masterAnggaran);
        } else {
            return view('master_anggaran.detail')->with('anggaran', $masterAnggaran);
        }
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
        // dd($request->all());
        $this->validate(
            $request,
            [
                'seksi_id' => 'required',
                'name' => 'required',
                'sawal' => 'required',
                'sakir' => 'required',
                'tahun' => 'required',
                'status' => 'required',
            ],
            [
                'name.required' => 'Please input name, Thank You.',
                'seksi_id.required' => 'Please input seksi_id, Thank You.',
                'tahun.required' => 'Please input tahun, Thank You.',
                'sawal.required' => 'Please select sawal, Thank You.',
                'sakir.required' => 'Please select sakir, Thank You.',
                'status.required' => 'Please select status, Thank You.',
            ]
        );
        // dd($request->all());

        $masterAnggaran->update([
            'name' => $request->name,
            'saldo_awal' => $request->sawal,
            'saldo_akhir' => $request->sakir,
            'status' => $request->status,
            'tahun_anggaran_id' => $request->tahun,
            'seksi_id' => $request->seksi_id,
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
    public function delete (Request $request)
    {


        $mA=MasterAnggaran::find($request->id);
        // dd($mA);

        //cek trx
        $cTrx = TrxAnggaranDetail::where('master_anggaran_id', $mA->id)->get();

        if ($cTrx->count() > 0) {
            # code...
            return Redirect::back()->withErrors(['message' => 'Error Delete Master Anggran sudah digunakan untuk Transaksi Anggaran.']);
        }


        $mA->delete();

        session()->flash('message', ' Master Anggaran was deleted successfully.');

        return redirect(route('master-anggaran.index'));



    }
}
