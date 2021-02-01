<div class='row'>
    <div class='col-md-6'>
    <form class="form-horizontal form-material" action="{{ url(route('disposisi.print')) }}"
    method="post" enctype="multipart/form-data">
    @csrf

    <div class="form-group {{ $errors->has('tanggal_awal') ? 'has-error' : ''}}">
        <label class="col-md-12">{{ 'Tanggal Awal Waktu Disposisi' }}</label>

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
        <label class="col-md-12">{{ 'Tanggal Akhir Waktu Disposisi' }}</label>

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
        <label class="col-md-12">Unit Kerja Bagian Id</label>
        <div class="col-md-12">
            <select class="form-control form-control-line" name='unit_kerja_sub_bagian_id'>
                <option value=""></option>
                @foreach($unit_kerja_sub_bagians as $unit_kerja_sub_bagian)
                <option value="{{ $unit_kerja_sub_bagian->id }}" @if(old('unit_kerja_sub_bagian_id')==$unit_kerja_sub_bagian->id)
                    selected @endif>{{ ucwords($unit_kerja_sub_bagian->nama) }}</option>
                @endforeach
            </select>

            @error('unit_kerja_sub_bagian_id')
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
                @foreach(['id','surat_masuk_id','unit_kerja_sub_bagian_id','rekrutmen_jabatan_id','waktu_disposisi'] as $field)
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