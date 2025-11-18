@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-black-300 bg-white bg-opacity-50 text-black focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
