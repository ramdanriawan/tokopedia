<div class="form-group {{ $errors->has('keterangan') ? 'has-error' : ''}}">
    <label for="keterangan" class="control-label">{{ 'Keterangan' }}</label>
    
<div class="col-md-12">
    <input placeholder="keterangan" class="form-control form-control-line @error('keterangan') is-invalid @enderror" name="keterangan" type="text" id="keterangan" value="{{ isset($sifat_surat) ? $sifat_surat : old('keterangan') }}" required>
    
    @error('keterangan')
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
