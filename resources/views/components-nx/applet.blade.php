{{--
    nx-applet — interaktives Mini-Widget in einem sandboxed <iframe>.

    Author-HTML/JS läuft mit sandbox="allow-scripts" OHNE allow-same-origin →
    opaque origin: kann JS ausführen, aber NICHT die Host-Seite/Cookies/Livewire
    berühren. XSS-sicher, auch bei beliebigem Script-Inhalt. Höhe kommt per
    postMessage aus dem iframe zurück.

    <x-nx-applet :code="$block['code']" />

      code : rohes HTML/JS des Widgets (nur der Body)
--}}
@props(['code' => ''])

@php
    $style = ':root{color-scheme:light dark}*{box-sizing:border-box}html,body{margin:0;padding:0}'
        . 'body{font-family:ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;font-size:15px;line-height:1.55;color:#1e1b2e;padding:14px 16px}'
        . '@media(prefers-color-scheme:dark){body{color:#e5e7eb}}'
        . 'h1,h2,h3,h4{margin:0 0 .5rem;font-family:ui-monospace,"JetBrains Mono",monospace}'
        . 'label{display:block;font-weight:600;margin:0 0 .35rem}'
        . 'input,textarea,select{font:inherit;width:100%;max-width:100%;padding:.55rem .7rem;border:1px solid #c7c9d9;border-radius:.65rem;background:#fff;color:#111}'
        . 'textarea{min-height:3rem}@media(prefers-color-scheme:dark){input,textarea,select{background:#1f2030;color:#e5e7eb;border-color:#3a3b52}}'
        . 'button{font:inherit;cursor:pointer;padding:.55rem .9rem;border:0;border-radius:.65rem;background:#4F46E5;color:#fff;font-weight:600}button:hover{background:#4338ca}'
        . 'pre,.out{background:#f4f4fb;border-radius:.65rem;padding:.65rem .8rem;margin:.6rem 0 0;overflow-x:auto;font-family:ui-monospace,monospace;font-size:14px;white-space:pre-wrap;word-break:break-word;min-height:1.2rem}'
        . '@media(prefers-color-scheme:dark){pre,.out{background:#15161f}}'
        . '.row{display:flex;flex-direction:column;gap:.6rem}.muted{color:#6b7280;font-size:13px}';

    $resize = '(function(){function r(){var h=Math.ceil(document.body.getBoundingClientRect().height)+2;parent.postMessage({__nxApplet:true,height:h},"*");}'
        . 'window.addEventListener("load",r);document.addEventListener("input",r,true);document.addEventListener("change",r,true);document.addEventListener("click",r,true);'
        . 'if(window.ResizeObserver){try{new ResizeObserver(r).observe(document.body);}catch(e){}}setTimeout(r,60);setTimeout(r,300);})();';

    $doc = '<!doctype html><html lang="de"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">'
        . '<style>' . $style . '</style></head><body>' . $code . '<script>' . $resize . '</script></body></html>';
@endphp

<div x-data="{ h: 120 }"
     x-init="window.addEventListener('message', e => { if (e.data && e.data.__nxApplet) { h = e.data.height } })"
     {{ $attributes->class('overflow-hidden rounded-[8px] border border-[color:var(--nx-line)] bg-[color:var(--nx-surface)]') }}>
    <div class="flex items-center gap-1.5 border-b border-[color:var(--nx-line)] px-3 py-1.5 text-[11px] text-[color:var(--nx-faint)]">
        <span class="h-1.5 w-1.5 rounded-full bg-[color:var(--nx-success)]"></span> Interaktiv · ausprobieren
    </div>
    <iframe sandbox="allow-scripts" loading="lazy" title="Interaktives Beispiel"
            :style="'height:' + h + 'px'" class="block w-full border-0"
            srcdoc="{{ $doc }}"></iframe>
</div>
