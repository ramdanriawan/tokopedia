    @extends('layouts.print')

    @section('content')

    <h3 align="center">LAPORAN SURAT KELUAR</h3>

    <table width="100%" border="1" style='margin-bottom: 250px;'>
        <thead>
            <tr>
                <th width=3>No.</th>
                <th>Sifat Surat</th>
                <th>Waktu Keluar</th>
                <th>Nomor</th>
                <th>Pengirim</th>
                <th>Perihal</th>
                <th>Kepada</th>
                <th>Bagian</th>
                <th>Isi Ringkas</th>
            </tr>
        </thead>

        <tbody>
            @foreach($surat_keluars as $surat_keluar)
            <tr>
                <th>{{ $loop->iteration }}.</th>
                <td>{{ $surat_keluar->sifat_surat }}</td>

                <td>{{ $surat_keluar->waktu_keluar }}</td>

                <td>{{ $surat_keluar->nomor }}</td>

                <td>{{ $surat_keluar->pengirim }}</td>

                <td>{{ $surat_keluar->perihal }}</td>

                <td>{{ $surat_keluar->kepada }}</td>
                <td>{{ $surat_keluar->bagian }}</td>

                <td>{{ $surat_keluar->isi_ringkas }}</td>


            </tr>
            @endforeach
        </tbody>
    </table>
    @endsection