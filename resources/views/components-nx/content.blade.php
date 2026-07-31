{{--
    nx-content — rendert eine Block-Liste des Core-ContentParsers.

    Der Consumer parst Markdown zu Blöcken und übergibt sie:
        $doc = app(\Platform\Core\Content\ContentParser::class)->parse($markdown);
        <x-nx-content :blocks="$doc['blocks']" />

    Text-Blöcke (heading/paragraph/list/quote/divider) laufen im .nx-prose-Kontext;
    Rich-Blöcke (callout/code/applet/figure) werden zu eigenständigen nx-Komponenten.
    Unbekannte/GFM-Blöcke kommen als html-Passthrough (bereits sicher) durch.

      blocks : array<int, array{type: string, ...}>  (aus ContentParser::parse()['blocks'])
--}}
@props(['blocks' => []])

<div {{ $attributes->class('nx-prose text-[color:var(--nx-text)]') }}>
    @foreach($blocks as $b)
        @php $t = $b['type'] ?? null; @endphp
        @switch($t)
            @case('heading')
                @php $h = 'h' . min(max((int) ($b['level'] ?? 2), 1), 4); @endphp
                <{{ $h }} @if(!empty($b['anchor'])) id="{{ $b['anchor'] }}" @endif>{!! $b['inline_html'] ?? '' !!}</{{ $h }}>
                @break

            @case('paragraph')
                <p>{!! $b['inline_html'] ?? '' !!}</p>
                @break

            @case('list')
                @php $tag = ($b['ordered'] ?? false) ? 'ol' : 'ul'; @endphp
                <{{ $tag }}>
                    @foreach(($b['items'] ?? []) as $item)
                        <li>{!! $item !!}</li>
                    @endforeach
                </{{ $tag }}>
                @break

            @case('quote')
                <blockquote>{!! $b['inline_html'] ?? '' !!}</blockquote>
                @break

            @case('divider')
                <hr>
                @break

            @case('callout')
                <div class="my-4">
                    <x-nx-callout :variant="$b['variant'] ?? 'info'">{!! $b['inline_html'] ?? '' !!}</x-nx-callout>
                </div>
                @break

            @case('code')
                <div class="my-4">
                    <x-nx-code :language="$b['language'] ?? null" :code="$b['code'] ?? ''" />
                </div>
                @break

            @case('applet')
                <div class="my-4">
                    <x-nx-applet :code="$b['code'] ?? ''" />
                </div>
                @break

            @case('figure')
                <div class="my-4">
                    <x-nx-figure :src="$b['src'] ?? ''" :alt="$b['alt'] ?? ''" :caption="$b['caption'] ?? null" />
                </div>
                @break

            @case('html')
                {!! $b['html'] ?? '' !!}
                @break
        @endswitch
    @endforeach
</div>
