<h2>Security Dashboard</h2>
<table>
    <tr>
        <th>ID</th>
        <th>File Path</th>
        <th>Quarantine Path</th>
        <th>Date</th>
    </tr>
    @foreach($logs as $log)
    <tr>
        <td>{{ $log->id }}</td>
        <td>{{ $log->file_path }}</td>
        <td>{{ $log->quarantined_path }}</td>
        <td>{{ $log->detected_at }}</td>
    </tr>
    @endforeach
</table>
{{ $logs->links() }}
