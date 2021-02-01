@extends('layouts.home')

@section('content')
<div class="blog_main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="blog_text">Berita</h1>
            </div>
        </div>
        <div class="blog_section_2">
            <div class="row">
                @forelse($berita as $item)
                <div class="col-sm-4 mb-5">
                    <div class="section_1">
                        <div><img src="{{ Storage::url($item->gambar_depan) }}" style="max-width: 100%;"></div>
                        <button type="button" class="date-bt">{{ date('d M Y') }}</button>
                        <p>
                            <a href="{{ route('home.berita.show', $item->id) }}" class='text-dark'>
                                {{  Str::limit($item->judul, 100) }}
                            </a>
                        </p>
                    </div>
                </div>
                
                @empty
                <div class="col-sm-12">
                    <div class="section_1">
                        <div><img src="images/code.jpg" style="max-width: 100%;"></div>
                        <p>Tidak Ada Berita</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection