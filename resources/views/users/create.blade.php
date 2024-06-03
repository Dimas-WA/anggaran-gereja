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
    <h1 class="m-0">Create Users</h1>
@endsection

@section('content-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection


@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="post" id="createForm" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name*</label>
                        <input type="text" class="form-control" name="name" placeholder="Your Name" value="{{ old('name') }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Username*</label>
                        <input type="text" class="form-control" name="username" placeholder="Your User Name" value="{{ old('username') }}" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Password*</label>
                        <input type="text" class="form-control" name="password" placeholder="Minimal 8 Contains Character & Number" value="{{ old('password') }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Email*</label>
                        <input type="text" class="form-control" name="email" placeholder="Your Email" value="{{ old('email') }}" required>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Image Signature</label>
                        <input type="file" name="image" id="file">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Type*</label>
                        <select class="form-control" name="type">
                            <option value="user" selected> User</option>
                            <option value="admin"> Admin</option>
                        </select>
                        {{-- <input type="text" class="form-control" name="name" placeholder="Your Name" value="{{ old('name') }}" required> --}}
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
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
    $('#date').datepicker({
        startDate: new Date(),
        format: 'yyyy-mm-dd'
    });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  });
</script>
@endsection
