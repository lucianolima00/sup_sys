@props(['disabled' => false, 'select2'=>false, 'data' => []])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
    <option value='0'>{{ $attributes['placeholder'] }}</option>
    @if(!$select2)
        @foreach($data as $key => $data_option)
            <option value='{{ $key }}'>{{ $data_option }}</option>
        @endforeach
    @endif
</select>
