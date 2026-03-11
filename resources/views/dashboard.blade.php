@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">System Overview</h2>

    <div class="row">
        @foreach($allCards as $card)
            <div class="col-md-4 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted small text-uppercase fw-bold mb-1">{{ $card['title'] }}</p>
                                <h3 class="mb-0 fw-bold">{{ $card['value'] }}</h3>
                            </div>
                            <div class="rounded-circle bg-{{ $card['color'] }} bg-opacity-10 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-{{ $card['color'] }}" style="width: 24px; height: 24px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['svg_path'] }}" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection