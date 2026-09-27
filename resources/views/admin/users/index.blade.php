@extends('admin.layout')

@section('title', 'Customers')
@section('section', 'Customers')

@section('content')
<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Manage Users</h1>
            <p class="text-muted mb-0">Promote or demote user admin access.</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">View site</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->is_admin)
                                    <span class="badge bg-dark">Admin</span>
                                @else
                                    <span class="badge bg-secondary">User</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at?->format('d M Y') }}</td>
                            <td class="text-end">
                                <form action="{{ route('admin.users.update-admin', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_admin" value="{{ $user->is_admin ? 0 : 1 }}">
                                    <button class="btn btn-sm {{ $user->is_admin ? 'btn-outline-danger' : 'btn-outline-primary' }}">
                                        {{ $user->is_admin ? 'Make User' : 'Make Admin' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
