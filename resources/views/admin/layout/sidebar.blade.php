<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a>
    </div>
    <ul class="sidebar-menu">
        <li><a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-th"></i>
                <span>Dashboard</span>
            </a>
        </li>
        @foreach ($sidemenus as $s)
            @if (count($s->submenu($s->id)) > 0)
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">{!! $s->icon !!}
                        <span>{{ $s->title }}</span></a>
                    <ul class="dropdown-menu">
                        @foreach ($s->submenu($s->id) as $sub)
                            <li><a class="nav-link" href="/{{ $sub->uri }}">{{ $sub->title }}</a></li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li><a class="nav-link"
                        href="/{{ $s->uri }}">{!! $s->icon !!}<span>{{ $s->title }}</span></a>
                </li>
            @endif
        @endforeach
    </ul>
</aside>
