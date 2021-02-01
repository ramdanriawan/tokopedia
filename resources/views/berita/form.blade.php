<div class="form-group {{ $errors->has('judul') ? 'has-error' : ''}}">
    <label for="judul" class="control-label">{{ 'Judul' }}</label>

    <div class="col-md-12">
        <input placeholder="judul" class="form-control form-control-line @error('judul') is-invalid @enderror"
            name="judul" type="text" id="judul" value="{{ isset($berita->judul) ? $berita->judul : old('judul') }}"
            required>

        @error('judul')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>

<div class="form-group {{ $errors->has('gambar_depan') ? 'has-error' : ''}}">
    <label for="gambar_depan" class="control-label">{{ 'Gambar Depan' }}</label>

    <div class="col-md-12">
        <input placeholder="gambar_depan" class="form-control form-control-line @error('gambar_depan') is-invalid @enderror"
            name="gambar_depan" type="file" id="gambar_depan"
            value="{{ isset($berita->gambar_depan) ? $berita->gambar_depan : old('gambar_depan') }}">

        @error('gambar_depan')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>

<div class="form-group {{ $errors->has('isi') ? 'has-error' : ''}}">
    <label for="isi" class="control-label">{{ 'Isi' }}</label>

    <div class="col-md-12">

        <textarea id='editor-0' class="form-control" rows="5" name="isi" type="textarea" placeholder="isi"
            required>{{ isset($berita->isi) ? $berita->isi : old('isi')}}</textarea>

        @error('isi')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<div class="form-group {{ $errors->has('lampiran') ? 'has-error' : ''}}">
    <label for="lampiran" class="control-label">{{ 'Lampiran (Tidak Wajib)' }}</label>

    <div class="col-md-12">
        <input placeholder="lampiran" class="form-control form-control-line @error('lampiran') is-invalid @enderror"
            name="lampiran" type="file" id="lampiran"
            value="{{ isset($berita->lampiran) ? $berita->lampiran : old('lampiran') }}">

        @error('lampiran')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>


<div class="form-group">
    <div class="col-sm-12">
        <button class="btn btn-success" type="submit">Simpan</button>
    </div>
</div>


<script>
    const locationHrefHapusSemua = "{{ url('berita/hapus_semua') }}";
    const locationHrefAktifkanSemua = "{{ url('berita/aktifkan_semua') }}";
    const locationHrefCreate = "{{ url('berita/create') }}";
    var columnOrders = [0];
    var urlSearch = "{{ url('berita') }}";
    var q = "{{ $_GET['q'] ?? '' }}";
    var placeholder = "Filter...";
    var tampilkan_buttons = true;
    var button_manual = true;
</script>