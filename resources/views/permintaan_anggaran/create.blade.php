@extends('template.main')
@section('custom-css')

<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.css') }}">

<link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/calendar_pick.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<style>
/* .select2 span {
    background-color: #007bff;
    margin: 0!important;
    padding: 0!important;
  } */

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #007bff;
    border: 1px solid #fff;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px
}
</style>

@endsection


@section('content-title')
    <h1 class="m-0 text-danger">Create Permintaan Anggaran</h1>
@endsection

@section('content-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('trx-anggaran.index') }}">Permintaan Anggaran</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection


@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-success">
        <div class="card-header" style="opacity: 0.8;">
            <h3 class="card-title"></h3>
        </div>
        <div class="card-body">
            <form action="{{ route('trx-anggaran.store') }}" method="post" id="createForm"  enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tahun*</label>
                        <input type="text" class="form-control" value="{{ $tahun->tahun }}" disabled>
                        <input type="hidden" class="form-control" name="tahun" value="{{ $tahun->tahun }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Seksi*</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->profile->seksi->name }}" disabled>
                        <input type="hidden" class="form-control" name="seksi" value="{{ auth()->user()->profile->seksi_id }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- <div class="row"> --}}
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Keperluan</label>
                                <textarea id="summernoteFilm"  class="form-control" name="description" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="come on! you need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10">Deskripsi keperluan pengajuan anggaran</textarea>

                        </div>
                    </div>
                {{-- </div> --}}
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
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
            </form>
        </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.js') }}"></script>

<script src="https://cdn.ckeditor.com/4.21.0/basic/ckeditor.js"></script>
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>


<!-- Select2 -->
<script src="{{ asset('AdminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
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
<script>
    $("#time").inputmask("hh:mm", {
      placeholder: "HH:MM",
      insertMode: false,
      showMaskOnHover: false,
      alias: "datetime",
      hourFormat: 24
     }
    );

    $("#time_awal").inputmask("hh:mm", {
      placeholder: "HH:MM",
      insertMode: false,
      showMaskOnHover: false,
      alias: "datetime",
      hourFormat: 24
     }
    );
</script>
<script>
    $('#date').datepicker({
        format: 'yyyy-mm-dd'
    });
    $('#date_akhir').datepicker({
        format: 'yyyy-mm-dd'
    });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  });

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
</script>


<script>
    function funcSelectType() {
      var x = document.getElementById("jenis_bisnis_source").value;
      var formLeasing = document.getElementById("leasing");
      var formNonLeasing = document.getElementById("non_leasing");
    //   var formMatch = document.getElementById("typeMatch");

    if (x == "leasing") {
        console.log(x);
        formLeasing.style.display = "block";
        formNonLeasing.style.display = "none";
        // formSeries.style.display = "none";
        // formMatch.style.display = "none";
    }
    else if (x == "non_leasing") {
        console.log(x);
        formLeasing.style.display = "none";
        formNonLeasing.style.display = "block";

    }

        else {
        formLeasing.style.display = "none";
        formNonLeasing.style.display = "none";

        }
    }
</script>

@endsection
