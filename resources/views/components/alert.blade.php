@if (session()->has($type))
    <div class="alert alert-{{ $type }}" style="{{ $style ?? 'margin-left: 250px' }}">
        <h5 class="text-center">{{ session($type) }}</h5>
    </div>
@endif
