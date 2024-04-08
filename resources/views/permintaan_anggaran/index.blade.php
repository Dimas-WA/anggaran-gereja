@extends('template.main')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content-title')
    <h1 class="m-0">Permintaan Anggaran</h1>
@endsection

@section('content-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('trx-anggaran.index') }}">Permintaan Anggaran</a></li>
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
                                    <i class="nav-icon fa fa-check">&nbsp;</i> {{ strtoupper($h_anggaran->status) }}
                                </span>
                                {{-- {!!$h_anggaran->status!!} --}}
                            </td>
                            <td>
                                {{$h_anggaran->original_file}}
                            </td>
                            <td>
                                <a class="btn btn-primary btn-xs" href="{{ route('trx-anggaran.show', $h_anggaran->id) }}" id="submit-btn"><i class="fas fa-search"></i> Review</a>
                                {{-- <a class="btn btn-success btn-xs" href="{{ route('export.excel', $h_anggaran->id) }}" id="submit-btn"><i class="fas fa-file-excel"></i> Excel</a> --}}
                                {{-- <a class="btn btn-danger btn-xs" href="{{ route('e-expense.delete', $h_anggaran->id) }}" id="submit-btn"><i class="fas fa-trash"></i> Delete</a> --}}
                            </td>
                            {{-- <td>
                                RP20230000{{$loop->iteration}}
                            </td>
                                <td>{{ $document->title }}</td>
                                <td>{{ $document->version }}</td>
                                <td>{{ $document->document_category->category_name }}</td>
                                <td>{{ $document->document_type->type_name }}</td>
                                <td>IT</td>
                                <td>
                                    @if ($document->status == 'draft')
                                    <span class="badge badge-secondary"><i class="nav-icon fa fa-file-alt text-white">&nbsp;</i> {{ $document->status }}</span>


                                    @elseif ($document->status == 'send')

                                    <span class="badge badge-primary text-white"><i class="nav-icon fa fa-paper-plane text-white">&nbsp;</i> {{ $document->status }}</span>

                                    @elseif ($document->status == 'head-app')


                                    <span class="badge badge-warning"><i class="nav-icon fa fa-check text-white">&nbsp;</i> {{ $document->status }}</span>

                                    @elseif ($document->status == 'checker')

                                    <span class="badge badge-info"><i class="nav-icon fa fa-check text-white">&nbsp;</i> {{ $document->status }}</span>

                                    @elseif ($document->status == 'legal-app')

                                    <span class="badge badge-success"><i class="nav-icon fa fa-check text-white">&nbsp;</i> {{ $document->status }}</span>

                                    @elseif ($document->status == 'legal-distribute')

                                    <span class="badge badge-primary text-white"><i class="nav-icon fa fa-paper-plane text-white">&nbsp;</i> {{ $document->status }}</span>

                                    @elseif ($document->status == 'final')
                                    <span class="badge badge-success"><i class="nav-icon fa fa-flag-checkered text-white">&nbsp;</i> {{ $document->status }}</span>


                                    @elseif ($document->status == 'return')

                                    <span class="badge badge-danger text-white" data-toggle="tooltip" title="{!! $document->get_doc_log()->message !!}"><i class="nav-icon fa fa-plane-arrival text-white">&nbsp;</i> {{ $document->status }}</span>

                                    @elseif ($document->status == 'dispute')

                                    <span class="badge badge-danger text-white"><i class="nav-icon fa fa-hand-paper text-white">&nbsp;</i> {{ $document->status }}</span>
                                    @endif

                                    </td>
                                    <td id="hideshow">{{ $document->document_notif->next_date }}</td>

                                <td>

                                    <a class="btn btn-warning btn-xs" href="{{ route('documents.show', $document->id) }}" id="submit-btn"><i class="fas fa-search"></i> Review</a>
                                </td> --}}
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
