    @extends('layouts.print')

    @section('content')

    <h3 align="center">LAPORAN DISPOSISI</h3>

    <table width="100%" border="1" style='margin-bottom: 250px;'>
        <thead>
            <tr>
                <th width=3>No.</th>
                <th>Surat Masuk Id</th>
                <th>Unit Kerja Bagian Id</th>
                <th>Rekrutmen Jabatan Id</th>
                <th>Waktu Disposisi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($disposisis as $disposisi)
            <tr>
                <th>{{ $loop->iteration }}.</th>
                <td>{{ $disposisi->surat_masuk->perihal }}</td>

                <td>{{ $disposisi->unit_kerja_sub_bagian->nama }}</td>

                <td>{{ $disposisi->rekrutmen_jabatan->nama }}</td>

                <td>{{ $disposisi->waktu_disposisi }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
    @endsection