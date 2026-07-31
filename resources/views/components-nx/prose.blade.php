{{--
    nx-prose — Typografie-Wrapper für Rich-Text/HTML.

    Legt den .nx-prose-Kontext (Styling in ui-styles) um beliebiges HTML —
    z. B. Str::markdown()-Output oder inline_html aus dem Core-ContentParser.
    Für strukturierte Block-Listen stattdessen <x-nx-content> nutzen.

    <x-nx-prose>{!! $html !!}</x-nx-prose>
--}}
<div {{ $attributes->class('nx-prose text-[color:var(--nx-text)]') }}>{{ $slot }}</div>
