@props(['type' => 'button', 'color' => 'primary', 'href' => null])
@isset($href)
    <a href="{{ $href }}" class="btn btn-{{$color}}">{{ $slot }}</a>
@else
    <button type="{{ $type }}" class="btn btn-{{$color}}">{{ $slot }}</button>
@endisset
