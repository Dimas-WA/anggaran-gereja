<?php

namespace App\Http\Controllers;

use App\Jobs\NotifWA;
use App\Models\MasterAnggaran;
use App\Models\Profile;
use App\Models\RoutingApproval;
use App\Models\TrxAnggaranDetail;
use App\Models\TrxAnggaranHeader;
use App\Traits\EmailTraits;
use App\Traits\LogPermintaanTraits;
use App\Traits\Watzap;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrxRealisasiAnggaranHeaderController extends Controller
{
    use Watzap, EmailTraits, LogPermintaanTraits;
    //
    public function greeting(){

        $timeOfDay = date('a');
        if($timeOfDay == 'am'){
            return 'Selamat pagi ';
        }else{
            return 'Selamat sore ';
        }

    }
    public function realisasi(TrxAnggaranHeader $id)
    {
        //cek trx detail
        $cD = TrxAnggaranDetail::where('trx_anggaran_header_id',$id->id)
        ->where('status_realisasi', 'none')->count();
        // dd($cD);

        return view('permintaan_anggaran.realisasi')
        ->with('anggarans', MasterAnggaran::all())
        ->with('trx_anggaran', $id)
        ->with('sisa_detail', $cD);
    }
    //realisasi anggaran
    public function add_realisasi(Request $request)
    {
        $this->validate(
            $request,
            [
                'header' => 'required',
                'seksi_id' => 'required',
                'user_id' => 'required',
                'anggaran_id' => 'required',
                'jumlah_realisasi' => 'required',
                'keterangan_realisasi' => 'required',
                'doc' => 'required|mimes:jpeg,jpg,png,pdf,xls,xlsx,doc,docx',
            ],
            [
                'header.required' => 'Header tidak valid, Thank You.',
                'seksi_id.required' => 'Please input seksi, Thank You.',
                'user_id.required' => 'Please input user, Thank You.',
                'anggaran_id.required' => 'Please select anggaran, Thank You.',
                'jumlah_realisasi.required' => 'Please input jumlah, Thank You.',
                'keterangan_realisasi.required' => 'Please input keterangan, Thank You.',
                'doc.required' => 'Please input doc pendukung, Thank You.',
                'doc.mimes' => 'Format file salah',
            ]
        );
        // dd($request->all());
        $trx_detail = TrxAnggaranDetail::find($request->anggaran_id);


        $today = Carbon::today()->toDateString();

        $tujuan_upload = 'doc-realisasi'.'/'. $today;
        $filenameWithExt = $request->file('doc')->getClientOriginalName();

        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        $filename = str_replace(array("\r\n", "\n\r", "\n", "\r", ";", "-", "(", ")"), '_', $filename);
        $extension = $request->file('doc')->getClientOriginalExtension();
        $filenameSimpan = $filename.'_'.time().'.'.$extension;
        $path = $request->file('doc')->storeAs('public/'. $tujuan_upload, $filenameSimpan);

        $trx_detail->update([
            'jumlah_realisasi' => $request->jumlah_realisasi,
            'keterangan_realisasi' => $request->keterangan_realisasi,
            'status_realisasi' => 'draft',
            'path_doc_realisasi' => $tujuan_upload.'/'.$filenameSimpan,
            'original_file_realisasi' => $filenameWithExt,
            'created_realisasi_by' => auth()->user()->id,
        ]);
        $trx_detail->save();

        $header = TrxAnggaranHeader::find($request->header);

        $header->update([
            'status_realisasi' => 'draft',
        ]);
        $header->save();

        $this->insertLogAddDetailRealisasi($request->header,$request->anggaran_id,$request->seksi_id,$request->tahun,$request->keterangan_realisasi);

        session()->flash('message', 'Detail Realisasi Anggaran berhasil ditambahkan.');
        return redirect(route('trx-anggaran.realisasi', $request->header));
    }

    public function send_realisasi (Request $request)
    {

        // dd($request->id);
        $header = TrxAnggaranHeader::find($request->id);
        $vH=TrxAnggaranDetail::where('trx_anggaran_header_id', $header->id)->get();

        //cek next position on routing approval
        try {
            $cekRA = RoutingApproval::where('user_id', $header->user_id)->firstOrFail();

        } catch (\Throwable $th) {

            session()->flash('message', 'Belum ada routing approval, kontak admin untuk dibuatkan.');
            return redirect(route('trx-anggaran.show', $header->id));
        }

        $nP = $header->next_position_realisasi; //get id untuk app

        $nextPosition = 'user_id_app_2';

        if ($header->next_position_realisasi == 'user_id_app_2') {
            # code...
            $nextPosition = 'user_id_app_3';
        } elseif ($header->next_position_realisasi == 'user_id_app_3') {
            # code...
            $nextPosition = 'user_id_app_4';
        } elseif ($header->next_position_realisasi == 'user_id_app_4') {
            # code...
            $nextPosition = 'user_id_app_5';
        } elseif ($header->next_position_realisasi == 'user_id_app_5') {
            # code...
            $nextPosition = 'user_id_app_6';
        } elseif ($header->next_position_realisasi == 'user_id_app_6') {
            # code...
            $nextPosition = 'user_id_app_7';
        } elseif ($header->next_position_realisasi == 'user_id_app_7') {
            # code...
            $nextPosition = 'user_id_app_8';
        } elseif ($header->next_position_realisasi == 'user_id_app_8') {
            # code...
            $nextPosition = 'user_id_app_9';
        } elseif ($header->next_position_realisasi == 'user_id_app_9') {
            # code...
            $nextPosition = '-';
        }

        $header->update([
            'status_realisasi' => 'send',
            'position_realisasi' => $cekRA->$nP,
            'next_position_realisasi' => $nextPosition,
        ]);

        $header->save();

        // insert to log permintaan status send

        $getAppName = Profile::where('user_id', $cekRA->$nP)->first();
        $this->insertLogSendRealisasi($header->id,$header->seksi_id,$header->tahun,'kirim approval realisasi ke '.$getAppName->name);

        $userId = $header->user_id;


$mUser = $this->greeting().'[NAME]. anda telah mengirim permintaan untuk persetujuan realisasi anggaran kepada '.$getAppName->name.'.';

$job_User = new NotifWA($mUser,null,$userId,null);
NotifWA::dispatch($mUser,null,$userId,null);

$mApp = $this->greeting().'[NAME]. '.$header->user->profile->name.' - '.$header->seksi->name.' telah mengajukan permintaan persetujuan realisasi anggaran kepada anda. Untuk detailnya bisa dicek di aplikasi Anggaran Gereja, terimakasih.';

$job_App = new NotifWA($mApp,null,$cekRA->$nP,null);
NotifWA::dispatch($mApp,null,$cekRA->$nP,null);


    session()->flash('message', 'Realisasi Anggaran sudah dikirim.');
    return redirect(route('trx-anggaran.index'));

    }


    public function request_app()
    {
        //
        //cek status

        return view('permintaan_anggaran.request_realisasi')
        ->with('anggarans', TrxAnggaranHeader::where('position_realisasi', auth()->user()->id)->orderBy('id', 'DESC')->get())
        ;
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
        $waAppSebelumya = $header->next_position_realisasi;
        try {
            //code...
            $cekRA = RoutingApproval::where('user_id', $header->user_id)->firstOrFail();

        } catch (\Throwable $th) {
            //throw $th;

            session()->flash('message', 'Belum ada routing approval, kontak admin untuk dibuatkan.');
            return redirect(route('trx-anggaran.show', $header->id));
        }

        $nP = $header->next_position_realisasi; //get id untuk app

        if ($header->next_position_realisasi == 'user_id_app_2') {
            # code...
            $nextPosition = 'user_id_app_3';
        } elseif ($header->next_position_realisasi == 'user_id_app_3') {
            # code...
            $nextPosition = 'user_id_app_4';
        } elseif ($header->next_position_realisasi == 'user_id_app_4') {
            # code...
            $nextPosition = 'user_id_app_5';
        } elseif ($header->next_position_realisasi == 'user_id_app_5') {
            # code...
            $nextPosition = 'user_id_app_6';
        } elseif ($header->next_position_realisasi == 'user_id_app_6') {
            # code...
            $nextPosition = 'user_id_app_7';
        } elseif ($header->next_position_realisasi == 'user_id_app_7') {
            # code...
            $nextPosition = 'user_id_app_8';
        } elseif ($header->next_position_realisasi == 'user_id_app_8') {
            # code...
            $nextPosition = 'user_id_app_9';
        } elseif ($header->next_position_realisasi == 'user_id_app_9') {
            # code...
            $nextPosition = '-';
        }

        if ($request->action == 'app') {

            if ($cekRA->$nP == 0) {
                # code...

                $header->update([
                    'status_realisasi' => 'approved',
                    'position_realisasi' => 9999,
                    'next_position_realisasi' => 9999,
                    'updated_by' => auth()->user()->id,
                ]);

                $header->save();

                $getAppName = Profile::where('user_id', $cekRA->$nP)->first();
                // $this->insertLogApp($header->id,0,$header->tahun,'approved permintaan anggaran');

                $mUser = $this->greeting().'[NAME]. permintaan realisasi anggaran telah di approve oleh '.auth()->user()->profile->name;

                $mUserLasApp = $this->greeting().'[NAME]. permintaan realisasi anggaran '.$header->user->profile->name.' - '.$header->seksi->name.' telah di approve oleh '.auth()->user()->profile->name;

            }
            else {
                # code...
                $header->update([
                    'status_realisasi' => 'waiting-approval',
                    'position_realisasi' => $cekRA->$nP,
                    'next_position_realisasi' => $nextPosition,
                    'updated_by' => auth()->user()->id,
                ]);

                $header->save();

                $getAppName = Profile::where('user_id', $cekRA->$nP)->first();
                $this->insertLogApp($header->id,0,$header->tahun,'approved dan meneruskan permintaan approval realisasi ke '.$getAppName->name);

                $mUser = $this->greeting().'[NAME]. permintaan realisasi anggaran telah di approve oleh '.auth()->user()->profile->name.'. dan sedang diteruskan ke '.$getAppName->name;

                $mUserLasApp = $this->greeting().'[NAME]. permintaan realisasi anggaran '.$header->user->profile->name.' - '.$header->seksi->name.' telah di approve oleh '.auth()->user()->profile->name.'. dan sedang diteruskan ke '.$getAppName->name;
            }

        $userId = $header->user_id;

    $job_User = new NotifWA($mUser,null,$userId,null);
    NotifWA::dispatch($mUser,null,$userId,null);

    // dd($waAppSebelumya);
    if ($waAppSebelumya =='user_id_app_4') {
        # code...
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

    $mApp1 = $this->greeting().'[NAME]. Anda telah menyetujui permintaan realisasi anggaran dari '.$header->user->profile->name.' - '.$header->seksi->name;

    $job_App = new NotifWA($mApp1,null,auth()->user()->id,null);
    NotifWA::dispatch($mApp1,null,auth()->user()->id,null);

            if ($cekRA->$nP != 0) {
        # code...
                $mApp = $this->greeting().'[NAME]. '.auth()->user()->profile->name.' telah menyetujui permintaan realisasi anggaran dari '.$header->user->profile->name.' - '.$header->seksi->name.'. dan telah meneruskan permintaan persetujuan kepada anda. Untuk detailnya bisa dicek di aplikasi Anggaran Gereja, terimakasih.';

                $job_Next = new NotifWA($mApp,null,$cekRA->$nP,null);
                NotifWA::dispatch($mApp,null,$cekRA->$nP,null);

            }
            session()->flash('message', ' Permintaan Realisasi Anggaran sudah dikirim.');

        } elseif ($request->action == 'rej') {
            # code...

            $header->update([
                'status_realisasi' => 'draft',
                'position_realisasi' => 0,
                'next_position_realisasi' => 'user_id_app_2',
                'updated_by' => auth()->user()->id,
            ]);

            $header->save();

            $this->insertLogSendRealisasi($header->id,$header->seksi_id,$header->tahun,'permintaan realisasi anggaran anda telah ditolak oleh '.auth()->user()->profile->name);

            $userId = $header->user_id;

            $mUser = $this->greeting().'[NAME]. permintaan realisasi anggaran telah ditolak oleh '.auth()->user()->profile->name;

            $job_User = new NotifWA($mUser,null,$userId,null);
            NotifWA::dispatch($mUser,null,$userId,null);

            $mApp1 = $this->greeting().'[NAME]. Anda telah menolak permintaan realisasi anggaran dari '.$header->user->profile->name.' - '.$header->seksi->name;

            $job_App = new NotifWA($mApp1,null,auth()->user()->id,null);
            NotifWA::dispatch($mApp1,null,auth()->user()->id,null);

            session()->flash('message', ' Permintaan Realisasi Anggaran sudah ditolak.');
        }

        return redirect(route('trx-anggaran.index'));

    }
}
