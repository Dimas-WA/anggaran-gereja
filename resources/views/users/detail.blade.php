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
    <h1 class="m-0">Detail User</h1>
@endsection

@section('content-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection


@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="post" id="createForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name*</label>
                        <input type="text" class="form-control" name="name" placeholder="Your Name" value="{{ $user->name }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Email*</label>
                        <input type="text" class="form-control" name="email" placeholder="Your Email" value="{{ $user->email }}" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label style="color: red">Password*</label>
                        <input type="text" class="form-control" name="password" placeholder="Leave blank if not changes" value="{{ old('password') }}">
                    </div>
                </div>
            </div>

            {{-- <div class="row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Image Signature</label>
                        <br>
                        <img src="{{ asset('storage/'.$user->ttd) }}" class="img-box elevation-2" alt="Image" style="height: auto; width: 5rem;">
                    </div>
                    <div class="form-group">
                        <label>Ubah Image Signature</label>
                        <input type="file" name="image" id="file">
                    </div>
                </div>
            </div> --}}

        @if (auth()->user()->type == 'admin')

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Type*</label>
                        <select class="form-control" name="type">
                            <option value="user" @if ($user->type == 'user')
                                selected
                            @endif
                            > User</option>
                            <option value="admin" @if ($user->type == 'admin')
                                selected
                            @endif> Admin</option>
                        </select>
                    </div>
                </div>
            </div>
        @endif

            <div class="card-footer">
                <button type="submit" class="btn btn-warning">Update</button>
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
