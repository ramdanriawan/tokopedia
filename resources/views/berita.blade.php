@extends('layouts.home')

@section('content')
<div class="blog_main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="blog_text">Berita: {{ $berita->judul }}</h1>
            </div>
        </div>
        <div class="blog_section_2">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_1">
                        <div><img src="{{ Storage::url($berita->gambar_depan) }}" style="width: 100%;"></div>
                        <button type="button" class="date-bt">{{ date('d M Y') }}</button>
                        <p>{!! $berita->isi !!}</p>
                    </div>
                </div>

                @if($berita->lampiran)
                <p>
                    <strong>Lampiran</strong>
                    <br>
                    <a href="{{  Storage::url($berita->lampiran) }}" download='Lampiran {{ $berita->judul }}}' class='text-primary'>Download</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection