@extends('layouts.sb-admin')

@section('title', 'Dashboard (SuperAdmin)')

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-4 text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="text-muted">Kami senang Anda bergabung dengan kami. Jelajahi dashboard Anda dan kelola data Anda dengan
            efisien.</p>

    </div>


@endsection
