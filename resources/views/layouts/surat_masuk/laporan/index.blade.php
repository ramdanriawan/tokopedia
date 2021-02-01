<div class='row'>
    <div class='col-md-6'>
    <form class="form-horizontal form-material" action="{{ url(route('surat_masuk.print')) }}"
    method="post" enctype="multipart/form-data">
    @csrf

    <div class="form-group {{ $errors->has('tanggal_awal') ? 'has-error' : ''}}">
        <label class="col-md-12">{{ 'Tanggal Awal Waktu Masuk' }}</label>

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
        <label class="col-md-12">{{ 'Tanggal Akhir Waktu Masuk' }}</label>

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
        <label class="col-md-12">User Unit Kerja</label>
        <div class="col-md-12">
            <select class="form-control form-control-line" name='user_unit_kerja_id'>
                <option value=""></option>
                @foreach($user_unit_kerjas as $user_unit_kerja)
                <option value="{{ $user_unit_kerja->id }}" @if(old('user_unit_kerja_id')==$user_unit_kerja->id)
                    selected @endif>{{ ucwords($user_unit_kerja->nama) }}</option>
                @endforeach
            </select>

            @error('user_unit_kerja_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-12">Sifat Surat</label>
        <div class="col-md-12">
            <select class="form-control form-control-line" name='sifat_surat'>
                <option value=""></option>
                @foreach($sifat_surats as $sifat_surat)
                <option value="{{ $sifat_surat }}" @if(old('sifat_surat')==$sifat_surat)
                    selected @endif>{{ ucwords($sifat_surat) }}</option>
                @endforeach
            </select>

            @error('sifat_surat')
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
                @foreach(['id','sifat_surat_id','waktu_masuk','nomor','pengirim','perihal','isi_ringkas','lampiran'] as $field)
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