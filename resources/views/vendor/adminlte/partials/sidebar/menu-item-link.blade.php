<li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">

    <a class="nav-link {{ $item['class'] }} @isset($item['shift']) {{ $item['shift'] }} @endisset"
       href="{{ $item['href'] }}" @isset($item['target']) target="{{ $item['target'] }}" @endisset
       {!! $item['data-compiled'] ?? '' !!}>

        <i class="{{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{
            isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''
        }}"></i>

        <p>
            {{ $item['text'] }}

        @php
            if (theme()->isOrderMenu($item['text'])) {
                $item['label'] = theme()->getLableCount($item['text']);
                $item['label_color'] = "danger";
            }
        @endphp

            @isset($item['label'])
                <span class="badge badge-{{ $item['label_color'] ?? 'primary' }} ml-2">
                    {{ $item['label'] }}
                </span>
            @endisset
        </p>

    </a>

</li>
