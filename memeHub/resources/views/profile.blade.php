
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
       {{ __('profile.Profile') }}
    </h2>
    <div class='row justify-content-center'>
        <div class='col-2'>
             <x-nav-link href="/profile/upload" :active="request()->routeIs('UploadController.index')">
                        {{ __('profile.Upload your meme') }}
             </x-nav-link>
        </div>
        <div class='col-1'>
             <x-nav-link href="/profile/library" :active="request()->routeIs('LibraryController.index')">
                        {{ __('profile.Library') }}
             </x-nav-link>
        </div>
        <div class='col-2'>
             <x-nav-link href="/profile/mymemes" :active="request()->routeIs('LibraryController.showmymemes')">
                        {{ __('profile.My memes') }}
             </x-nav-link>
        </div>
    </div>
</x-slot>
<div class='container mt-3'>
    @can('is-moder')
    <h3>{{ __('profile.Find user') }}:</h3>
    <div class="flex mt-9">
        <form action='/profile' method="GET">
        @csrf
            <input type="text" name="name" placeholder="{{ __('profile.Enter username') }}">
            <x-button type="submit">{{ __('profile.Search') }}</x-button>
        </form>
    </div>
    @isset($users)
   <div class="hidden sm:flex sm:items-center sm:ml-6">
        @foreach($users as $user)
        <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex-item pl-6 width-30">{{$user->name}}<p>{{$user->role}}</p></button>
                    </x-slot>
                <x-slot name="content" >
                    @can('is-admin')
                    <form method="GET" action="{{ action([App\Http\Controllers\ProfileController::class, 'findUser'], $user->id) }}">
                    @csrf
                    <p>
                    <input type="submit" value="Change role">
                    </p>
                    </form>
                    @endcan
                   <form method="GET" action="{{ action([App\Http\Controllers\ProfileController::class, 'showBanUser'], $user->id) }}">
                        @csrf
                        <p>
                        <input type="submit" value="Block">
                        </p>
                        </form>
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
                    <label for="name">{{ __('profile.Name') }}:</label>
                    <input type="text" style="width:250px;" name="name" id="name" value="{{Auth::user()->name}}" class="mb-1 form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                    <label for="email">{{ __('profile.Email') }}</label>
                    <input type="email" style="width:250px;" name="email" id="name" value="{{Auth::user()->email}}" class='mb-3 form-control @error('email') is-invalid @enderror'>
                    @error('email')
                        <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                    <label for="keyword">{{ __('profile.Keywords') }}:</label>
                    @foreach($keywords as $keyword)
                    <input type="text" id="keyword" value="{{$keyword}}" disabled class='mt-2'>
                    <a href='{{url('profile/delete/'.$keyword)}}' class="btn"><i class='fa fa-trash'></i></a>
                    @endforeach
                    @empty($keywords)
                    <p style="color:red">{{ __('profile.You haven\'t any keywords!') }}</p>
                    @endempty
                    </div>
                        <div class="mt-4" id="toAppend">
                            <label for="keyword_new">{{ __('profile.Add') }}:</label>
                            <select id="keyword_new" name='keyword' class="mb-3 mr-2">
                                @foreach($meme_keywords as $meme_keyword)
                                <option value="{{$meme_keyword}}">{{$meme_keyword}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-light" id="btn-add" onclick="newform()"><i class="fa fa-plus"></i></button>
                    <input type="submit" value="{{ __('profile.Update') }}" class="btn btn-primary ml-2"> 
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
