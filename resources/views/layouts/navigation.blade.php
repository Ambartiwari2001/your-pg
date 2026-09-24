<nav x-data="{ open: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
     :class="scrolled ? 'shadow-soft bg-white/95' : 'bg-white/80'"
     class="glass-nav transition-shadow duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 lg:h-18">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <span class="w-10 h-10 rounded-xl hero-gradient flex items-center justify-center text-white font-bold text-sm shadow-soft group-hover:shadow-glow transition-shadow duration-300">AP</span>
                    <span class="font-bold text-lg text-slate-900 hidden sm:block">Stay<span class="text-brand-600">Ease</span></span>
                </a>

                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:text-brand-600 hover:bg-brand-50/50' }}">
                        Home
                    </a>
                    <a href="{{ route('pgs.index') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('pgs.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:text-brand-600 hover:bg-brand-50/50' }}">
                        Browse PGs
                    </a>
                    @auth
                        @if(auth()->user()->role !== 'admin')
                            <a href="{{ route('dashboard') }}"
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:text-brand-600 hover:bg-brand-50/50' }}">
                                Dashboard
                            </a>
                        @endif
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.*') ? 'bg-violet-50 text-violet-700' : 'text-slate-600 hover:text-violet-600 hover:bg-violet-50/50' }}">
                                Admin
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden md:flex items-center gap-3">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 transition-all duration-200">
                                <span class="w-8 h-8 rounded-full hero-gradient flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost text-sm">Log in</a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm py-2.5 px-5">Get Started</a>
                @endauth
            </div>

            <div class="flex items-center md:hidden">
                <button @click="open = !open" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-slate-100 bg-white/95 backdrop-blur-xl"
         style="display: none;">
        <div class="px-4 py-4 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('home') ? 'bg-brand-50 text-brand-700' : 'text-slate-600' }}">Home</a>
            <a href="{{ route('pgs.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('pgs.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-600' }}">Browse PGs</a>
            @auth
                @if(auth()->user()->role !== 'admin')
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700' : 'text-slate-600' }}">Dashboard</a>
                @endif
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('admin.*') ? 'bg-violet-50 text-violet-700' : 'text-slate-600' }}">Admin</a>
                @endif
            @endauth
        </div>
        @auth
            <div class="px-4 py-4 border-t border-slate-100">
                <p class="px-4 text-sm font-medium text-slate-900">{{ Auth::user()->name }}</p>
                <p class="px-4 text-xs text-slate-500 mb-3">{{ Auth::user()->email }}</p>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-600">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600">Log Out</button>
                </form>
            </div>
        @else
            <div class="px-4 py-4 border-t border-slate-100 flex gap-3">
                <a href="{{ route('login') }}" class="flex-1 text-center py-2.5 rounded-xl border border-slate-200 text-sm font-medium">Log in</a>
                <a href="{{ route('register') }}" class="flex-1 text-center py-2.5 rounded-xl hero-gradient text-white text-sm font-medium">Register</a>
            </div>
        @endauth
    </div>
</nav>
