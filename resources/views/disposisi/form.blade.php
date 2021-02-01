<div class="form-group {{ $errors->has('surat_masuk_id') ? 'has-error' : ''}}">
    <label for="surat_masuk_id" class="control-label">{{ 'Surat Masuk Id' }}</label>
    
<div class="col-md-12">
    <strong>{{ $surat_masuk->perihal }}</strong>

    <input placeholder="surat_masuk_id" class="form-control form-control-line @error('surat_masuk_id') is-invalid @enderror" name="surat_masuk_id" type="hidden" id="surat_masuk_id" value="{{ request()->surat_masuk_id }}">
    
    @error('surat_masuk_id')
    <span class="invalid-feedback text-danger" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>

<div class="form-group {{ $errors->has('unit_kerja_sub_bagian_id') ? 'has-error' : ''}}">
    <label for="unit_kerja_sub_bagian_id" class="control-label">{{ 'Unit Kerja Sub Bagian Id' }}</label>
    
    <div class="col-md-12">

        <select name="unit_kerja_sub_bagian_id" class="form-control form-control-line" id="unit_kerja_sub_bagian_id" required>
            @foreach ($bagians as $key => $bagian)
            <optgroup label='{{ $bagian->nama }}'>
                @foreach($bagian->sub_bagians as $sub_bagian_key => $sub_bagian)
                <option value="{{ $sub_bagian->id }}"
                    {{ (isset($disposisi->unit_kerja_sub_bagian_id) && $disposisi->unit_kerja_sub_bagian_id == $sub_bagian->id) || old('sub_bagian_id') == $sub_bagian->id ? 'selected' : ''}}>
                    {{ $sub_bagian->nama }}</option>
                @endforeach

            </optgroup>
            @endforeach
        </select>

        @error('unit_kerja_sub_bagian_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<div class="form-group {{ $errors->has('rekrutmen_jabatan_id') ? 'has-error' : ''}}">
    <label for="rekrutmen_jabatan_id" class="control-label">{{ 'Rekrutmen Jabatan Id' }}</label>
    
    <div class="col-md-12">

        <select name="rekrutmen_jabatan_id" class="form-control form-control-line" id="rekrutmen_jabatan_id" >
            <option></option>
            @foreach ($rekrutmen_jabatans as $optionKey => $optionValue)
                <option value="{{ $optionKey }}" {{ (isset($disposisi->rekrutmen_jabatan_id) && $disposisi->rekrutmen_jabatan_id == $optionKey) || old('rekrutmen_jabatan_id') == $optionKey ? 'selected' : ''}}>{{ $optionValue }}</option>
            @endforeach
        </select>

        @error('rekrutmen_jabatan_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<div class="form-group {{ $errors->has('waktu_disposisi') ? 'has-error' : ''}}">
    <label for="waktu_disposisi" class="control-label">{{ 'Waktu Disposisi' }}</label>
    
<div class="col-md-12">
    <input placeholder="waktu_disposisi" class="form-control form-control-line @error('waktu_disposisi') is-invalid @enderror" name="waktu_disposisi" type="text" id="waktu_disposisi" value="{{ isset($disposisi->waktu_disposisi) ? $disposisi->waktu_disposisi : date('d-M-Y H:i') }}" readonly>
    
    @error('waktu_disposisi')
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
