@props([
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'style' => '',
    'name',
])

<input
    type="{{$type}}"
    style="{{$style}}"
    name="{{$name}}"
    placeholder="{{$placeholder}}"
    value="{{ old($name, $value) }}"
    {{ $attributes->class([
        'form-control',
        'is-invalid' => $errors->has($name)
    ]) }}
>
