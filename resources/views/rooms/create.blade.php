@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('dashboard.rooms.index') }}" class="text-decoration-none text-muted small uppercase">
            <i class="fas fa-arrow-left me-1"></i> Back to Inventory
        </a>
        <h2 class="fw-bold mt-2">Add New Room Type</h2>
    </div>

    <form action="{{ route('dashboard.rooms.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4">General Information</h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Parent Hotel</label>
                            <select name="hotel_id" class="form-select @error('hotel_id') is-invalid @enderror">
                                <option value="">Select a Hotel</option>
                                @foreach($hotels as $hotel)
                                    <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                        {{ $hotel->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hotel_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Room Name / Category</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="e.g. Deluxe Ocean View" value="{{ old('name') }}">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4">Pricing & Capacity</h5>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Price per Night ($)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted">$</span>
                                <input type="number" step="0.01" name="price_per_night" class="form-control border-start-0 @error('price_per_night') is-invalid @enderror" 
                                       value="{{ old('price_per_night', 0) }}">
                            </div>
                            @error('price_per_night') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold small text-muted">Max Guests</label>
                                <input type="number" name="max_occupancy" class="form-control @error('max_occupancy') is-invalid @enderror" 
                                       value="{{ old('max_occupancy', 1) }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold small text-muted">Total Units</label>
                                <input type="number" name="rooms_count" class="form-control @error('rooms_count') is-invalid @enderror" 
                                       value="{{ old('rooms_count', 1) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Initial Available</label>
                            <input type="number" name="available_rooms" class="form-control bg-light @error('available_rooms') is-invalid @enderror" 
                                   value="{{ old('available_rooms', 1) }}" placeholder="Usually same as total">
                            <small class="text-muted italic">Defaults to Total Units if left same.</small>
                        </div>

                        <hr class="my-4 text-muted">

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                            Create Room
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection