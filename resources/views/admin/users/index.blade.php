@extends('layouts.app')

@section('title', 'Manage Users - Admin')

@section('content')
    <x-page-header title="Manage Users" :subtitle="'Total Users: ' . $users->total()" />

    <div class="card overflow-hidden animate-on-scroll">
        <div class="overflow-x-auto">
            <table class="table-modern w-full">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Bookings</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-500 to-violet-500 flex items-center justify-center text-white font-bold text-sm shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-slate-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="text-slate-600">{{ $user->email }}</td>
                            <td class="text-slate-600">{{ $user->phone ?? '—' }}</td>
                            <td>
                                <span class="font-semibold text-brand-600">{{ $user->bookings_count }}</span>
                            </td>
                            <td class="text-slate-500 text-sm">{{ $user->created_at->format('d M, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', $user) }}" class="text-brand-600 font-semibold hover:text-brand-700">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-slate-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-100">{{ $users->links() }}</div>
    </div>
@endsection
