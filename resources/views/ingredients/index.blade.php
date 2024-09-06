@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>{{ __('menu.title_ingredients') }}</h1>
        <a href="{{ route('ingredients.create') }}" class="btn btn-primary mb-3">{{ __('menu.create_ingredient') }}</a>
        <table class="table">
            <thead>
            <tr>
                <th>{{ __('menu.name') }}</th>
                <th>{{ __('menu.price') }}</th>
                <th>{{ __('menu.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($viewModel->ingredients() as $ingredient)
                <tr>
                    <td>{{ $ingredient->name }}</td>
                    <td>{{ $ingredient->price->formatted }}</td>
                    <td>
                        <a href="{{ route('ingredients.edit', $ingredient->id) }}" class="btn btn-warning">{{ __('menu.edit') }}</a>
                        <form action="{{ route('ingredients.destroy', $ingredient->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">{{ __('menu.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $viewModel->ingredients()->links('components.pagination') }}

    </div>
@endsection
