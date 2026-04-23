@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full border-slate-200 bg-slate-50 focus:bg-white focus:border-primary focus:ring-primary rounded-xl shadow-sm text-sm font-medium transition-colors']) !!}>
