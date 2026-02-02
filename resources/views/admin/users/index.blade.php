@extends('layouts.admin')
@section('content')
<div class="card-custom">
    <div class="p-4 border-bottom">
        <h5 class="fw-bold m-0">Registered Users</h5>
    </div>
    <table class="table table-hover mb-0">
        <thead class="bg-light">
            <tr>
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Role</th>
                <th class="p-3">Joined</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="p-3">{{ $user->name }}</td>
                <td class="p-3">{{ $user->email }}</td>
                <td class="p-3">
                    <span class="badge bg-dark">{{ $user->role }}</span>
                </td>
                <td class="p-3">{{ $user->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection