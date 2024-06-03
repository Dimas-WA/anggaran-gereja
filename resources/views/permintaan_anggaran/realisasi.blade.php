@extends('template.main')
@section('custom-css')


<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/calendar_pick.css') }}">

<style>
/* Ensure that the demo table scrolls */
th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }

    div.container {
        width: 80%;
    }
    </style>
@endsection
@section('content-title')
    <h1 class="m-0 text-primary">Realisasi Permintaan Anggaran</h1>
@endsection

@section('content-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('trx-anggaran.index') }}">Permintaan Anggaran</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')

<div class="row">

    <div class="col-12">
        <div class="invoice p-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <h4>
                    <i class="fas fa-file-alt"></i> {{ $trx_anggaran->seksi->name }} -
                    <span class="badge badge-warning text-white"><i class="nav-icon fas fa-bell text-white"></i> {{ strtoupper($trx_anggaran->status_realisasi) }}</span>

                    </h4>
                </div>
            </div>
            <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                    Date <b>#{{ $trx_anggaran->created_at }}</b><br>
                    Description <b>#{!! $trx_anggaran->description !!}</b><br>
                </div>
                <div class="col-sm-6 invoice-col">
                    <address>
                    Dokumen Pendukung <b id="total_rows">#{{ $trx_anggaran->original_file }}</b><br>
                    Total Pengajuan <b id="total_amounts">#IDR {{ number_format($trx_anggaran->total_pengajuan, 2) }}</b><br>
                    </address>
                </div>
            </div>

            <div class="row no-print">
                <div class="col-12">

                </div>
            </div>

        </div>
    </div>
</div>


{{-- @if ($trx_anggaran->user_id == auth()->user()->id && $trx_anggaran->status == 'draft') --}}
@if ($trx_anggaran->user_id == auth()->user()->id && $trx_anggaran->status_realisasi == 'none'))

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
        <div class="card-header" style="opacity: 0.8;">
            <h3 class="card-title">List Anggaran </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('trx-anggaran.add_realisasi') }}" method="post" id="createForm"  enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="header" value="{{ $trx_anggaran->id }}">
            <input type="hidden" name="seksi_id" value="{{ $trx_anggaran->seksi_id }}">
            <input type="hidden" name="user_id" value="{{ $trx_anggaran->user_id }}">
            <input type="hidden" name="tahun" value="{{ $trx_anggaran->tahun }}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Pilih Anggaran*</label>
                        <select class="form-control" name="anggaran_id">
                            <option value="0">Pilih Anggaran</option>
                            @foreach ($trx_anggaran->trx_anggaran_details as $anggaran)
                                <option value="{{ $anggaran->id }}"">{{ $anggaran->master_anggaran->name }} - Pengajuan Rp. {{  $anggaran->jumlah }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Jumlah Terpakai*</label>
                        <input type="text" class="form-control" name="jumlah_realisasi" placeholder="Jumlah Terpakai" value="{{ old('jumlah') }}" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="keterangan_realisasi" placeholder="Keterangan" value="{{ old('keterangan_realisasi') }}">
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Dokumen pendukung</label>
                        <input type="file" name="doc" id="file">
                    </div>
                </div>
            </div>


            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>

            </form>
        </div>
        </div>
    </div>
</div>
@endif



