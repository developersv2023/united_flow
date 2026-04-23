@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-[11px] text-slate-500 uppercase tracking-widest mb-1']) }}>
    {{ $value ?? $slot }}
</label>
