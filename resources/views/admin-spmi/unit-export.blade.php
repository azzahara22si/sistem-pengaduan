<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Unit</th>
            <th>Email Unit</th>
            <th>Deskripsi</th>
            <th>Dibuat Pada</th>
        </tr>
    </thead>
    <tbody>
        @foreach($units as $index => $unit)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $unit->nama_unit }}</td>
            <td>{{ $unit->email_unit }}</td>
            <td>{{ strip_tags($unit->deskripsi_unit) }}</td>
            <td>{{ $unit->created_at->format('d/m/Y H:i') }} WIB</td>
        </tr>
        @endforeach
    </tbody>
</table>