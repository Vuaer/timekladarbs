
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
       {{ __('profile.Profile') }}
    </h2>
</x-slot>
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-10'>
             <x-nav-link href="/profile/upload" :active="request()->routeIs('UploadController.index')">
                        {{ __('profile.Upload your meme') }}
             </x-nav-link>
             <x-nav-link href="/profile/library" :active="request()->routeIs('LibraryController.index')">
                        {{ __('profile.Library') }}
             </x-nav-link>
             <x-nav-link href="/profile/mymemes" :active="request()->routeIs('LibraryController.showmymemes')">
                        {{ __('profile.My memes') }}
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
   <div class="hidden sm:flex sm:items-center sm:ml-6">
        @foreach($users as $user)
        <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button>{{$user->name}}<p>{{$user->role}}</p></button>
                    </x-slot>
                <x-slot name="content" >
                    <form method="GET" action="{{ action([App\Http\Controllers\ProfileController::class, 'findUser'], $user->id) }}">
                    @csrf
                    <p>
                    <input type="submit" value="Change role">
                    </p>
                    </form>
                    <p>Block</p>
                </x-slot>
                </x-dropdown>
        @endforeach
    </div>
    @endisset
    @endcan
    <div class="container">
        <div class="row">
            <div class="col-8">
                <form method="POST" action="{{route('profile.update')}}">
                    @csrf
                    @method('PUT')
                    <div class='col-3'>
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" value="{{Auth::user()->name}}" class="mb-1">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="name" value="{{Auth::user()->email}}" class='mb-3'>
                    <label for="keyword">Keywords:</label>
                    @foreach($keywords as $keyword)
                    <input type="text" id="keyword" value="{{$keyword}}" disabled class='mt-2'>
                    <a href='{{url('profile/delete/'.$keyword)}}' class="btn"><i class='fa fa-trash'></i></a>
                    @endforeach
                    @empty($keywords)
                    <p style="color:red">You haven't any keywords!</p>
                    @endempty
                    </div>
                        <div class="mt-4" id="toAppend">
                            <label for="keyword_new">Add:</label>
                            <select id="keyword_new" name='keyword' class="mb-3 mr-2">
                                @foreach($meme_keywords as $meme_keyword)
                                <option value="{{$meme_keyword}}">{{$meme_keyword}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-light" id="btn-add" onclick="newform()"><i class="fa fa-plus"></i></button>
                    <input type="submit" value="Update" class="btn btn-primary ml-2"> 
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function changeRole(userId)
{
    window.location.href="/changerole/"+userId;
}

var number=0;
function newform(){
    $("#keyword_new").clone().attr("name","keyword"+number).appendTo("#toAppend");
    number++;
}
</script>
</x-app-layout>
