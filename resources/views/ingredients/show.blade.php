@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h1>{{ $ingredient->name }}</h1>
                <p><strong>{{ __('menu.price') }}:</strong> {{ $ingredient->price->formatted }}</p>

                <div class="d-flex">
                    <a href="{{ route('ingredients.edit', $ingredient->id) }}" class="btn btn-warning me-2">{{ __('menu.edit') }}</a>
                    <form action="{{ route('ingredients.destroy', $ingredient->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">{{ __('menu.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>

        <a href="{{ route('ingredients.index') }}" class="btn btn-secondary mt-4">{{ __('menu.back_to_list') }}</a>
    </div>

@endsection
