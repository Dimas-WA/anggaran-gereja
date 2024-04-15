@extends('template.main')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content-title')
    <h1 class="m-0">List Persetujaun Realisasi Anggaran</h1>
@endsection

@section('content-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('trx-anggaran.req') }}">Persetujaun Realisasi Anggaran</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-body table-responsive p-4">
          <table id="example1" class="table table-striped table-hover dataTable no-footer dtr-inline"> --}}
            {{-- <div class="card-body table-responsive p-4" style="height: 300px;">

                <table id="example2" class="table table-hover text-nowrap"> --}}

        <div class="card-body table-responsive p-4">

            <table id="example2" class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Doc</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                    @if ($anggarans->count() > 0)
                        @foreach ($anggarans as $h_anggaran)
                        <tr>
                            <td>
                                {{$loop->iteration}}
                            </td>
                            <td>
                                {!!$h_anggaran->description!!}
                            </td>
                            <td>
                                {{$h_anggaran->created_at}}
                            </td>
                            <td>
                                IDR {{ number_format($h_anggaran->total_pengajuan, 2) }}
                            </td>
                            <td>
                                <span class="badge badge" style="background-color: #339a74; color: white;">
                                    <i class="nav-icon fa fa-check">&nbsp;</i> {{ strtoupper($h_anggaran->status_realisasi) }}
                                </span>
                                {{-- {!!$h_anggaran->status!!} --}}
                            </td>
                            <td>
                                {{$h_anggaran->original_file}}
                            </td>
                            <td>
                                <a class="btn btn-primary btn-xs" href="{{ route('trx-anggaran.realisasi', $h_anggaran->id) }}" id="submit-btn"><i class="fas fa-search"></i> Review Realisasi</a>
                            </td>
                        </tr>

                        @endforeach
                    @else
                        <tr>
                            <td rowspan="8">data masih kosong</td>
                        </tr>
                    @endif
                </tbody>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
@endsection

@section('custom-js')

<!-- DataTables  & Plugins -->
<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script>
    $(function () {
    //   $("#example1").DataTable({
    //     "responsive": true, "lengthChange": false, "autoWidth": false,
    //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    //   }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        // "paging": true,
        // "lengthChange": false,
        // "searching": false,
        // "ordering": true,
        // "info": true,
        // "autoWidth": false,
        // "responsive": true,
        "scrollX": true,
      });
    });
  </script>

<script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection
