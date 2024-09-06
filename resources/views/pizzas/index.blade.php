@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('menu.title_pizzas') }}</h1>
        <a href="{{ route('pizzas.create') }}" class="btn btn-primary mb-3">{{ __('menu.create_pizza') }}</a>
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="d-none d-lg-table-cell"></th>
                <th>{{ __('menu.name') }}</th>
                <th>{{ __('menu.title_ingredients') }}</th>
                <th>{{ __('menu.price') }}</th>
                <th>{{ __('menu.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($viewModel->pizzas() as $pizza)
                <tr>
                    <td class="d-none d-lg-table-cell"><img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="rounded pizza-thumb"></td>
                    <td>{{ $pizza->name }}</td>
                    <td>
                        @foreach($pizza->ingredients as $ingredient)
                            {{ $ingredient->name }} ({{ $ingredient->price->formatted }})@if(!$loop->last){{","}}@endif
                        @endforeach
                    </td>
                    <td>{{ $pizza->total_price->formatted }}</td>
                    <td>
                        <div class="d-flex flex-column">
                            <a href="{{ route('pizzas.edit', $pizza->id) }}" class="btn btn-warning mb-2 w-100">{{ __('menu.edit') }}</a>
                            <form action="{{ route('pizzas.destroy', $pizza->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger w-100">{{ __('menu.delete') }}</button>
                            </form>
                        </div>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">{{ __('menu.no_pizzas') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $viewModel->pizzas()->links('components.pagination') }}
    </div>
@endsection