<div class="row">

    <div class="col-12">
        <div class="invoice p-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <h4>
                    <i class="fas fa-file-alt"></i> Rincian Realisasi Anggaran
                    </h4>
                </div>
            </div>


            <div class="card-body table-responsive p-4">
                <table id="example1" class="table table-striped table-hover dataTable no-footer dtr-inline">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th style="color: blue">Jumlah Permintaan</th>
                          <th style="color: red">Jumlah Realisasi</th>
                          <th>Keterangan Realisasi</th>
                          <th>Doc Pendukung</th>
                          {{-- <th>Action</th> --}}
                        </tr>
                      </thead>
                      <tbody>

                          @if ($trx_anggaran->trx_anggaran_details->count() > 0)
                              @foreach ($trx_anggaran->trx_anggaran_details as $detail)
                              <tr>
                                  <td>
                                      {{$loop->iteration}}
                                  </td>
                                  <td>
                                      {{$detail->master_anggaran->name}}
                                  </td>
                                  <td>
                                    IDR {{ number_format($detail->jumlah, 2) }}
                                  </td>
                                  <td>
                                    IDR {{ number_format($detail->jumlah_realisasi, 2) }}
                                  </td>
                                  <td>
                                      {{$detail->keterangan_realisasi}}
                                  </td>
                                  <td>
                                      {{$detail->original_file_realisasi}}
                                  </td>
                                    {{-- <td>

                                        @if ($trx_anggaran->user_id == auth()->user()->id && $trx_anggaran->status == 'draft')
                                            <a class="btn btn-danger btn-xs text-white" href="{{ route('trx-anggaran-detail.delete', $detail->id) }}"><i class="fas fa-trash"></i> Delete</a>
                                        @endif
                                    </td> --}}
                              </tr>

                              @endforeach
                          @else
                              <tr>
                                  <td colspan="3">data masih kosong</td>
                              </tr>
                          @endif
                      </tbody>
                  </tfoot>
                </table>
            </div>

            <div class="card-footer">
                @if ($trx_anggaran->user_id == auth()->user()->id)

                    @if ($trx_anggaran->status_realisasi == 'draft' && $sisa_detail == 0)
                        <a class="btn btn-success btn-sm text-white" href="{{ route('trx-anggaran.send_realisasi', $trx_anggaran->id) }}"><i class="fas fa-plane"></i> Send</a>
                    @else
                        <a class="btn btn-dark btn-sm text-white disabled"><i class="fas fa-plane"></i> Send</a>
                    @endif

                @endif
            </div>
        </div>

    </div>
</div>


@if ($trx_anggaran->user_id != auth()->user()->id)
<div class="row">

    <div class="col-12">
        <div class="invoice p-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <h4>
                    <i class="fas fa-file-alt"></i> Persetujuan / Penolakan Realisasi Anggaran
                    </h4>
                </div>
            </div>
    <br>
            <form action="{{ route('trx-anggaran-realisasi.app_rej') }}" method="post" id="createForm"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="header" value="{{ $trx_anggaran->id }}">
            <input type="hidden" name="seksi_id" value="{{ $trx_anggaran->seksi_id }}">
            <input type="hidden" name="user_id" value="{{ $trx_anggaran->user_id }}">
            <input type="hidden" name="tahun" value="{{ $trx_anggaran->tahun }}">
            <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Notes : </label>
                                <textarea id="summernoteFilm"  class="form-control" name="notes" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="come on! you need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10">Notes Persetujuan / Penolakan Realisasi Anggaran</textarea>

                        </div>
                    </div>
                {{-- </div> --}}
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Action*</label>
                        <select class="form-control" name="action">
                            <option value="0">Pilih :</option>
                            <option value="app"">Disetujui</option>
                            <option value="rej"">Ditolak</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer">

            <button class="btn btn-primary btn-sm text-white"><i class="fas fa-check-circle"></i> Submit</button>

            </div>
        </div>

    </div>
</div>
@endif

@endsection

@section('custom-js')
{{-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> --}}
{{-- <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script> --}}

<!-- DataTables  & Plugins -->
<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.js') }}"></script>

<script type="text/javascript">
    $('#summernoteFilm').summernote({
        height: 200,
        toolbar: [
        ['style', ['bold', 'Source Sans Pro', 'underline', 'clear']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
    ]
    });
    $('#summernoteACK').summernote({
        height: 200,
        toolbar: [
        ['style', ['bold', 'Source Sans Pro', 'underline', 'clear']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
    ]
    });
</script>
@endsection
