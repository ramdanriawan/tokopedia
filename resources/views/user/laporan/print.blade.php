    @extends('layouts.print')

    @section('content')

    <h3 align="center">LAPORAN USER</h3>

    <table width="100%" border="1" style='margin-bottom: 250px;'>
        <thead>
            <tr>
                <th width=3>No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Level</th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $user)
            <tr>
                <th>{{ $loop->iteration }}.</th>
                <td>{{ $user->name }}</td>

                <td>{{ $user->email }}</td>

                <td>{{ $user->level }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
    @endsection