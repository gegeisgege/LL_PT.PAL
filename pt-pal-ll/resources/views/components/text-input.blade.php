@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-ink focus:ring-ink rounded-md shadow-sm']) }}>