@extends('template.main')

@section('content-title')
<h1 class="m-0">Welcome</h1>
@endsection

@section('content-breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Welcome</li>
@endsection


@section('content')

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          {{-- <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>

              <p class="card-text">
                Some quick example text to build on the card title and make up the bulk of the card's
                content.
              </p>

              <a href="#" class="card-link">Card link</a>
              <a href="#" class="card-link">Another link</a>
            </div>
          </div> --}}

          <div class="card card-primary card-outline">
            <div class="card-body">
              <h5 class="card-title">How To</h5>
              <br>



              {{-- <video width="100%" controls>
                <source src="{{ asset('AdminLTE/dist/img/E-CCA.mp4') }}" type="video/mp4">
                Your browser does not support HTML video.
              </video> --}}

            </div>
          </div><!-- /.card -->
        </div>
        <!-- /.col-md-6 -->
        {{-- <div class="col-lg-6"> --}}
          {{-- <div class="card">
            <div class="card-header">
              <h5 class="m-0">Featured</h5>
            </div>
            <div class="card-body">
              <h6 class="card-title">Special title treatment</h6>

              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div> --}}

          {{-- <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-0">Featured</h5>
            </div>
            <div class="card-body">
              <h6 class="card-title">Special title treatment</h6>

              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div> --}}
        {{-- </div> --}}
        <!-- /.col-md-6 -->
      {{-- </div> --}}
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
@endsection
