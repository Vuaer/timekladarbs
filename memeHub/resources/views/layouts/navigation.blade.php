
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sm:pb-10">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl px-4 sm:px-6 mx-auto lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
                <div class="flex-shrink-0 flex items-left">
                    <a href="{{ route('meme.index') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>
            <div class="flex">            
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:mt-10 sm:flex">
                    <x-nav-link :href="route('meme.index')" :active="request()->routeIs('meme.index') ">
                        {{ __('navigation.Dashboard') }}
                    </x-nav-link>
                    <x-nav-link href="/profile" :active="request()->routeIs('ProfileController.index')"> 
                        {{ __('navigation.Profile') }}
                    </x-nav-link>
                    <x-nav-link href="/profile/library" :active="request()->routeIs('LibraryController.index')">
                        {{ __('navigation.Library') }}
                    </x-nav-link>
                    <x-nav-link href="/create" :active="request()->routeIs('CreateController.index')">
                        {{ __('navigation.Create') }}
                    </x-nav-link>
                    <a href="{{route('locale','lv')}}">{{ __('Change language') }} </a> 
                  
                    
                </div>
            </div>
            <div class="flex mt-9">
                <form method="GET" action="{{route('meme.search')}}">
                    @csrf
                    <input  type="text" name="keyword" required/>
                    <x-button type="submit"><i class='fa fa-search'></i></x-button>
                </form>
            </div>

            <!-- Settings Dropdown -->
            @if(Auth::check())
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex mt-8 bg-gray-800 border border-transparent rounded-md font-semibold inline-flex items-center px-4 py-2 text-white">
                            <div style="font-size:16px;">{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content" >
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout') "
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('navigation.Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endif
            @if(Auth::guest())
            <div class="flex mt-8 bg-gray-800 border border-transparent rounded-md font-semibold inline-flex items-center px-4 py-2">            
                <x-nav-link :href="route('login')" :active="request()->routeIs('Login')" class="text-white">{{__('navigation.Log in')}}</x-nav-link>         
            </div>
            @endif

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden flex">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('meme.index')" :active="request()->routeIs('meme.index')">
                {{ __('navigation.Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @if(Auth::check())
        <div >
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('navigation.Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endif
    </div>
</nav>
