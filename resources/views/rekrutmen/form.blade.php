{{-- <div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'User Id' }}</label>

    <div class="col-md-12">

        <select name="user_id" class="form-control form-control-line" id="user_id" required>
            @foreach ($users as $optionKey => $optionValue)
            <option value="{{ $optionKey }}"
                {{ (isset($rekrutmen->user_id) && $rekrutmen->user_id == $optionKey) || old('user_id') == $optionKey ? 'selected' : ''}}>
                {{ $optionValue }}</option>
            @endforeach
        </select>

        @error('user_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div> --}}

<div class="form-group {{ $errors->has('jabatan_id') ? 'has-error' : ''}}">
    <label for="jabatan_id" class="control-label">{{ 'Jabatan Id' }}</label>
    
    <div class="col-md-12">

        <select name="jabatan_id" class="form-control form-control-line" id="jabatan_id" required>
            @foreach ($jabatans as $optionKey => $optionValue)
                <option value="{{ $optionKey }}" {{ (isset($rekrutmen->jabatan_id) && $rekrutmen->jabatan_id == $optionKey) || old('jabatan_id') == $optionKey ? 'selected' : ''}}>{{ $optionValue }}</option>
            @endforeach
        </select>

        @error('jabatan_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
{{-- <div class="form-group {{ $errors->has('no_pendaftar') ? 'has-error' : ''}}">
    <label for="no_pendaftar" class="control-label">{{ 'No Pendaftar' }}</label>
    
<div class="col-md-12">
    <input placeholder="no_pendaftar" class="form-control form-control-line @error('no_pendaftar') is-invalid @enderror" name="no_pendaftar" type="text" id="no_pendaftar" value="{{ isset($rekrutmen->no_pendaftar) ? $rekrutmen->no_pendaftar : old('no_pendaftar') }}" required>
    
    @error('no_pendaftar')
    <span class="invalid-feedback text-danger" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

</div> --}}
<div class="form-group {{ $errors->has('nik') ? 'has-error' : ''}}">
    <label for="nik" class="control-label">{{ 'NIK' }}</label>
    
<div class="col-md-12">
    <input placeholder="nik" class="form-control form-control-line @error('nik') is-invalid @enderror" name="nik" type="text" id="nik" value="{{ isset($rekrutmen->nik) ? $rekrutmen->nik : old('nik') }}" required>
    
    @error('nik')
    <span class="invalid-feedback text-danger" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

</div>
<div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    <label for="nama" class="control-label">{{ 'Nama' }}</label>
    
<div class="col-md-12">
    <input placeholder="nama" class="form-control form-control-line @error('nama') is-invalid @enderror" name="nama" type="text" id="nama" value="{{ isset($rekrutmen->nama) ? $rekrutmen->nama : old('nama') }}" required>
    
    @error('nama')
    <span class="invalid-feedback text-danger" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

</div>
<div class="form-group {{ $errors->has('tanggal_lahir') ? 'has-error' : ''}}">
    <label for="tanggal_lahir" class="control-label">{{ 'Tanggal Lahir' }}</label>
    
<div class="col-md-12">
    <input placeholder="tanggal_lahir" class="flatpickr form-control form-control-line @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" type="text" id="tanggal_lahir" value="{{ isset($rekrutmen->tanggal_lahir) ? $rekrutmen->tanggal_lahir : old('tanggal_lahir') }}" required>
    
    @error('tanggal_lahir')
    <span class="invalid-feedback text-danger" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

</div>
<div class="form-group {{ $errors->has('tempat_lahir') ? 'has-error' : ''}}">
    <label for="tempat_lahir" class="control-label">{{ 'Tempat Lahir' }}</label>
    
<div class="col-md-12">
    <input placeholder="tempat_lahir" class="form-control form-control-line @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" type="text" id="tempat_lahir" value="{{ isset($rekrutmen->tempat_lahir) ? $rekrutmen->tempat_lahir : old('tempat_lahir') }}" required>
    
    @error('tempat_lahir')
    <span class="invalid-feedback text-danger" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

</div>
<div class="form-group {{ $errors->has('jenis_kelamin') ? 'has-error' : ''}}">
    <label for="jenis_kelamin" class="control-label">{{ 'Jenis Kelamin' }}</label>

    <div class="col-md-12">

        <select name="jenis_kelamin" class="form-control form-control-line" id="jenis_kelamin" required>
            @foreach (["Laki - Laki" => "Laki - Laki", "Perempuan" => "Perempuan"] as $optionKey => $optionValue)
            <option value="{{ $optionKey }}"
                {{ (isset($rekrutmen->jenis_kelamin) && $rekrutmen->jenis_kelamin == $optionKey) || old('jenis_kelamin') == $optionKey ? 'selected' : ''}}>
                {{ $optionValue }}</option>
            @endforeach
        </select>

        @error('jenis_kelamin')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group {{ $errors->has('agama') ? 'has-error' : ''}}">
    <label for="agama" class="control-label">{{ 'Agama' }}</label>
    
    <div class="col-md-12">

        <select name="agama" class="form-control form-control-line" id="agama" required>
            @foreach (["Islam" => "Islam","Kristen Katolik" => "Kristen Katolik", "Kristen Protestan" => "Kristen Protestan", "Hindu" => "Hindu", "Budha" => "Budha"] as $optionKey => $optionValue)
                <option value="{{ $optionKey }}" {{ (isset($rekrutmen->agama) && $rekrutmen->agama == $optionKey) || old('agama') == $optionKey ? 'selected' : ''}}>{{ $optionValue }}</option>
            @endforeach
        </select>

        @error('agama')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<div class="form-group {{ $errors->has('alamat') ? 'has-error' : ''}}">
    <label for="alamat" class="control-label">{{ 'Alamat' }}</label>
    
    <div class="col-md-12">

        <textarea class="form-control" rows="5" name="alamat" type="textarea" id="alamat" placeholder="alamat" required>{{ isset($rekrutmen->alamat) ? $rekrutmen->alamat : old('alamat')}}</textarea>
        
        @error('alamat')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<div class="form-group {{ $errors->has('no_telepon') ? 'has-error' : ''}}">
    <label for="no_telepon" class="control-label">{{ 'No Telepon' }}</label>
    
<div class="col-md-12">
    <input placeholder="no_telepon" class="form-control form-control-line @error('no_telepon') is-invalid @enderror" name="no_telepon" type="text" id="no_telepon" value="{{ isset($rekrutmen->no_telepon) ? $rekrutmen->no_telepon : old('no_telepon') }}" required>
    
    @error('no_telepon')
    <span class="invalid-feedback text-danger" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>

    <div class="col-md-12">

        <select name="status" class="form-control form-control-line" id="status" required>
            @foreach (["PPK" => "PPK", "PPS" => "PPS"] as $optionKey =>
            $optionValue)
            <option value="{{ $optionKey }}"
                {{ (isset($rekrutmen->status) && $rekrutmen->status == $optionKey) || old('status') == $optionKey ? 'selected' : ''}}>
                {{ $optionValue }}</option>
            @endforeach
        </select>

        @error('status')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<div class="form-group {{ $errors->has('dibuat') ? 'has-error' : ''}}">
    <label for="dibuat" class="control-label">{{ 'Dibuat' }}</label>

    <div class="col-md-12">
        <input placeholder="dibuat" class="flatpickr form-control form-control-line @error('dibuat') is-invalid @enderror"
            name="dibuat" type="text" id="dibuat"
            value="{{ isset($rekrutmen->dibuat) ? $rekrutmen->dibuat : old('dibuat') }}" required read>

        @error('dibuat')
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
