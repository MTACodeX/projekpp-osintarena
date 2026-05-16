@extends('layouts.app')

@section('content')
<h1>Recent Submissions</h1>

<table class="table">
    <thead>
        <tr>
            <th>Time</th>
            <th>User</th>
            <th>Team</th>
            <th>Challenge</th>
            <th>Submitted Flag</th>
            <th>Status</th>
            <th>IP</th>
        </tr>
    </thead>
    <tbody>
        @foreach($submissions as $submission)
            <tr>
                <td>{{ \Carbon\Carbon::parse($submission->submitted_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s') }} WIB</td>                <td>{{ $submission->user->username }}</td>
                <td>{{ $submission->team->team_name }}</td>
                <td>{{ $submission->challenge->title }}</td>
                <td>{{ $submission->submitted_flag }}</td>
                <td>{{ $submission->is_correct ? 'Correct' : 'Wrong' }}</td>
                <td>{{ $submission->ip_address }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection