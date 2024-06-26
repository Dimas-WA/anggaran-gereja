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
    <h1 class="m-0">Detail Tahun Anggaran</h1>
@endsection

@section('content-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tahun-anggaran.index') }}">Seksi</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection


@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>
        <div class="card-body">
            <form action="{{ route('tahun-anggaran.update', $t_anggaran->id) }}" method="post" id="createForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tahun Anggaran*</label>
                        <input type="text" class="form-control" name="tahun" placeholder="Tahun Anggaran" value="{{ $t_anggaran->tahun }}" required>
                    </div>
                </div>
                <div class="col-sm-6">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option disabled>Choose Status</option>
                        <option value="1" {{ $t_anggaran->status == 1 ? 'selected' : '' }} style="background-color: #339a74; color: white;">Aktif</option>
                        <option value="0" {{ $t_anggaran->status == 0 ? 'selected' : '' }} style="background-color: #9a3333; color: white;">Tidak Aktif</option>
                    </select>
                </div>
                </div>
            </div>




            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
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
@endsection
