@extends('adminlte::page')

@section('title', 'Pengaturan Aplikasi')

@section('content_header')
    <h1>Pengaturan Aplikasi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" theme-mode="outline">
                <form action="{{ route('pengaturan.store') }}" id="formPengaturan" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="name" label="Nama FKRTL" value="{{ $pengaturan->name ?? null }}"
                                enable-old-support />
                            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="phone" label="No HP" value="{{ $pengaturan->phone ?? null }}"
                                enable-old-support />
                            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="email" label="Email" value="{{ $pengaturan->email ?? null }}"
                                enable-old-support />
                            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="website" label="Website" value="{{ $pengaturan->website ?? null }}"
                                enable-old-support />
                            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="postalCode" label="Kode Pos"
                                value="{{ $pengaturan->postalCode ?? null }}" enable-old-support />
                            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="address" label="Alamat" value="{{ $pengaturan->address ?? null }}"
                                enable-old-support />
                            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="province" label="Provinsi"
                                value="{{ $pengaturan->province ?? null }}" enable-old-support />
                            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="city" label="Kota/Kab" value="{{ $pengaturan->city ?? null }}"
                                enable-old-support />
                            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="district" label="Kecamatan"
                                value="{{ $pengaturan->district ?? null }}" enable-old-support />
                            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="village" label="Desa" value="{{ $pengaturan->village ?? null }}"
                                enable-old-support />
                            <hr>
                            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="idorganization" label="IdOrganization"
                                value="{{ $pengaturan->idorganization ?? null }}" enable-old-support />
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-input-file fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="file_logo_landing_page" label="Logo Landing"
                                placeholder="{{ $pengaturan->logo_landing_page ?? 'Logo Landing Page' }}" />

                            <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="warna_utama" label="Warna Utama" enable-old-support>
                                <option disabled>Pilih Warna Utama</option>
                                <option>primary</option>
                                <option>secondary</option>
                                <option>success</option>
                                <option>info</option>
                                <option>success</option>
                                <option>warning</option>
                                <option>danger</option>
                            </x-adminlte-select>
                        </div>
                    </div>
                </form>
                <x-slot name="footerSlot">
                    <x-adminlte-button type="submit" form="formPengaturan" theme="success" label="Simpan"
                        icon="fas fa-save" />
                </x-slot>
            </x-adminlte-card>
        </div>
    </div>

@stop
@section('plugins.BsCustomFileInput', true)
