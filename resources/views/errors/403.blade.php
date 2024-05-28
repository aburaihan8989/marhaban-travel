@extends('errors.illustrated-layout')

@section('code', '403 🤕')

@section('title', __('Page Unauthorized'))

@section('image')
    <div style="background-image: url(https://picsum.photos/seed/picsum/1920/1080);" class="absolute pin bg-no-repeat md:bg-left lg:bg-center bg-cover"></div>
@endsection

@section('message', __('Afwan, anda tidak memiliki akses ke halaman ini. Silahkan hubungi team developer !'))
