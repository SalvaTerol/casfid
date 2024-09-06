@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($ingredient) ? __('menu.edit_ingredient') : __('menu.create_ingredient') }}</h1>
        <form action="{{ isset($ingredient) ? route('ingredients.update', $ingredient->id) : route('ingredients.store') }}" method="POST">
            @csrf
            @if(isset($ingredient))
                @method('PUT')
            @endif
            <x-input.group for="name" label="Name" :error="$errors->first('name')">
                <x-input.text name="name" id="name" value="{{ old('name', $ingredient->name ?? '') }}" required/>
            </x-input.group>
            <x-input.group for="price" label="Price" :error="$errors->first('price')">
                <x-input.text type="number" step="0.01" name="price" id="price" value="{{ old('price', isset($ingredient) && $ingredient->price ? $ingredient->price->euro : '') }}" prefix="€" required/>
            </x-input.group>
            <x-button type="submit" color="success">{{ isset($ingredient) ? __('menu.update') : __('menu.create') }}</x-button>
            <x-button href="{{ route('ingredients.index') }}" color="secondary">{{ __('menu.cancel') }}</x-button>
        </form>
    </div>
@endsection
