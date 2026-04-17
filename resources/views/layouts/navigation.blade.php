<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- LEFT --}}
            <div class="flex">

                {{-- LOGO --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                {{-- MENU --}}
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('pengaduan.index')" :active="request()->routeIs('pengaduan.*')">
                        Pengaduan
                    </x-nav-link>

                    {{-- ADMIN SPMI SAJA --}}
                    @if(auth()->user()->isAdmin())
                    <x-nav-link :href="route('dashboard.pengaduan')" :active="request()->routeIs('dashboard.pengaduan')">
                        Dashboard SPMI
                    </x-nav-link>
                    @endif

                </div>
            </div>

            {{-- USER --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm text-gray-500 bg-white rounded-md">
                            {{ Auth::user()->name }} ({{ Auth::user()->role }})
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </x-dropdown-link>
                        </form>
                    </x-slot>

                </x-dropdown>
            </div>

            {{-- HAMBURGER --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 text-gray-400">
                    ☰
                </button>
            </div>

        </div>
    </div>

    {{-- MOBILE --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <x-responsive-nav-link :href="route('dashboard')">
            Dashboard
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('pengaduan.index')">
            Pengaduan
        </x-responsive-nav-link>

        @if(auth()->user()->isAdmin())
        <x-responsive-nav-link :href="route('dashboard.pengaduan')">
            Dashboard SPMI
        </x-responsive-nav-link>
        @endif

    </div>

</nav>