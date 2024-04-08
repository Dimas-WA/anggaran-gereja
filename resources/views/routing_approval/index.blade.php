@extends('template.main')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content-title')
    <h1 class="m-0">View Routing Approval</h1>
@endsection

@section('content-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('routing-approvals.index') }}">Routing Approval</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body table-responsive p-4">
          <table id="example1" class="table table-striped table-hover dataTable no-footer dtr-inline">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>LV 2</th>
                    <th>LV 3</th>
                    <th>LV 4</th>
                    <th>LV 5</th>
                    <th>LV 6</th>
                    <th>LV 7</th>
                    <th>LV 8</th>
                    <th>LV 9</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                    @if ($approvals->count() > 0)
                        @foreach ($approvals as $app)
                        <tr>
                            <td>
                                {{$loop->iteration}}
                            </td>
                            <td>
                                {{$app->user->name}}<br>
                                <span class="badge badge-info">
                                {{ $app->user->profile->seksi->name }}
                                </span>
                            </td>
                            <td>
                                {{$app->user_level_2->name}}
                            </td>
                            <td>
                                {{$app->user_level_3->name}}
                            </td>
                            <td>
                                @if (!$app->user_level_4 == 0)
                                    {{$app->user_level_4->name}}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if (!$app->user_level_5 == 0)
                                    {{$app->user_level_5->name}}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if (!$app->user_level_6 == 0)
                                    {{$app->user_level_6->name}}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if (!$app->user_level_7 == 0)
                                    {{$app->user_level_7->name}}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if (!$app->user_level_8 == 0)
                                    {{$app->user_level_8->name}}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if (!$app->user_level_9 == 0)
                                    {{$app->user_level_9->name}}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($app->active == 1)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Disable</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-warning btn-xs" href="{{ route('routing-approvals.show', $app->id) }}" id="submit-btn"><i class="fas fa-search"></i> Review</a>
                                {{-- @endif --}}
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
