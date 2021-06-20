
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        User profile
    </h2>
</x-slot>
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-10'>
             <x-nav-link href="/profile/upload" :active="request()->routeIs('UploadController.index')">
                        {{ __('Upload your meme') }}
             </x-nav-link>
             <x-nav-link href="/profile/library" :active="request()->routeIs('LibraryController.index')">
                        {{ __('Library') }}
             </x-nav-link>
             <x-nav-link href="/profile/mymemes" :active="request()->routeIs('LibraryController.showmymemes')">
                        {{ __('My memes') }}
             </x-nav-link>
        </div>
    </div>
</div>
</x-app-layout>
