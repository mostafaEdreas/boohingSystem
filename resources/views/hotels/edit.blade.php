@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary">Update Hotel: {{ $hotel->name }}</h5>
                    <a href="{{ route('dashboard.hotels.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('dashboard.hotels.update', $hotel->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Required for Update routes --}}

                        <div class="mb-3">
                            <label class="form-label">Hotel Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $hotel->name) }}">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country', $hotel->country) }}">
                                @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $hotel->city) }}">
                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Rating (Stars)</label>
                            <select name="rating" class="form-select @error('rating') is-invalid @enderror">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('rating', $hotel->rating) == $i ? 'selected' : '' }}>
                                        {{ $i }} {{ $i == 1 ? 'Star' : 'Stars' }}
                                    </option>
                                @endfor
                            </select>
                            @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Hotel Details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection