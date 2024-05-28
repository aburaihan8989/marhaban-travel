@extends('errors.illustrated-layout')

@section('code', '404 🤕')

@section('title', __('Page Not Found'))

@section('image')
    <div style="background-image: url(https://picsum.photos/seed/picsum/1920/1080);" class="absolute pin bg-no-repeat md:bg-left lg:bg-center bg-cover"></div>
@endsection

@section('message', __('Afwan, halaman yang anda kunjungi sedang proses maintenance. Silahkan hubungi team developer !'))
