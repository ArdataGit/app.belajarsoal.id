<!DOCTYPE html>
<html>
<head>
    <title>Export Users</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>No Hp</th>
                <th>NIK</th>
                <th>Nama Paket</th>
                <th>Nominal Paket</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $user)
                @php $trans = App\Models\Transaksi::where('fk_user_id', $user->id)->orderBy('expired','desc')->get(); @endphp
                
                @if (count($trans) > 0)
                    @foreach ($trans as $item)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->alamat }}</td>
                            <td>{{ $user->no_wa }}</td>
                            <td>{{ $user->nik }}</td>
                        
                            <td>{{ $item->paket_mst_r->judul }}</td>
                            <td>{{ $item->harga }}</td>
                        </tr>
                    @endforeach
                @else 
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->alamat }}</td>
                        <td>{{ $user->no_wa }}</td>
                        <td>{{ $user->nik }}</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                @endif
               
            @endforeach
        </tbody>
    </table>
</body>
</html>
