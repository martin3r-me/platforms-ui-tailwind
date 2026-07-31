{{--
    nx-code — Code-Block mit Copy-Button (Notion-Stil, dunkle Fläche).

    Eigene dunkle Fläche via inline-style (gewinnt auch im .nx-prose-Kontext).
    Copy liest den rohen Text aus dem <code>-Element.

    <x-nx-code language="php" :code="$code" />

      code     : roher Code (wird escaped ausgegeben)
      language : optionales Sprach-Label (rechts oben)
--}}
@props(['code' => '', 'language' => null])

<div x-data="{ copied: false, copy() { navigator.clipboard.writeText(this.$refs.src.textContent); this.copied = true; setTimeout(() => this.copied = false, 1500); } }"
     {{ $attributes->class('group relative') }}>
    <div class="absolute right-2 top-2 z-10 flex items-center gap-2">
        @if($language)
            <span class="text-[10px] uppercase tracking-wider text-[color:rgba(255,255,255,.4)]">{{ $language }}</span>
        @endif
        <button type="button" @click="copy()"
                class="rounded-md border border-[color:rgba(255,255,255,.15)] px-2 py-0.5 text-[11px] text-[color:rgba(255,255,255,.7)] opacity-0 transition group-hover:opacity-100 hover:bg-[color:rgba(255,255,255,.1)]">
            <span x-show="!copied">Kopieren</span>
            <span x-show="copied" class="text-[color:var(--nx-success)]">✓ kopiert</span>
        </button>
    </div>
    <pre class="overflow-x-auto rounded-[8px] p-4 text-[13px] leading-relaxed"
         style="background:var(--nx-accent);color:var(--nx-on-accent)"><code x-ref="src" class="font-mono">{{ $code }}</code></pre>
</div>
