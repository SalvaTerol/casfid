@props([
    'label',
    'for',
    'error' => false,
    'inline' => false,
])

@props([
    'label',
    'for',
    'error' => false,
    'inline' => false,
])

@if($inline)
    <div class="row">
        <div class="col">
            <label for="{{ $for }}" class="form-label">{{ $label }}</label>
            <div class="input-group">{{ $slot }}</div>
        </div>
    </div>
@else
    <div class="mb-3">
        <label for="{{ $for }}" class="form-label">{{ $label }}</label>
        <div class="input-group">{{ $slot }}</div>
        @if($error)
            <div class="text-danger mt-1">{{ $error }}</div>
        @endif
    </div>
@endif
