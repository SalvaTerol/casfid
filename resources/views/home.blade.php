@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('menu.title_pizzas') }}</h1>
        <div class="row">
            @forelse($viewModel->pizzas() as $pizza)
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4 d-flex">
                    <div class="card h-100 d-flex flex-column">
                        <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="card-img-top">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $pizza->name }}</h5>
                            <p class="card-text mb-2">
                                <strong>{{ __('menu.price') }}:</strong> {{ $pizza->total_price->formatted }}
                            </p>
                        </div>
                        <div class="card-footer flex-grow-1 d-flex flex-column">
                            <strong>{{ __('menu.title_ingredients') }}:</strong>
                            <div class="d-flex">
                                <p class="mb-0">
                                    @foreach($pizza->ingredients as $ingredient)
                                        {{ $ingredient->name }}@if(!$loop->last){{","}}@endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning">{{ __('menu.no_pizzas') }}</div>
                </div>
            @endforelse
        </div>

        {{ $viewModel->pizzas()->links('components.pagination') }}
    </div>
@endsection
