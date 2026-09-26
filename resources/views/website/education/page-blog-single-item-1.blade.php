@extends('website.education.index')

@section('title', '404 Not Found - Education')

@section('content')
<section class="g-min-height-60vh g-flex-centered g-py-100">
  <div class="container text-center">
    <div class="g-font-size-120 g-font-size-180--sm g-line-height-1 g-font-weight-700 g-color-gray-light-v3 mb-3">404</div>
    <h2 class="h1 g-color-black mb-3">Halaman / Artikel Tidak Ditemukan</h2>
    <p class="g-color-text-light-v1 g-font-size-16 mb-4">Halaman atau artikel yang Anda cari sedang dalam proses pengembangan atau telah dipindahkan.</p>
    <a href="{{ url('/') }}" class="btn btn-md u-btn-primary g-rounded-30 g-px-30 g-py-12">
      <i class="fa fa-arrow-left mr-2"></i> Kembali ke Beranda
    </a>
  </div>
</section>
@endsection
