<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Unit</th>
            <th>Email Unit</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($units as $index => $unit)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $unit->nama_unit }}</td>
            <td>{{ $unit->email_unit }}</td>
            <td>{{ strip_tags($unit->deskripsi_unit) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>