    @extends('layouts.print')

    @section('content')

        <h3 align="center">LAPORAN UNIT KERJA</h3>

        <table width="100%" border="1" style='margin-bottom: 250px;'>
    <thead>
        <tr>
            <th width=3>No.</th>
            <th>User Id</th>
<th>Sub Bagian Id</th>
<th>Nama</th>
<th>Jenis Kelamin</th>
<th>Alamat</th>
<th>No Telepon</th>
<th>Status</th>
<th>Dibuat</th>
        </tr>
    </thead>

    <tbody>
        @foreach($unit_kerjas as $unit_kerja)
        <tr>
            <th>{{ $loop->iteration }}.</th>

            <td>{{ $unit_kerja->user->name }}</td>
            <td>{{ $unit_kerja->sub_bagian->nama }}</td>
            <td>{{ $unit_kerja->nama }}</td>
            <td>{{ $unit_kerja->jenis_kelamin }}</td>
            <td>{{ $unit_kerja->alamat }}</td>
            <td>{{ $unit_kerja->no_telepon }}</td>
            <td>{{ $unit_kerja->status }}</td>
            <td>{{ $unit_kerja->dibuat }}</td>

        </tr>
        @endforeach
    </tbody>
    </table>
    @endsection