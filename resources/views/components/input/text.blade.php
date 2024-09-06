@props(['type' => 'text', 'size' => null, 'prefix' => null, 'suffix' => null])
@isset($prefix)
    <span class="input-group-text">{{ $prefix }}</span>
@endisset
<input type="{{ $type }}" {{ $attributes->class([ 'form-control', 'form-control-sm' => $size === 'sm', 'form-control-lg' => $size === 'lg' ]) }} >
@isset($suffix)
    <span class="input-group-text">{{ $suffix }}</span>
@endisset
