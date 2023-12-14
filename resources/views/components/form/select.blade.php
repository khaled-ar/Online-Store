
<select
    style="{{$style}}"
    name="{{$name}}"
    class="{{$class}}"
>
    @foreach ($options as $value => $text)
        <option value="{{$value}}" @selected($value == $selected)>{{$text}}
        </option>
    @endforeach
</select>
