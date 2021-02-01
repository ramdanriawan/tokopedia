    @extends('layouts.print')

    @section('content')

        <h3 align="center">LAPORAN SIFAT SURAT</h3>

        <table width="100%" border="1" style='margin-bottom: 250px;'>
    <thead>
        <tr>
            <th width=3>No.</th>
            <th>Nama</th>
        </tr>
    </thead>

    <tbody>
        @foreach($sifat_surats as $sifat_surat)
        <tr>
            <th>{{ $loop->iteration }}.</th>
            <td>{{ $sifat_surat }}</td>

        </tr>
        @endforeach
    </tbody>
    </table>
    @endsection