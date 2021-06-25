<x-guest-layout>
    <link rel="stylesheet" href="{{asset('font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                </div>
        
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
<!--            <div class="flex items-center justify-end mt-4"> 
              <x-button class="ml-3">
                    {{ __('Log in with google') }}
               </x-button>
              <x-button class="ml-3">
                    {{ __('Log in with facebook') }}
              </x-button>
            </div>-->
            <div class="flex items-center justify-end mt-4">
                
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
        <div class="row">
            <a href="{{route('login.google')}}" class="btn btn-block"><i class="fa fa-google"></i></a>
            <a href="{{route('login.facebook')}}" class="btn btn-block"><i class="fa fa-facebook"></i></a>
        </div>
    </x-auth-card>
</x-guest-layout>
