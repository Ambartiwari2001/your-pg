@extends('layouts.app')

@section('title', 'Manage PGs - Admin')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 animate-fade-in-down">
        <x-page-header title="Manage PGs" :subtitle="'Total PGs: ' . $pgs->total()" class="mb-0" />
        <a href="{{ route('admin.pgs.create') }}" class="btn-primary shrink-0">+ Add New PG</a>
    </div>

    <div class="card overflow-hidden animate-on-scroll">
        <div class="overflow-x-auto">
            <table id="pgTable" class="table-modern w-full" data-page-length="10">
                <thead>
                    <tr>
                        <th>PG Name</th>
                        <th>Location</th>
                        <th>Rooms</th>
                        <th>Rent</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pgs as $pg)
                        <tr>
                            <td class="font-semibold">{{ $pg->name }}</td>
                            <td>{{ $pg->city }}, {{ $pg->state }}</td>
                            <td>{{ $pg->rooms->count() }}</td>
                            <td class="font-semibold">₹{{ number_format($pg->monthly_rent) }}</td>
                            <td>
                                @if($pg->status === 'active')
                                    <span class="badge-approved">Active</span>
                                @else
                                    <span class="badge-rejected">Inactive</span>
                                @endif
                            </td>
                            <td class="space-x-3">
                                <a href="{{ route('admin.pgs.show', $pg) }}" class="text-brand-600 font-semibold hover:text-brand-700">View</a>
                                <a href="{{ route('admin.pgs.edit', $pg) }}" class="text-amber-600 font-semibold hover:text-amber-700">Edit</a>
                                <form method="POST" action="{{ route('admin.pgs.destroy', $pg) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" data-confirm-delete="Are you sure you want to delete this PG? All associated data will be removed." class="text-red-600 font-semibold hover:text-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-100">{{ $pgs->links() }}</div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.11/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.12.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.11/js/jquery.dataTables.min.js"></script>
    <script>
        $(function () {
            $('#pgTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                pageLength: 10,
                lengthChange: false
            });
        });
    </script>
@endpush
