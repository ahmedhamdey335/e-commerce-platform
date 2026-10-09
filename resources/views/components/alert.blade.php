@props([ 'type' => 'info', 'message' => null ])

@php
    $colors = [
        'success' => ['bg' => 'bg-green-50 dark:bg-green-900/30', 'border' => 'border-green-200 dark:border-green-800', 'text' => 'text-green-700 dark:text-green-400'],
        'error' => ['bg' => 'bg-rose-50 dark:bg-rose-900/30', 'border' => 'border-rose-200 dark:border-rose-800', 'text' => 'text-rose-700 dark:text-rose-400'],
        'info' => ['bg' => 'bg-blue-50 dark:bg-blue-900/30', 'border' => 'border-blue-200 dark:border-blue-800', 'text' => 'text-blue-700 dark:text-blue-400'],
    ];
    $style = $colors[$type] ?? $colors['info'];
@endphp

<div {{ $attributes->merge(['class' => "rounded-2xl p-4 border {$style['border']} {$style['bg']}"]) }}>
    <div class="text-sm font-medium {{ $style['text'] }}">
        @if($message)
            {{ $message }}
        @else
            {{ $slot }}
        @endif
    </div>
</div>
