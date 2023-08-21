@extends('adminlte::page')

@section('title', 'Status Bridging - Antrian BPJS')

@section('content_header')
    <h1 class="m-0 text-dark">Status Bridging Antrian BPJS</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <b>Base URL :</b> {{ $api->base_url }} <br>
            <b>Cons ID :</b> {{ Str::mask($api->user_id, '*', 1, Str::length($api->user_id) - 2) }} <br>
            <b>Secret Key :</b> {{ Str::mask($api->user_key, '*', 2, Str::length($api->user_key) - 4) }}<br>
            <b>User Key :</b> {{ Str::mask($api->secret_key, '*', 2, Str::length($api->secret_key) - 4) }} <br>
        </div>
    </div>
@stop
