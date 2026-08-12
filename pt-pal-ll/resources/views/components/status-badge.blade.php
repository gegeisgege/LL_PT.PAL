@props(['status'])

@php
$styles = [
    'draft' => 'bg-gray-100 text-gray-700 border-gray-300',
    'submitted' => 'bg-signal-amber/10 text-signal-amber border-signal-amber/40',
    'returned' => 'bg-signal-rust/10 text-signal-rust border-signal-rust/40',
    'published' => 'bg-signal-teal/10 text-signal-teal border-signal-teal/40',
];
$style = $styles[$status] ?? $styles['draft'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2 py-0.5 rounded border text-xs font-mono uppercase tracking-wide $style"]) }}>
    {{ $status }}
</span>