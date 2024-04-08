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
    <h1 class="m-0">Routing Approval</h1>
@endsection

@section('content-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('routing-approvals.index') }}">Routing Approval</a></li>
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
            <form action="{{ route('routing-approvals.store') }}" method="post" id="createForm" enctype="multipart/form-data">
            @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>User*</label>
                        <select class="select2" multiple="multiple" data-placeholder="Select Users" style="width: 100%;" name="user[]">
                            <option value="0">Pilih User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user[]') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Approval Level 2*</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="user_id_app_2">
                            <option value="0">Pilih User Approval Level 2</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user[]') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Approval Level 3*</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="user_id_app_3">
                            <option value="0">Pilih User Approval Level 3</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user[]') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Approval Level 4*</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="user_id_app_4">
                            <option value="0">Pilih User Approval Level 4</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user[]') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Approval Level 5*</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="user_id_app_5">
                            <option value="0">Pilih User Approval Level 5</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user[]') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Approval Level 6*</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="user_id_app_6">
                            <option value="0">Pilih User Approval Level 6</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user[]') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Approval Level 7*</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="user_id_app_7">
                            <option value="0">Pilih User Approval Level 7</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user[]') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Approval Level 8*</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="user_id_app_8">
                            <option value="0">Pilih User Approval Level 8</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user[]') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Approval Level 9*</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="user_id_app_9">
                            <option value="0">Pilih User Approval Level 9</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user[]') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Approval*</label>
                        <select class="select2" multiple="multiple" data-placeholder="Select a Document Approver" style="width: 100%;" name="approver[]">
                            @foreach ($users_ad as $user)
                                <option value="{{ $user['name'][0] }}" {{ old('approver[]') == $user ? 'selected' : '' }}>{{ $user['name'][0] }} | {{ $user['email'][0] }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Legal Checker*</label>
                        <select class="select2" multiple="multiple" data-placeholder="Select a Document Regulator" style="width: 100%;" name="checker[]">
                            @foreach ($users_ad as $user)
                                <option value="{{ $user['name'][0] }}" {{ old('checker[]') == $user ? 'selected' : '' }}>{{ $user['name'][0] }} | {{ $user['email'][0] }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>Legal*</label>
                        <select class="select2" multiple="multiple" data-placeholder="Select a Document Regulator" style="width: 100%;" name="legal[]">
                            @foreach ($users_ad as $user)
                                <option value="{{ $user['name'][0] }}" {{ old('legal[]') == $user ? 'selected' : '' }}>{{ $user['name'][0] }} | {{ $user['email'][0] }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div> --}}
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
