@extends('template.main')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content-title')
    <h1 class="m-0">All Tahun Anggaran</h1>
@endsection

@section('content-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tahun-anggaran.index') }}">Tahun Anggaran</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header"> --}}
          {{-- <h5 class="m-0">Featured</h5> --}}
          {{-- <a class="btn btn-primary btn" href="{{ route('tahun-anggaran.create') }}" id="submit-btn" style="background-color: #069fdb; border-color: #069fdb;"><i class="fas fa-plus"></i> Add New</a> --}}
        {{-- </div> --}}
        <div class="card-body table-responsive p-4">
            <table id="example1" class="table table-striped table-hover dataTable no-footer dtr-inline">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Tahun</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                      @if ($tahun_anggrans->count() > 0)
                          @foreach ($tahun_anggrans as $t_anggaran)
                          <tr>
                              <td>
                                  {{$loop->iteration}}
                              </td>
                              <td>
                                  {{$t_anggaran->tahun}}
                              </td>
                              <td>
                                @if ($t_anggaran->status == 1)
                                    <span class="badge badge" style="background-color: #339a74; color: white;">
                                        <i class="nav-icon fa fa-check">&nbsp;</i> Aktif
                                    </span>
                                @else
                                    <span class="badge badge" style="background-color: #9a3333; color: white;">
                                        <i class="nav-icon fa fa-times">&nbsp;</i> Tidak Aktif
                                    </span>
                                @endif

                              </td>
                                <td>
                                    <a class="btn btn-warning btn-xs text-white" href="{{ route('tahun-anggaran.show', $t_anggaran->id) }}" id="submit-btn" style="background-color: #069fdb; border-color: #069fdb;"><i class="fas fa-search"></i> Review</a>
                                </td>
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
      </div>
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
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

<script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection
