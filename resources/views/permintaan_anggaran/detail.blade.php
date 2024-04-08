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
                    <i class="fas fa-file-alt"></i> {{ $trx_anggaran->seksi->name }}
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
                    Dokumen Pendukung <b id="total_rows">#{{ $trx_anggaran->jumlah_baris }}</b><br>
                    Total Pengajuan <b id="total_amounts">#IDR {{ number_format($trx_anggaran->total_pengajuan, 2) }}</b><br>
                    </address>
                </div>
            </div>

            <div class="row no-print">
                <div class="col-12">
                    {{-- <a class="btn btn-danger btn-sm addVoucher" onclick=submitVoucherDetail("'.$tmp->Voucher.'") id="row_'.$repVoucher.'"><i class="fas fa-plus"></i> Add</a> --}}
                    {{-- <a class="btn btn-danger set-upload-e-expense text-white" role="button" style="margin-left: 5px;" onclick=processExpense("{{ $trx_anggaran->id }}")><i class="nav-icon fa fa-search">&nbsp;</i> Check Data</a> --}}

                    @if ($trx_anggaran->rekening_bank_id == '2')

                        {{-- <span data-href="{{ route('export.csv', $trx_anggaran->id) }}" id="export" class="btn btn-success" onclick ="exportTasks (event.target);" style="display: none">Generate CSV</span> --}}
                    @else

                        {{-- <span data-href="{{ route('export_bca.txt', $trx_anggaran->id) }}" id="export" class="btn btn-success" onclick ="exportTasks (event.target);" style="display: none">Generate BCA</span> --}}
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

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
                                <option value="{{ $anggaran->id }}"">{{ $anggaran->name }}</option>
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



<div class="row">

    <div class="col-12">
        <div class="invoice p-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <h4>
                    <i class="fas fa-file-alt"></i> Rincian Permintaan Anggaran
                    </h4>
                </div>
            </div>


            <div class="card-body table-responsive p-4">
                <table id="example1" class="table table-striped table-hover dataTable no-footer dtr-inline">
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
                                        <a class="btn btn-danger btn-xs text-white" href="{{ route('trx-anggaran-detail.delete', $detail->id) }}"><i class="fas fa-trash"></i> Delete</a>
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

            <div class="card-footer">
                <a class="btn btn-success btn-sm text-white" href="{{ route('trx-anggaran.send', $trx_anggaran->id) }}"><i class="fas fa-plane"></i> Send</a>
            </div>
        </div>

    </div>
</div>

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


<script>

    function processExpense(voucherHeader)
    {
        const ID = voucherHeader;
        $.ajax({
            url: "<?=url('/import_e_expense')?>",
            type: 'post',
            dataType: "json",
            data: {
              "id":ID,
              "_token":'{{ csrf_token() }}',
            },
            success: function(data) {
              if(data.status == 'success')
              {
                $("#total_rows").text(data.total_rows);
                $("#total_amounts").text(data.total_amount);

                toastr.success(data.message, 'Success');

                getData(ID);

                var csv = document.getElementById("export");
                csv.style.display = "inline-flex";




              }
              else
              {
                toastr.error(data.message, 'Error');
              }

            },
            error: function(d) {
              alert('error');
            },
          });
    }


</script>

<script>

    function getData(VoucherHeaderID)
    {
        console.log(VoucherHeaderID);

            $('#voucher_detail_datatables').DataTable().clear().destroy();
            $('#voucher_detail_datatables').DataTable({
                processing: true,
                serverSide: false,
                paging: false,
                // scrollX: true,
                autoWidth: true,
                searching: false,
            // fixedColumns: true,
                // columnDefs: [
                // { width: '20%', targets: 0 }
                // ],
                fixedColumns: true,

                "ajax": {
                'type': 'POST',
                'url': '<?=url('/');?>/voucher_expense_detail_datatables',
                'data': {
                    _token: '{{ csrf_token() }}',
                    id: VoucherHeaderID,
                },
                },

                columns: [
                {data: 'bank_transfer_type_id', name: 'bank_transfer_type_id'},
                {data: 'bank_name', name: 'bank_name'},
                {data: 'bank_account', name: 'bank_account'},
                {data: 'amount_string', name: 'amount_string'},
                {data: 'remarks1', name: 'remarks1'},
                // {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

    }
</script>

<script>
    function exportTasks(_this) {
       let _url = $(_this).data('href');
       window.location.href = _url;
    }
 </script>
@endsection
