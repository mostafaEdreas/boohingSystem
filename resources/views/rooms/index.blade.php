@extends('layouts.app')

@section('title', 'Room Management')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-0">Rooms Inventory</h2>
                <p class="text-muted small">Manage room types, availability, and pricing</p>
            </div>
            <a href="{{ route('dashboard.rooms.create') }}" class="btn btn-primary shadow-sm px-4">
                <i class="fas fa-plus me-1"></i> Add New Room
            </a>
        </div>


        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('dashboard.rooms.index') }}" method="GET" class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label class="small fw-bold text-muted">Filter by Hotel</label>
                        <select name="r_hotel" class="form-select border-0 bg-white" onchange="this.form.submit()">
                            <option value="">All Hotels</option>
                            @foreach ($hotels as $hotel)
                                <option value="{{ $hotel->id }}"
                                    {{ request('r_hotel') == $hotel->id ? 'selected' : '' }}>
                                    {{ $hotel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('dashboard.rooms.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Room Name</th>
                            <th>Hotel</th>
                            <th class="text-center">Available</th>
                            <th class="text-center">Max Occupancy</th>
                            <th class="text-end pe-4">Price / Night</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rooms as $room)
                            <tr>
                                <td class="ps-4 text-muted">
                                    {{ $loop->iteration + ($rooms->currentPage() - 1) * $rooms->perPage() }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $room->name }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $room->hotel_name }}</span>
                                </td>
                                <td class="text-center">
                                    @if ($room->available_rooms > 0)
                                        <span class="badge bg-success-soft text-success px-3">{{ $room->available_rooms }}
                                            Left</span>
                                    @else
                                        <span class="badge bg-danger-soft text-danger px-3">Full</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <i class="fas fa-users text-muted me-1"></i> {{ $room->max_occupancy }}
                                </td>
                                <td class="text-end pe-4 fw-bold text-primary">

                                    ${{ number_format($room->price_per_night, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No rooms found matching your
                                    criteria.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

             @if ($rooms->hasPages())
                <div class="card-footer bg-white d-flex justify-content-center">
                    {{ $rooms->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .bg-success-soft {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-danger-soft {
            background-color: rgba(220, 53, 69, 0.1);
        }

        .table thead th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }
    </style>
@endsection
