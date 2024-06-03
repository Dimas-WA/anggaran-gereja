@extends('template.main')
@section('custom-css')


<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/calendar_pick.css') }}">

@endsection
@section('content-title')
    <h1 class="m-0 text-danger">Detail Permintaan Anggaran</h1>
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
                    <span class="badge badge-primary"><i class="nav-icon fas fa-bell text-white">&nbsp;</i> {{ strtoupper($trx_anggaran->status) }}</span>
                    {{-- <span style="tex-danger"><b>#{{ $trx_anggaran->currency }} #{{ $trx_anggaran->type }}</b> --}}
                    {{-- </span> --}}
                    {{-- <input type="hidden" id="resident" value="{{ $resident }}">
                    <input type="hidden" id="header" value="{{ $trx_anggaran->id }}">
                    <input type="hidden" id="rekening_bank_id" value="{{ $trx_anggaran->rekening_bank_id }}">
                    <input type="hidden" id="curr" value="{{ $trx_anggaran->currency }}">
                    <input type="hidden" id="bank" value="{{ $trx_anggaran->rekening_bank->code }}"> --}}
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


@if ($trx_anggaran->user_id == auth()->user()->id && $trx_anggaran->status == 'draft')

<div class="row">
    <div class="col-md-12">
        <div class="card card-warning">
        <div class="card-header" style="opacity: 0.8;">
            <h3 class="card-title"></h3>
        </div>
        <div class="card-body">
            <form action="{{ route('trx-anggaran.add') }}" method="post" id="createForm"  enctype="multipart/form-data">
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
                            @foreach ($anggarans as $anggaran)
                                <option value="{{ $anggaran->id }}"">{{ $anggaran->name }} || Saldo : {{ number_format($anggaran->saldo_akhir,0) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Jumlah Pengajuan*</label>
                        <input type="text" class="form-control" name="jumlah" placeholder="Jumlah Pengajuan" value="{{ old('jumlah') }}" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" placeholder="Keterangan" value="{{ old('keterangan') }}">
                    </div>
                </div>
            </div>


            <div class="card-footer">
                <button type="submit" class="btn btn-warning">Add</button>
            </div>

            </form>
        </div>
        </div>
    </div>
</div>
@endif



<div class="row">

    <div class="col-12">
        <div class="card">
            {{-- <div class="row">
                <div class="col-12">
                    <h4>
                    <i class="fas fa-file-alt"></i> Rincian Permintaan Anggaran
                    </h4>
                </div>
            </div> --}}


            <div class="card-body table-responsive p-4">
                <table id="example2" class="table table-striped table-hover dataTable no-footer dtr-inline" style="width:100%;">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Jumlah</th>
                          <th>Keterangan</th>
                          <th>Action</th>
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
                                      {{$detail->keterangan}}
                                  </td>
                                    <td>

                                        @if ($trx_anggaran->user_id == auth()->user()->id && $trx_anggaran->status == 'draft')
                                            <a class="btn btn-danger btn-xs text-white" href="{{ route('trx-anggaran-detail.delete', $detail->id) }}"><i class="fas fa-trash"></i> Delete</a>
                                        @endif
                                    </td>
                              </tr>

                              @endforeach
                          @else
                              <tr>
                                  <td colspan="5">data masih kosong</td>
                              </tr>
                          @endif
                      </tbody>
                  </tfoot>
                </table>
            </div>

            <div class="card-footer">
            @if ($trx_anggaran->user_id == auth()->user()->id && $trx_anggaran->status == 'draft')
                <a class="btn btn-success btn-sm text-white" href="{{ route('trx-anggaran.send', $trx_anggaran->id) }}"><i class="fas fa-plane"></i> Send</a>
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
                    <i class="fas fa-file-alt"></i> Persetujuan / Penolakan Pengajuan Anggaran
                    </h4>
                </div>
            </div>
    <br>
            <form action="{{ route('trx-anggaran.app_rej') }}" method="post" id="createForm"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="header" value="{{ $trx_anggaran->id }}">
            <input type="hidden" name="seksi_id" value="{{ $trx_anggaran->seksi_id }}">
            <input type="hidden" name="user_id" value="{{ $trx_anggaran->user_id }}">
            <input type="hidden" name="tahun" value="{{ $trx_anggaran->tahun }}">
            <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Notes : </label>
                                <textarea id="summernoteFilm"  class="form-control" name="notes" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="come on! you need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10">Notes Persetujuan / Penolakan Pengajuan Anggaran</textarea>

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

<script>
    $(function () {
      $('#example2').DataTable({
        "scrollX": true,
      });
    });
  </script>
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
