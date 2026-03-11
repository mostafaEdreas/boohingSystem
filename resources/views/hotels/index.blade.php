@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Filter Hotels</div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                </svg>
                                <strong>Success!</strong> {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Hotel List</h5>
                        <a href="{{ route('dashboard.hotels.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add New Hotel
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dashboard.hotels.index') }}" method="GET">
                            <div class="mb-3">
                                <label>Country</label>
                                <input type="text" name="h_country" class="form-control"
                                    value="{{ request('h_country') }}" placeholder="e.g. Egypt">
                            </div>
                            <div class="mb-3">
                                <label>City</label>
                                <input type="text" name="h_city" class="form-control" value="{{ request('h_city') }}"
                                    placeholder="e.g. Aswan">
                            </div>
                            <div class="mb-3">
                                <label>Min Rating</label>
                                <select name="h_rating" class="form-control">
                                    <option value="">All Ratings</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}"
                                            {{ request('h_rating') == $i ? 'selected' : '' }}>{{ $i }} Stars & Up
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                            <a href="{{ route('dashboard.hotels.index') }}" class="btn btn-link w-100 mt-2">Clear</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Hotels</h5>
                        <span class="badge bg-info text-dark">Total: {{ $hotels->total() }}</span>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover table-striped mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 60px;" class="ps-3">#</th>
                                    <th>Name</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Rating</th>
                                    <th class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hotels as $hotel)
                                    <tr>
                                        <td class="ps-3 text-muted">
                                            {{ ($hotels->currentPage() - 1) * $hotels->perPage() + $loop->iteration }}
                                        </td>

                                        <td><strong>{{ $hotel->name }}</strong></td>
                                        <td>{{ $hotel->country }}</td>
                                        <td>{{ $hotel->city }}</td>
                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24"
                                                    fill="{{ $i <= $hotel->rating ? '#FFC107' : '#E0E0E0' }}"
                                                    stroke="{{ $i <= $hotel->rating ? '#FFC107' : '#E0E0E0' }}"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="me-1">
                                                    <polygon
                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                    </polygon>
                                                </svg>
                                            @endfor
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="btn-group">
                                                <a href="{{ route('dashboard.hotels.edit', $hotel->id) }}"
                                                    class="btn btn-sm btn-outline-primary">Update</a>

                                                <form action="{{ route('dashboard.hotels.destroy', $hotel->id) }}"
                                                    method="POST" onsubmit="return confirm('Delete this hotel?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger ms-1">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">No hotels found matching your
                                            criteria.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($hotels->hasPages())
                        <div class="card-footer bg-white d-flex justify-content-center">
                            {{ $hotels->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
