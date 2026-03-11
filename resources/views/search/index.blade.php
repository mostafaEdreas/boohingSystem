@extends('layouts.app')

@section('content')
    <div class="bg-primary py-5 mb-5 shadow-sm">
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        style="width:20px; height:20px;" class="me-2">
                        <path fill-rule="evenodd"
                            d="M9.401 3.003c.115-.283.392-.45.686-.45.294 0 .571.167.686.45l6.4 15.601a.75.75 0 01-.686 1.05H3.614a.75.75 0 01-.686-1.05l6.473-15.601zM12 11.25a.75.75 0 00-1.5 0v2.5a.75.75 0 001.5 0v-2.5zm-1.5 6a.75.75 0 111.5 0 .75.75 0 01-1.5 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <ul class="mb-0 small fw-bold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('dashboard.search') }}" method="GET" class="card border-0 shadow-lg p-3">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="small fw-bold text-muted ms-1 mb-1 d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" style="width:14px; height:14px;" class="me-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            City
                        </label>
                        <input type="text" name="h_city" class="form-control border-0 bg-white" placeholder="Where to?"
                            value="{{ request('h_city') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="small fw-bold text-muted ms-1 mb-1">Check-in</label>
                        <input type="date" name="res_checkin_date" class="form-control border-0 bg-white"
                            value="{{ request('res_checkin_date', now()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-2">
                        <label class="small fw-bold text-muted ms-1 mb-1">Check-out</label>
                        <input type="date" name="res_checkout_date" class="form-control border-0 bg-white"
                            value="{{ request('res_checkout_date', now()->addDay()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-2">
                        <label class="small fw-bold text-muted ms-1 mb-1">Guests</label>
                        <input type="number" name="r_guests" class="form-control border-0 bg-white" min="1"
                            value="{{ request('r_guests', 1) }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit"
                            class="btn btn-dark w-100 py-2 fw-bold d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                stroke="currentColor" style="width:18px; height:18px;" class="me-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            Search Hotels
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="container mb-5">
        <div class="d-flex align-items-center mb-4">
            <h4 class="fw-bold mb-0">Results in {{ request('city', 'Selected Destination') }}</h4>
            <span class="badge bg-light text-dark ms-3 border">{{ $results->count() }} Hotels Found</span>
        </div>

        @forelse($results as $hotel)
            <div class="card border-0 shadow-sm mb-4 overflow-hidden result-card">
                <div class="row g-0">
                    <div class="col-md-4 bg-light d-flex align-items-center justify-content-center position-relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="0.5"
                            stroke="currentColor" class="text-muted opacity-25" style="width: 100px;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                        </svg>
                    </div>

                    <div class="col-md-8">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <h3 class="fw-bold text-dark mb-1">{{ $hotel->name }}</h3>
                                <p class="text-muted small mb-0 d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        style="width:14px; height:14px;" class="text-primary me-1">
                                        <path fill-rule="evenodd"
                                            d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.152-.722c1.102-.736 2.531-1.812 3.857-3.446 1.347-1.664 2.323-3.541 2.323-5.727 0-4.641-3.729-8.484-8.401-8.484-4.673 0-8.401 3.843-8.401 8.484 0 2.186.976 4.063 2.323 5.727 1.325 1.634 2.755 2.71 3.858 3.446.474.316.86.541 1.152.722zM12 14.5a3 3 0 100-6 3 3 0 000 6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $hotel->city }}, {{ $hotel->country }} , {{ $hotel->rooms->count() }} Rooms, 
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
                                
                                </p>
                            </div>

                            <div class="bg-light rounded p-3">
                                <h6 class="fw-bold small text-uppercase text-muted mb-3">Available Room Options</h6>

                                @foreach ($hotel->rooms as $room)
                                    <div
                                        class="d-flex justify-content-between align-items-center py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <div>
                                            <span class="fw-bold d-block text-dark">{{ $room->name }}</span>
                                            <small class="text-muted d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" style="width:14px; height:14px;" class="me-1">
                                                    <path
                                                        d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122z" />
                                                </svg>
                                                Fits {{ $room->max_occupancy }} guests
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <span
                                                class="text-muted small d-block mb-1">${{ number_format($room->price_per_night, 2) }}
                                                / night</span>
                                            <div class="text-success fw-bold h5 mb-2">
                                                Total: ${{ number_format($room->total_calculated_price, 2) }}
                                            </div>
                                            <button class="btn btn-primary btn-sm px-4 shadow-sm fw-bold">Select
                                                Room</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 card border-0 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                    stroke="currentColor" class="text-muted mx-auto mb-3" style="width: 64px;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <h5 class="text-muted">No accommodation found. Try adjusting your dates or city.</h5>
            </div>
        @endforelse
        @if ($results->hasPages())
            <div class="card-footer bg-white d-flex justify-content-center">
                {{ $results->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <style>
        .result-card {
            transition: transform 0.2s;
        }

        .result-card:hover {
            transform: translateY(-3px);
        }
    </style>
@endsection
