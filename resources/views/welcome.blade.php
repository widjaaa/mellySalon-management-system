@extends('layouts.app')

@section('content')
  <!-- ===== DASHBOARD ===== -->
  @include('pages.dashboard')

  <!-- ===== PEMBAYARAN ===== -->
  @include('pages.payment')

  <!-- ===== DATA MEMBER ===== -->
  @include('pages.members')

  <!-- ===== KELOLA LAYANAN ===== -->
  @include('pages.services')

  <!-- ===== INVENTARIS ===== -->
  @include('pages.inventory')

  <!-- ===== LAPORAN ===== -->
  @include('pages.report')

  <!-- ===== RIWAYAT ===== -->
  @include('pages.history')
@endsection
