@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 mb-4">
                <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="img-fluid rounded shadow">
            </div>
            <div class="col-12 col-lg-6">
                <h1 class="mb-3">{{ $pizza->name }}</h1>
                <p><strong>{{ __('menu.price') }}: </strong>{{ $pizza->total_price->formatted }}</p>

                <h4 class="mb-3">{{ __('menu.title_ingredients') }}</h4>
                <ul class="list-group mb-3">
                    @forelse($pizza->ingredients as $ingredient)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $ingredient->name }}
                            <span class="badge bg-primary">{{ $ingredient->price->formatted }}</span>
                        </li>
                    @empty
                        <li class="list-group-item">{{ __('menu.no_ingredients') }}</li>
                    @endforelse
                </ul>

                <div class="d-flex">
                    <a href="{{ route('pizzas.edit', $pizza->id) }}" class="btn btn-warning me-2">{{ __('menu.edit') }}</a>
                    <form action="{{ route('pizzas.destroy', $pizza->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">{{ __('menu.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>

        <a href="{{ route('pizzas.index') }}" class="btn btn-secondary mt-4">{{ __('menu.back_to_list') }}</a>
    </div>
@endsection
