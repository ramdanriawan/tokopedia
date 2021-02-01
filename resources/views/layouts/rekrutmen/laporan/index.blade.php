<div class='row'>
    <div class='col-md-6'>
    <form class="form-horizontal form-material" action="{{ url(route('rekrutmen.print')) }}"
    method="post" enctype="multipart/form-data">
    @csrf

    <div class="form-group {{ $errors->has('tanggal_awal') ? 'has-error' : ''}}">
        <label class="col-md-12">{{ 'Tanggal Awal Dibuat' }}</label>

        <div class="col-md-12">
            <input placeholder="tanggal_awal"
                class="flatpickr form-control form-control-line @error('tanggal_awal') is-invalid @enderror"
                name="tanggal_awal" type="text" id="tanggal_awal" value="{{ old('tanggal_awal')}}" required>

            @error('tanggal_awal')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group {{ $errors->has('tanggal_akhir') ? 'has-error' : ''}}">
        <label class="col-md-12">{{ 'Tanggal Akhir Dibuat' }}</label>

        <div class="col-md-12">
            <input placeholder="tanggal_akhir"
                class="flatpickr form-control form-control-line @error('tanggal_akhir') is-invalid @enderror"
                name="tanggal_akhir" type="text" id="tanggal_akhir" value="{{ old('tanggal_akhir')}}" required>

            @error('tanggal_akhir')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-12">Jabatan</label>
        <div class="col-md-12">
            <select class="form-control form-control-line" name='jabatan_id'>
                <option value=""></option>
                @foreach($jabatans as $jabatan)
                <option value="{{ $jabatan->id }}" @if(old('jabatan_id')==$jabatan->id)
                    selected @endif>{{ ucwords($jabatan->nama) }}</option>
                @endforeach
            </select>

            @error('jabatan_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-12">Jenis Kelamin</label>
        <div class="col-md-12">
            <select class="form-control form-control-line" name='jenis_kelamin'>
                @foreach(['', 'Laki - Laki', 'Perempuan'] as $jenis_kelamin)
                <option value="{{ $jenis_kelamin }}" @if(old('jenis_kelamin')==$jenis_kelamin)
                    selected @endif>{{ ucwords($jenis_kelamin) }}</option>
                @endforeach
            </select>

            @error('jenis_kelamin')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-md-12">Agama</label>
        <div class="col-md-12">
            <select class="form-control form-control-line" name='agama'>
                @foreach(['', 'Islam','Kristen Katolik','Kristen Protestan','Hindu','Budha'] as $agama)
                <option value="{{ $agama }}" @if(old('agama')==$agama)
                    selected @endif>{{ ucwords($agama) }}</option>
                @endforeach
            </select>

            @error('agama')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-12">Status</label>
        <div class="col-md-12">
            <select class="form-control form-control-line" name='status'>
                <option value=""></option>
                @foreach(['PPK', 'PPS'] as $status)
                <option value="{{ $status }}" @if(old('status')==$status) selected @endif>
                    {{ ucwords($status) }}</option>
                @endforeach
            </select>

            @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-12">Field</label>
        <div class="col-md-12">
            <select class="form-control form-control-line" name='field'  required>
                @foreach(['id','user_id','jabatan_id','no_pendaftar','nik','nama','tanggal_lahir','tempat_lahir','jenis_kelamin','agama','alamat','no_telepon','status','dibuat'] as $field)
                <option value="{{ $field }}" @if(old('field')==$field)
                    selected @endif>{{ ucwords(preg_replace("/_/", " ", $field)) }}</option>
                @endforeach
            </select>

            @error('field')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-12">Order</label>
        <div class="col-md-12">
            <select class="form-control form-control-line" name='order'  required>
                @foreach(['ASC', 'DESC'] as $order)
                <option value="{{ $order }}" @if(old('order')==$order)
                    selected @endif>{{ $order }}</option>
                @endforeach
            </select>

            @error('order')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-12">Limit</label>
        <div class="col-md-12">
            <input type="number" placeholder="{{ $limit }}"
                class="form-control form-control-line" id="example-limit"
                value='{{ old('limit') == "" ? $limit : old('limit') }}' name='limit' max='{{ $limit }}' min=1 required>

            @error('limit')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <button name='preview' value='true' class="btn btn-info" type="submit">Preview</button>
            <button class="btn btn-primary" type="submit">Print Html</button>
<button name='print_excel' value='true'  class="btn btn-success" type="submit">Print Excel</button>
        </div>
    </div>
</form>
</div>
</div>