<?php

namespace App\Http\Controllers;

use App\Jobs\NotifWA;
use App\Models\MasterAnggaran;
use App\Models\Profile;
use App\Models\RoutingApproval;
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

    public function greeting(){

        $timeOfDay = date('a');
        if($timeOfDay == 'am'){
            return 'Selamat pagi ';
        }else{
            return 'Selamat sore ';
        }

    }
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

    public function request_app()
    {
        //
        //cek status

        return view('permintaan_anggaran.request')
        ->with('anggarans', TrxAnggaranHeader::where('position', auth()->user()->id)->orderBy('id', 'DESC')->get())
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

        //set status masih perlu app atau tidak

        return view('permintaan_anggaran.detail')
        ->with('anggarans', MasterAnggaran::where('seksi_id',auth()->user()->profile->seksi_id)->get())
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

        $this->insertLogAddDetail($request->header,$request->anggaran_id,$request->seksi_id,$request->tahun,$request->jumlah);

        session()->flash('message', 'Detail Anggaran berhasil ditambahkan.');
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

        //cek next position on routing approval

        try {
            //code...
            $cekRA = RoutingApproval::where('user_id', $header->user_id)->firstOrFail();

        } catch (\Throwable $th) {
            //throw $th;

            session()->flash('message', 'Belum ada routing approval, kontak admin untuk dibuatkan.');
            return redirect(route('trx-anggaran.show', $header->id));
        }

        $nP = $header->next_position; //get id untuk app

        // dd($header->user->profile->name);

        if ($header->next_position == 'user_id_app_2') {
            # code...
            $nextPosition = 'user_id_app_3';
        } elseif ($header->next_position == 'user_id_app_3') {
            # code...
            $nextPosition = 'user_id_app_4';
        } elseif ($header->next_position == 'user_id_app_4') {
            # code...
            $nextPosition = 'user_id_app_5';
        } elseif ($header->next_position == 'user_id_app_5') {
            # code...
            $nextPosition = 'user_id_app_6';
        } elseif ($header->next_position == 'user_id_app_6') {
            # code...
            $nextPosition = 'user_id_app_7';
        } elseif ($header->next_position == 'user_id_app_7') {
            # code...
            $nextPosition = 'user_id_app_8';
        } elseif ($header->next_position == 'user_id_app_8') {
            # code...
            $nextPosition = 'user_id_app_9';
        } elseif ($header->next_position == 'user_id_app_9') {
            # code...
            $nextPosition = '-';
        }

        $header->update([
            'status' => 'send',
            'position' => $cekRA->$nP,
            'next_position' => $nextPosition,
        ]);

        $header->save();


        // insert to log permintaan status send

        $getAppName = Profile::where('user_id', $cekRA->$nP)->first();
        $this->insertLogSend($header->id,$header->seksi_id,$header->tahun,'kirim permintaan approval ke '.$getAppName->name);


        // kirim notifnya wa dulu
        // get detail pos

        //send wa job queue

//         $pesanDetail = '';
//         $no = 1;
//         foreach ($vH as $detail) {
// $pesanDetail .= $no.'. '.$detail->master_anggaran->name.' '.$detail->keterangan.' '.$detail->jumlah.'
// ';
//             $no++;
//         }

        $userId = $header->user_id;


$mUser = $this->greeting().'[NAME]. anda telah mengirim permintaan untuk persetujuan permintaan anggaran kepada '.$getAppName->name.'.';

$job_User = new NotifWA($mUser,null,$userId,null);
NotifWA::dispatch($mUser,null,$userId,null);

$mApp = $this->greeting().'[NAME]. '.$header->user->profile->name.' - '.$header->seksi->name.' telah mengajukan permintaan persetujuan permintaan anggaran kepada anda. Untuk detailnya bisa dicek di aplikasi Anggaran Gereja, terimakasih.';

$job_App = new NotifWA($mApp,null,$cekRA->$nP,null);
NotifWA::dispatch($mApp,null,$cekRA->$nP,null);

// $mData = 'Menunjuk Program kerja tahun : '.$header->tahun.' seksi  : '.$header->seksi->name.' Mengajukan Permohonan Permintaan Anggaran dengan tujuan '.$header->description.
// 'Dengan rincian anggaran sebagai berikut :'.
// $pesanDetail.' '.
// 'Yang menyerahkan
// '.$header->user->profile->name
// ;

// $message = $this->greeting().'[NAME].
// '.$mData;


    session()->flash('message', ' Permintaan Anggaran sudah dikirim.');
    return redirect(route('trx-anggaran.index'));

    }



    public function approve_reject (Request $request)
    {
        // dd($request->all());
        $this->validate(
            $request,
            [
                'notes' => 'required',
                'action' => 'required|not_in:0',
            ],
            [
                'notes.required' => 'Input catatan, Thank You.',
                'action.required' => 'Pilih setuju atau tolak, Thank You.',
            ]
        );

        // dd($request->id);
        $header = TrxAnggaranHeader::find($request->header);
        $vH=TrxAnggaranDetail::where('trx_anggaran_header_id', $header->id)->get();
        $pengaprove = $header->position;
        $waAppSebelumya = $header->next_position;
        //cek next position on routing approval
        // dd($header->next_position);
        try {
            //code...
            $cekRA = RoutingApproval::where('user_id', $header->user_id)->firstOrFail();

        } catch (\Throwable $th) {
            //throw $th;

            session()->flash('message', 'Belum ada routing approval, kontak admin untuk dibuatkan.');
            return redirect(route('trx-anggaran.show', $header->id));
        }

        $nP = $header->next_position; //get id untuk app

        if ($header->next_position == 'user_id_app_2') {
            # code...
            $nextPosition = 'user_id_app_3';
        } elseif ($header->next_position == 'user_id_app_3') {
            # code...
            $nextPosition = 'user_id_app_4';
        } elseif ($header->next_position == 'user_id_app_4') {
            # code...
            $nextPosition = 'user_id_app_5';
        } elseif ($header->next_position == 'user_id_app_5') {
            # code...
            $nextPosition = 'user_id_app_6';
        } elseif ($header->next_position == 'user_id_app_6') {
            # code...
            $nextPosition = 'user_id_app_7';
        } elseif ($header->next_position == 'user_id_app_7') {
            # code...
            $nextPosition = 'user_id_app_8';
        } elseif ($header->next_position == 'user_id_app_8') {
            # code...
            $nextPosition = 'user_id_app_9';
        } elseif ($header->next_position == 'user_id_app_9') {
            # code...
            $nextPosition = '-';
        }

        // dump('next id approval '.$cekRA->$nP);
        // dump('next posisi field table '.$nextPosition);
        // $getAppName = Profile::where('user_id', $cekRA->$nP)->first();
        // dd($getAppName->name);

        if ($request->action == 'app') {

            if ($cekRA->$nP == 0) {
                # code...

                $header->update([
                    'status' => 'approved',
                    'position' => 9999,
                    'next_position' => 9999,
                    'updated_by' => auth()->user()->id,
                ]);

                // $header->save();

                $getAppName = Profile::where('user_id', $cekRA->$nP)->first();
                // $this->insertLogApp($header->id,0,$header->tahun,'approved permintaan anggaran');

                $mUser = $this->greeting().'[NAME]. permintaan anggaran telah di approve oleh '.auth()->user()->profile->name;

                $mUserLasApp = $this->greeting().'[NAME]. permintaan anggaran '.$header->user->profile->name.' - '.$header->seksi->name.' telah di approve oleh '.auth()->user()->profile->name;

            }
            else {
                # code...
                $header->update([
                    'status' => 'waiting-approval',
                    'position' => $cekRA->$nP,
                    'next_position' => $nextPosition,
                    'updated_by' => auth()->user()->id,
                ]);

                // $header->save();

                $getAppName = Profile::where('user_id', $cekRA->$nP)->first();
                $this->insertLogApp($header->id,0,$header->tahun,'approved dan meneruskan permintaan approval ke '.$getAppName->name);

                $mUser = $this->greeting().'[NAME]. permintaan anggaran telah di approve oleh '.auth()->user()->profile->name.'. dan sedang diteruskan ke '.$getAppName->name;

                $mUserLasApp = $this->greeting().'[NAME]. permintaan anggaran '.$header->user->profile->name.' - '.$header->seksi->name.' telah di approve oleh '.auth()->user()->profile->name.'. dan sedang diteruskan ke '.$getAppName->name;
            }

        $userId = $header->user_id;

    $job_User = new NotifWA($mUser,null,$userId,null);
    NotifWA::dispatch($mUser,null,$userId,null);

    // dd($header->next_position);
    if ($waAppSebelumya =='user_id_app_4') {
        # code...
// dd($mUser);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_2,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_2,null);

    } elseif ($waAppSebelumya =='user_id_app_5') {
        # code...
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_2,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_2,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_3,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_3,null);
    } elseif ($waAppSebelumya =='user_id_app_6') {
        # code...
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_2,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_2,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_3,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_3,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_4,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_4,null);
    } elseif ($waAppSebelumya =='user_id_app_7') {
        # code...
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_2,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_2,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_3,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_3,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_4,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_4,null);
        $job_Ujob_UserAppser = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_5,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_5,null);
    } elseif ($waAppSebelumya =='user_id_app_8') {
        # code...
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_2,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_2,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_3,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_3,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_4,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_4,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_5,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_5,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_6,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_6,null);
    } elseif ($waAppSebelumya =='user_id_app_9') {
        # code...
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_2,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_2,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_3,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_3,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_4,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_4,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_5,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_5,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_6,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_6,null);
        $job_UserApp = new NotifWA($mUserLasApp,null,$cekRA->user_id_app_7,null);
        NotifWA::dispatch($mUserLasApp,null,$cekRA->user_id_app_7,null);
    }

