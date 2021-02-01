<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'User Id' }}</label>

    <div class="col-md-12">

        <select name="user_id" class="form-control form-control-line" id="user_id" required>
            @foreach ($users as $optionKey => $optionValue)
            <option value="{{ $optionKey }}"
                {{ (isset($unit_kerja->user_id) && $unit_kerja->user_id == $optionKey) || old('user_id') == $optionKey ? 'selected' : ''}}>
                {{ $optionValue }}</option>
            @endforeach
        </select>

        @error('user_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group {{ $errors->has('sub_bagian_id') ? 'has-error' : ''}}">
    <label for="sub_bagian_id" class="control-label">{{ 'Sub Bagian Id' }}</label>

    <div class="col-md-12">

        <select name="sub_bagian_id" class="form-control form-control-line" id="sub_bagian_id" required>
            @foreach ($bagians as $key => $bagian)
            <optgroup label='{{ $bagian->nama }}'>
                @foreach($bagian->sub_bagians as $sub_bagian_key => $sub_bagian)
                <option value="{{ $sub_bagian->id }}"
                    {{ (isset($unit_kerja->sub_bagian_id) && $unit_kerja->sub_bagian_id == $sub_bagian->id) || old('sub_bagian_id') == $sub_bagian->id ? 'selected' : ''}}>
                    {{ $sub_bagian->nama }}</option>
                @endforeach

            </optgroup>
            @endforeach
        </select>

        @error('sub_bagian_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    <label for="nama" class="control-label">{{ 'Nama' }}</label>

    <div class="col-md-12">
        <input placeholder="nama" class="form-control form-control-line @error('nama') is-invalid @enderror" name="nama"
            type="text" id="nama" value="{{ isset($unit_kerja->nama) ? $unit_kerja->nama : old('nama') }}" required>

        @error('nama')
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
                {{ (isset($unit_kerja->jenis_kelamin) && $unit_kerja->jenis_kelamin == $optionKey) || old('jenis_kelamin') == $optionKey ? 'selected' : ''}}>
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

<div class="form-group {{ $errors->has('alamat') ? 'has-error' : ''}}">
    <label for="alamat" class="control-label">{{ 'Alamat' }}</label>

    <div class="col-md-12">

        <textarea class="form-control" rows="5" name="alamat" type="textarea" id="alamat" placeholder="alamat"
            required>{{ isset($unit_kerja->alamat) ? $unit_kerja->alamat : old('alamat')}}</textarea>

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
        <input placeholder="no_telepon" class="form-control form-control-line @error('no_telepon') is-invalid @enderror"
            name="no_telepon" type="text" id="no_telepon"
            value="{{ isset($unit_kerja->no_telepon) ? $unit_kerja->no_telepon : old('no_telepon') }}" required>

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
            @foreach (["Aktif" => "Aktif", "Tidak Aktif" => "Tidak Aktif"] as $optionKey =>
            $optionValue)
            <option value="{{ $optionKey }}"
                {{ (isset($unit_kerja->status) && $unit_kerja->status == $optionKey) || old('status') == $optionKey ? 'selected' : ''}}>
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
            value="{{ isset($unit_kerja->dibuat) ? $unit_kerja->dibuat : old('dibuat') }}" required read>

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