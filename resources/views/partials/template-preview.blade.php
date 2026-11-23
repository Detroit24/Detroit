@props(['tmpl' => null, 'cardId' => null])

@php
    $theme = $tmpl?->preview_theme ?? [
        'style' => 'wedding-arch',
        'bg' => '#FCF9F5',
        'primary' => '#B8860B',
        'text' => '#2C241E',
        'eyebrow' => 'The Wedding Of',
        'names' => 'Elegance Wedding',
        'date' => 'SABTU, 14 DESEMBER 2026',
    ];
    $uid = $cardId ?: ('tpl-' . ($tmpl?->slug ?? 'template'));
    $namesParts = array_values(array_filter(array_map('trim', explode('&', $theme['names'] ?? ''))));
@endphp

<div id="{{ $uid }}" class="tpl-card tpl-card--{{ $theme['style'] }} tpl-anim"
     style="--tpl-bg: {{ $theme['bg'] }}; --tpl-primary: {{ $theme['primary'] }}; --tpl-text: {{ $theme['text'] }};"
     data-style="{{ $theme['style'] }}"
     data-bg="{{ $theme['bg'] }}"
     data-primary="{{ $theme['primary'] }}"
     data-text="{{ $theme['text'] }}"
     data-eyebrow="{{ $theme['eyebrow'] }}"
     data-names="{{ $theme['names'] }}"
     data-date="{{ $theme['date'] }}">

    @if($theme['style'] === 'wedding-arch')
        <div class="tpl-frame tpl-frame--arch"></div>
    @elseif($theme['style'] === 'wedding-gate')
        <div class="tpl-frame tpl-frame--gate"></div>
    @elseif($theme['style'] === 'islamic-night')
        <div class="tpl-arch"></div>
        <div class="tpl-moon"></div>
    @elseif($theme['style'] === 'islamic-peace')
        <div class="tpl-arch"></div>
    @elseif($theme['style'] === 'birthday-fun')
        <div class="tpl-balloon tpl-balloon-1"></div>
        <div class="tpl-balloon tpl-balloon-2"></div>
        <div class="tpl-balloon tpl-balloon-3"></div>
    @elseif($theme['style'] === 'nature-soft')
        <div class="tpl-frame tpl-frame--circle"></div>
    @elseif($theme['style'] === 'floral-pink')
        <div class="tpl-floral"></div>
    @elseif($theme['style'] === 'islamic-dark')
        <div class="tpl-frame tpl-frame--dashed"></div>
    @elseif($theme['style'] === 'royal-gold')
        <div class="tpl-frame tpl-frame--royal"></div>
        <div class="tpl-frame tpl-frame--royal-inner"></div>
    @elseif($theme['style'] === 'glam-party')
        <div class="tpl-frame tpl-frame--glam"></div>
    @endif

    <div class="tpl-inner">
        <span class="tpl-eyebrow">{{ $theme['eyebrow'] }}</span>

        <h4 class="tpl-names">
            @if(count($namesParts) > 1)
                <span class="tpl-name-first">{{ $namesParts[0] }}</span>
                <span class="tpl-amp">&amp;</span>
                <span class="tpl-name-last">{{ $namesParts[1] }}</span>
            @else
                <span>{{ $theme['names'] }}</span>
            @endif
        </h4>

        <div class="tpl-date">{{ $theme['date'] }}</div>

        <div class="tpl-badge">Buka Undangan</div>
    </div>
</div>
