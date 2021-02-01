    @extends('layouts.print')

    @section('content')

    <h3 align="center">LAPORAN SURAT MASUK</h3>

    <table width="100%" border="1" style='margin-bottom: 250px;'>
        <thead>
            <tr>
                <th width=3>No.</th>
                <th>Sifat Surat</th>
                <th>Unit Kerja Id</th>
                <th>Waktu Masuk</th>
                <th>Nomor</th>
                <th>Pengirim</th>
                <th>Perihal</th>
                <th>Isi Ringkas</th>
            </tr>
        </thead>

        <tbody>
            @foreach($surat_masuks as $surat_masuk)
            <tr>
                <td>
                    {{ $loop->iteration }}.
                </td>

                <td>{{ $surat_masuk->sifat_surat }}</td>
                <td>{{ $surat_masuk->user_unit_kerja->name }}</td>
                <td>{{ $surat_masuk->waktu_masuk }}</td>
                <td>{{ $surat_masuk->nomor }}</td>
                <td>{{ $surat_masuk->pengirim }}</td>
                <td>{{ $surat_masuk->perihal }}</td>
                <td>{{ $surat_masuk->isi_ringkas }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
    @endsection