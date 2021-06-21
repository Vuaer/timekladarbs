
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
    @can('is-moder')
    <div>
        <h3>Administrators:</h3>
        @foreach($administrators as $administrator)
        <div class="d-inline-block px-auto" style="border-style:solid; border-color:black; border-width:2px;">
           <p style="font-weight:bold; font-size:20px;"> {{$administrator->name}} </p>
        </div>
        @endforeach
        <h3>Moderators:</h3>
        @foreach($moderators as $moderator)
        <div>
           <p style="font-weight:bold; font-size:20px;"> {{$moderator->name}} </p>
        </div>
        @endforeach
    </div>
    @endcan

    @can('is-admin')
    <h3>Change user role:</h3>
    <div class="flex mt-9">
        <form action='/profile' method="GET">
        @csrf
            <input type="text" name="name" placeholder="Enter username" class="form-control @error('name') is-invalid @enderror">
            <x-button type="submit">Search</x-button>
        </form>
    </div>
    @isset($users)
    <div>
        @foreach($users as $user)
        <form action='/changerole/{{$user->id}}' method="get">
        @csrf
        <p>
        <input type="submit" value="{{$user->name}}">
        </p>
        </form>
        @endforeach
    </div>
    @endisset
    @endcan
</div>

<script>
function changeRole(userId)
{
    window.location.href="/changerole/"+userId";
}
</script>
</x-app-layout>