// dd('stop');


$mApp1 = $this->greeting().'[NAME]. Anda telah menyetujui permintaan anggaran dari '.$header->user->profile->name.' - '.$header->seksi->name;

    $job_App = new NotifWA($mApp1,null,$pengaprove,null);
    NotifWA::dispatch($mApp1,null,$pengaprove,null);



            if ($cekRA->$nP != 0) {
    # code...
$mApp = $this->greeting().'[NAME]. '.auth()->user()->profile->name.' telah menyetujui permintaan anggaran dari '.$header->user->profile->name.' - '.$header->seksi->name.'. dan telah meneruskan permintaan persetujuan kepada anda. Untuk detailnya bisa dicek di aplikasi Anggaran Gereja, terimakasih.';

        $job_Next = new NotifWA($mApp,null,$cekRA->$nP,null);
        NotifWA::dispatch($mApp,null,$cekRA->$nP,null);

            }
            session()->flash('message', ' Permintaan Anggaran sudah dikirim.');

        } elseif ($request->action == 'rej') {
            # code...

            $header->update([
                'status' => 'draft',
                'position' => 0,
                'next_position' => 'user_id_app_2',
                'updated_by' => auth()->user()->id,
            ]);

            $header->save();

            // $getAppName = Profile::where('user_id', $cekRA->$nP)->first();
            $this->insertLogSend($header->id,$header->seksi_id,$header->tahun,'permintaan anggaran anda telah ditolak oleh '.auth()->user()->profile->name);

            $userId = $header->user_id;

            $mUser = $this->greeting().'[NAME]. permintaan anggaran telah ditolak oleh '.auth()->user()->profile->name;

            $job_User = new NotifWA($mUser,null,$userId,null);
            NotifWA::dispatch($mUser,null,$userId,null);

            $mApp1 = $this->greeting().'[NAME]. Anda telah menolak permintaan anggaran dari '.$header->user->profile->name.' - '.$header->seksi->name;

            $job_App = new NotifWA($mApp1,null,$pengaprove,null);
            NotifWA::dispatch($mApp1,null,$pengaprove,null);

            session()->flash('message', ' Permintaan Anggaran sudah ditolak.');
        }





        return redirect(route('trx-anggaran.index'));

    }


}
