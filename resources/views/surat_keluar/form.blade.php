<div class="form-group {{ $errors->has('sifat_surat') ? 'has-error' : ''}}">
    <label for="sifat_surat" class="control-label">{{ 'Sifat Surat' }}</label>

    <div class="col-md-12">

        <input placeholder="sifat_surat"
            class="form-control form-control-line @error('sifat_surat') is-invalid @enderror" name="sifat_surat"
            type="text" id="sifat_surat"
            value="{{ isset($surat_keluar->sifat_surat) ? $surat_keluar->sifat_surat : old('sifat_surat') }}" required>

        @error('sifat_surat')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group {{ $errors->has('waktu_keluar') ? 'has-error' : ''}}">
    <label for="waktu_keluar" class=" control-label">{{ 'Waktu Keluar' }}</label>

    <div class="col-md-12">
        <input placeholder="waktu_keluar"
            class="flatpickr2 form-control form-control-line @error('waktu_keluar') is-invalid @enderror"
            name="waktu_keluar" type="text" id="waktu_keluar"
            value="{{ isset($surat_keluar->waktu_keluar) ? $surat_keluar->waktu_keluar : old('waktu_keluar') }}"
            required>

        @error('waktu_keluar')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<div class="form-group {{ $errors->has('nomor') ? 'has-error' : ''}}">
    <label for="nomor" class="control-label">{{ 'Nomor' }}</label>

    <div class="col-md-12">
        <input placeholder="nomor" class="form-control form-control-line @error('nomor') is-invalid @enderror"
            name="nomor" type="text" id="nomor"
            value="{{ isset($surat_keluar->nomor) ? $surat_keluar->nomor : old('nomor') }}" required>

        @error('nomor')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<div class="form-group {{ $errors->has('pengirim') ? 'has-error' : ''}}">
    <label for="pengirim" class="control-label">{{ 'Pengirim' }}</label>

    <div class="col-md-12">
        <input placeholder="pengirim" class="form-control form-control-line @error('pengirim') is-invalid @enderror"
            name="pengirim" type="text" id="pengirim"
            value="{{ isset($surat_keluar->pengirim) ? $surat_keluar->pengirim : old('pengirim') }}" required>

        @error('pengirim')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<div class="form-group {{ $errors->has('perihal') ? 'has-error' : ''}}">
    <label for="perihal" class="control-label">{{ 'Perihal' }}</label>

    <div class="col-md-12">
        <input placeholder="perihal" class="form-control form-control-line @error('perihal') is-invalid @enderror"
            name="perihal" type="text" id="perihal"
            value="{{ isset($surat_keluar->perihal) ? $surat_keluar->perihal : old('perihal') }}" required>

        @error('perihal')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group {{ $errors->has('kepada') ? 'has-error' : ''}}">
    <label for="kepada" class="control-label">{{ 'Kepada' }}</label>

    <div class="col-md-12">
        <input placeholder="kepada" class="form-control form-control-line @error('kepada') is-invalid @enderror"
            name="kepada" type="text" id="kepada"
            value="{{ isset($surat_keluar->kepada) ? $surat_keluar->kepada : old('kepada') }}" required>

        @error('kepada')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group {{ $errors->has('bagian') ? 'has-error' : ''}}">
    <label for="bagian" class="control-label">{{ 'Bagian' }}</label>

    <div class="col-md-12">
        <input placeholder="bagian" class="form-control form-control-line @error('bagian') is-invalid @enderror"
            name="bagian" type="text" id="bagian"
            value="{{ isset($surat_keluar->bagian) ? $surat_keluar->bagian : old('bagian') }}" required>

        @error('bagian')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group {{ $errors->has('isi_ringkas') ? 'has-error' : ''}}">
    <label for="isi_ringkas" class="control-label">{{ 'Isi Ringkas' }}</label>

    <div class="col-md-12">
        <input placeholder="isi_ringkas"
            class="form-control form-control-line @error('isi_ringkas') is-invalid @enderror" name="isi_ringkas"
            type="text" id="isi_ringkas"
            value="{{ isset($surat_keluar->isi_ringkas) ? $surat_keluar->isi_ringkas : old('isi_ringkas') }}" required>

        @error('isi_ringkas')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<div class="form-group {{ $errors->has('lampiran') ? 'has-error' : ''}}">
    <label for="lampiran" class="control-label">{{ 'Lampiran' }}</label>

    <div class="col-md-12">
        <input placeholder="lampiran" class="form-control form-control-line @error('lampiran') is-invalid @enderror"
            name="lampiran" type="file" id="lampiran"
            value="{{ isset($surat_keluar->lampiran) ? $surat_keluar->lampiran : old('lampiran') }}">

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