@extends('template.main')


@section('content-title')
    <h1 class="m-0">Profile</h1>
@endsection

@section('content-breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')


<div class="row">
    <div class="col-md-12">

      <!-- Profile Image -->
      <div class="card card-primary card-outline" style="border-top-color: {{ auth()->user()->color }}">
        <div class="card-body box-profile">
          <div class="text-center">
          <div class="user_image user_image_large"></div>
          </div>

          <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

          {{-- <p class="text-muted text-center">Software Engineer</p> --}}


          <style type="text/css">
            .profile_table {
              width: 100%;
              max-width: 700px;
              margin:0 auto;
              margin-top: 40px;
              margin-bottom: 50px;
            }
            .profile_table td {
              padding: 10px;
            }
            .profile_table tr {
              border-top: 1px solid #DEDEDE;
            }
            .profile_table_icon {
              width: 15px;
              text-align: center;
            }
            .profile_table_title {
              width: 200px;
              max-width: 200px;
              font-weight: bold;
            }
            .profile_logout_btn {
              width:200px;
              margin:0 auto;
              margin-bottom: 40px;
              background-color: {{ auth()->user()->color }};
              border-color: {{ auth()->user()->color }}
            }
            .profile_logout_btn:hover
            {
              background-color: {{ auth()->user()->color }};
              opacity:0.8;
            }
            .profile-username {
             margin-top: 20px;
           }
         </style>
          <table class="profile_table">

            <tr>
              <td class="profile_table_icon">
                <i class="far fa-user mr-1"></i>
              </td>
              <td class="profile_table_title">
                Name
              </td>
              <td>
                {{ auth()->user()->profile->name }}
              </td>
            </tr>

            <tr>
              <td class="profile_table_icon">
                <i class="far fa-envelope mr-1"></i>
              </td>
              <td class="profile_table_title">
                Email
              </td>
              <td>
                {{ auth()->user()->email }}
              </td>
            </tr>

            <tr>
              <td class="profile_table_icon">
                <i class="far fa-file-alt mr-1"></i>
              </td>
              <td class="profile_table_title">
                Type
              </td>
              <td>
                {{ ucwords(auth()->user()->type) }}
              </td>
            </tr>


            {{-- <tr>
              <td class="profile_table_icon">
                <i class="fa fa-palette mr-1" style="color: #6c6c6c;"></i>
              </td>
              <td class="profile_table_title">
                Color Calendar
              </td>
              <td>
                <span style="background-color: {{ auth()->user()->color }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> {{ auth()->user()->color }}
              </td>
            </tr> --}}



          </table>

<?php /*
          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <strong><i class="far fa-user mr-1"></i> {{ auth()->user()->username }}</strong>
                <a class="float-left">Username</a>
            </li>
            <li class="list-group-item">
                <strong>
                    <i class="fas fa-envelope mr-1"></i>
                     {{ auth()->user()->email }}</strong>
                <a class="float-left">Email</a>
            </li>
            <li class="list-group-item">
                <strong><i class="far fa-file-alt mr-1"></i> {{ auth()->user()->type }}</strong>
                <a class="float-left">Type</a>
            </li>
            <li class="list-group-item">
                <i class="fas fa-palette mr-1"></i>
                <strong style="background-color: {{ auth()->user()->color }}">
                    {{ auth()->user()->color }}</strong>
                <a class="float-left">Color Calendar</a>
            </li>
          </ul>
*/?>
          <a href="{{ route('logout') }}" class="btn btn-primary btn-block profile_logout_btn"><b>Log Out</b></a>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <!-- /.col -->
  </div>

@endsection
