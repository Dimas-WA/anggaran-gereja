<?php

namespace App\Traits;

use App\Models\LogTrxAnggaran;
use App\Models\Setting;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
trait LogPermintaanTraits
{


    function insertLogDraft($trx_anggaran_header_id,$seksi_id,$tahun,$keterangan)
    {
        $logTrx = new LogTrxAnggaran([

            'trx_anggaran_header_id' => $trx_anggaran_header_id,
            'user_id' => auth()->user()->id,
            'seksi_id' => $seksi_id,
            'tahun' => $tahun,
            'status' => 'draft',
            'status_user_id' => auth()->user()->id,
            'keterangan' => $keterangan,
            'created_by' => auth()->user()->id
        ]);
        $logTrx->save();
    }


    function insertLogAddDetail($trx_anggaran_header_id,$master_anggaran_id,$seksi_id,$tahun,$keterangan)
    {
        $logTrx = new LogTrxAnggaran([

            'trx_anggaran_header_id' => $trx_anggaran_header_id,
            'master_anggaran_id' => $master_anggaran_id,
            'user_id' => auth()->user()->id,
            'seksi_id' => $seksi_id,
            'tahun' => $tahun,
            'status' => 'add_detail',
            'status_user_id' => auth()->user()->id,
            'keterangan' => $keterangan,
            'created_by' => auth()->user()->id
        ]);
        $logTrx->save();
    }

    function insertLogRemoveDetail($trx_anggaran_header_id,$master_anggaran_id,$seksi_id,$tahun,$keterangan)
    {
        $logTrx = new LogTrxAnggaran([

            'trx_anggaran_header_id' => $trx_anggaran_header_id,
            'master_anggaran_id' => $master_anggaran_id,
            'user_id' => auth()->user()->id,
            'seksi_id' => $seksi_id,
            'tahun' => $tahun,
            'status' => 'del_detail',
            'status_user_id' => auth()->user()->id,
            'keterangan' => $keterangan,
            'created_by' => auth()->user()->id
        ]);
        $logTrx->save();
    }

    function insertLogApp($trx_anggaran_header_id,$master_anggaran_id,$seksi_id,$tahun,$keterangan)
    {
        $logTrx = new LogTrxAnggaran([

            'trx_anggaran_header_id' => $trx_anggaran_header_id,
            'master_anggaran_id' => $master_anggaran_id,
            'user_id' => auth()->user()->id,
            'seksi_id' => $seksi_id,
            'tahun' => $tahun,
            'status' => 'approved',
            'status_user_id' => auth()->user()->id,
            'keterangan' => $keterangan,
            'created_by' => auth()->user()->id
        ]);
        $logTrx->save();
    }

    function insertLogRej($trx_anggaran_header_id,$master_anggaran_id,$seksi_id,$tahun,$keterangan)
    {
        $logTrx = new LogTrxAnggaran([

            'trx_anggaran_header_id' => $trx_anggaran_header_id,
            'master_anggaran_id' => $master_anggaran_id,
            'user_id' => auth()->user()->id,
            'seksi_id' => $seksi_id,
            'tahun' => $tahun,
            'status' => 'rejected',
            'status_user_id' => auth()->user()->id,
            'keterangan' => $keterangan,
            'created_by' => auth()->user()->id
        ]);
        $logTrx->save();
    }

    function insertLogFin($trx_anggaran_header_id,$master_anggaran_id,$seksi_id,$tahun,$keterangan)
    {
        $logTrx = new LogTrxAnggaran([

            'trx_anggaran_header_id' => $trx_anggaran_header_id,
            'master_anggaran_id' => $master_anggaran_id,
            'user_id' => auth()->user()->id,
            'seksi_id' => $seksi_id,
            'tahun' => $tahun,
            'status' => 'finished',
            'status_user_id' => auth()->user()->id,
            'keterangan' => $keterangan,
            'created_by' => auth()->user()->id
        ]);
        $logTrx->save();
    }

}
