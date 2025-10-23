<ul id="{{$submenuTargetId}}" class="nav-content collapse" data-bs-parent="#sidebar-nav">
    @if (isset($menu))
        @foreach ($menu as $submenu)
            {{-- active menu method --}}
            @php
                $activeClass = null;
                $currentRouteName = Route::currentRouteName();

                if ($currentRouteName === $submenu->slug) {
                    $activeClass = 'active';
                }

            @endphp

            <li>
                <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
                    class="{{ $activeClass }} {{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                    @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
                    @if (isset($submenu->icon))
                        <i class="{{ $submenu->icon }}"></i>
                    @endif
                    <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
                    @isset($submenu->badge)
                        <div class="badge bg-{{ $submenu->badge[0] }} rounded-pill ms-auto">{{ $submenu->badge[1] }}</div>
                    @endisset
                </a>

                {{-- submenu --}}
                @if (isset($submenu->submenu))
                    @include('layouts.user.menu.submenu', ['menu' => $submenu->submenu])
                @endif
            </li>
        @endforeach
    @endif
</ul>
