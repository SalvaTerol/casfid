@extends('layouts.app')

@section('content')


    <div class="container">
        <h1>{{ isset($pizza) ?  __('menu.edit_pizza') : __('menu.create_pizza') }}</h1>
        <form action="{{ isset($pizza) ? route('pizzas.update', $pizza->id) : route('pizzas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($pizza))
                @method('PUT')
            @endif
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('menu.name') }}</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $pizza->name ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">{{ __('menu.image') }}</label>
                <input type="file" name="image" class="form-control" id="image">
                @if(isset($pizza) && $pizza->image)
                    <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="img-thumbnail mt-2" style="max-width: 150px;">
                @endif
            </div>
            <div class="mb-3">
                <label for="ingredients" class="form-label">{{ __('menu.title_ingredients') }}</label>
                <select name="ingredients[]" id="ingredients" class="js-choice" multiple required>
                    @foreach($ingredients as $ingredient)
                        <option value="{{ $ingredient->id }}"
                                @if(isset($pizza) && $pizza->ingredients->contains(fn($ing) => $ing->id === $ingredient->id)) selected @endif>
                            {{ $ingredient->name }} ({{ $ingredient->price->formatted }})
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">{{ isset($pizza) ? __('menu.update') : __('menu.create') }}</button>
            <a href="{{ route('pizzas.index') }}" class="btn btn-secondary">{{ __('menu.cancel') }}</a>
        </form>
    </div>
@endsection

@push('styles')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css"
    />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    <script type="text/javascript">
        const element = document.querySelector('.js-choice');
        const choices = new Choices(element);
    </script>
@endpush
