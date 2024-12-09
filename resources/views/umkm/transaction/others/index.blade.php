@extends('layouts.sb-admin')

@section('title', 'Transaksi lain - lain')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Transaksi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#"data-bs-toggle="collapse" data-bs-target="#transaksiSideBar">Transaksi</a></li>
            <li class="breadcrumb-item active">Lain - lain</li>
        </ol>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container-fluid px-4">

          
        </div>


    @endsection

    @section('script')
        <script>
         
        </script>


        <script>
          
        </script>
    @endsection
