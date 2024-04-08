<?php

namespace App\Http\Controllers;

use App\Models\MasterAnggaran;
use App\Models\TahunAnggaran;
use App\Models\TrxAnggaranDetail;
use App\Models\TrxAnggaranHeader;
use App\Traits\EmailTraits;
use App\Traits\LogPermintaanTraits;
use App\Traits\Watzap;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrxAnggaranHeaderController extends Controller
{
    use Watzap, EmailTraits, LogPermintaanTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('permintaan_anggaran.index')
        ->with('anggarans', TrxAnggaranHeader::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get())
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // dd('test');
        return view('permintaan_anggaran.create')
        ->with('tahun', TahunAnggaran::where('status', 1)->first())
        ;
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
                'tahun' => 'required',
                'seksi' => 'required',
                'description' => 'required',
                'doc' => 'required',
            ],
            [
                'tahun.required' => 'Tahun tidak valid, Thank You.',
                'seksi.required' => 'Please input seksi, Thank You.',
                'description.required' => 'Please input description, Thank You.',
                'doc.required' => 'Please input files, Thank You.',
            ]
        );
        // dd($request->all());


        $today = Carbon::today()->toDateString();
        // $folder_cat = $request->rekening_bank;

        $tujuan_upload = 'doc'.'/'. $today;
        $filenameWithExt = $request->file('doc')->getClientOriginalName();

        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        $filename = str_replace(array("\r\n", "\n\r", "\n", "\r", ";", "-", "(", ")"), '_', $filename);
        $extension = $request->file('doc')->getClientOriginalExtension();
        $filenameSimpan = $filename.'_'.time().'.'.$extension;
        $path = $request->file('doc')->storeAs('public/'. $tujuan_upload, $filenameSimpan);


        $trxHeader = new TrxAnggaranHeader([
            'user_id' => auth()->user()->id,
            'seksi_id' => $request->seksi,
            'tahun' => $request->tahun,
            'description' => $request->description,
            'path' => $tujuan_upload.'/'.$filenameSimpan,
            'original_file' => $filenameWithExt,
            'created_by' => auth()->user()->id,
        ]);
        $trxHeader->save();

        $this->insertLogDraft($trxHeader->id,$request->seksi,$request->tahun,$request->description);

        session()->flash('message', ' Permintaan Anggaran was created successfully.');
        return redirect(route('trx-anggaran.show', $trxHeader->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrxAnggaranHeader  $trxAnggaranHeader
     * @return \Illuminate\Http\Response
     */
    public function show(TrxAnggaranHeader $trx_anggaran)
    {
        //
        // dd($trx_anggaran);
        return view('permintaan_anggaran.detail')
        ->with('anggarans', MasterAnggaran::all())
        // ->with('anggaran_details', TrxAnggaranDetail::where('trx_anggaran_header'))
        ->with('trx_anggaran', $trx_anggaran);
    }


    public function add_trx_anggaran_detail (Request $request)
    {

        $this->validate(
            $request,
            [
                'header' => 'required',
                'seksi_id' => 'required',
                'user_id' => 'required',
                'anggaran_id' => 'required',
                'jumlah' => 'required',
            ],
            [
                'header.required' => 'Header tidak valid, Thank You.',
                'seksi_id.required' => 'Please input seksi, Thank You.',
                'user_id.required' => 'Please input user, Thank You.',
                'anggaran_id.required' => 'Please select anggaran, Thank You.',
                'jumlah.required' => 'Please input jumlah, Thank You.',
            ]
        );
        // dd($request->all());


        // $table->integer('user_id')->nullable();
        // $table->integer('seksi_id')->nullable();
        // $table->integer('trx_anggaran_header_id')->nullable();
        // $table->integer('master_anggaran_id')->nullable();
        // $table->double('jumlah', 15,2)->default(0.00);
        // $table->integer('created_by')->nullable();


        $trxDetail = new TrxAnggaranDetail([
            'user_id' => $request->user_id,
            'seksi_id' => $request->seksi_id,
            'trx_anggaran_header_id' => $request->header,
            'master_anggaran_id' => $request->anggaran_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->user()->id,
        ]);
        $trxDetail->save();

        $header = TrxAnggaranHeader::find($request->header);
        $total = $header->total_pengajuan;
        $total = $total + $request->jumlah;
        $header->update([
            'total_pengajuan' => $total,
        ]);
        $header->save();


        return redirect(route('trx-anggaran.show', $request->header));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrxAnggaranHeader  $trxAnggaranHeader
     * @return \Illuminate\Http\Response
     */
    public function edit(TrxAnggaranHeader $trxAnggaranHeader)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrxAnggaranHeader  $trxAnggaranHeader
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrxAnggaranHeader $trxAnggaranHeader)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrxAnggaranHeader  $trxAnggaranHeader
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrxAnggaranHeader $trxAnggaranHeader)
    {
        //
    }


    public function send(Request $request)
    {
        // dd($request->id);
        $header = TrxAnggaranHeader::find($request->id);
        $vH=TrxAnggaranDetail::where('trx_anggaran_header_id', $header->id)->get();

        dump($vH);
        dd($header);
    }
}
