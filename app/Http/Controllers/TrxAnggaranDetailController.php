<?php

namespace App\Http\Controllers;

use App\Models\TrxAnggaranDetail;
use App\Models\TrxAnggaranHeader;
use App\Traits\LogPermintaanTraits;
use Illuminate\Http\Request;

class TrxAnggaranDetailController extends Controller
{
    use LogPermintaanTraits;
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrxAnggaranDetail  $trxAnggaranDetail
     * @return \Illuminate\Http\Response
     */
    public function show(TrxAnggaranDetail $trxAnggaranDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrxAnggaranDetail  $trxAnggaranDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(TrxAnggaranDetail $trxAnggaranDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrxAnggaranDetail  $trxAnggaranDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrxAnggaranDetail $trxAnggaranDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrxAnggaranDetail  $trxAnggaranDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrxAnggaranDetail $trxAnggaranDetail)
    {
        //
    }
    public function delete (Request $request)
    {
        // dd($request->id);
        $vH=TrxAnggaranDetail::find($request->id);

        // dd($vH->trx_anggaran_header_id);
        $id_header = $vH->trx_anggaran_header_id;
        $jml = $vH->jumlah;

        $header = TrxAnggaranHeader::find($id_header);
        $total = $header->total_pengajuan;
        $total = $total - $jml;
        $header->update([
            'total_pengajuan' => $total,
        ]);
        $header->save();

        $this->insertLogRemoveDetail($header->id,$request->id,$header->seksi_id,$header->tahun,$vH->jumlah);

        $vH->delete();

        session()->flash('message', ' Permintaan Anggaran was updated successfully.');

        return redirect(route('trx-anggaran.show', $id_header));
    }
}
