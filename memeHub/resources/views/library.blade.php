
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('showmeme.Library') }}
    </h2>
</x-slot>
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-10'>
            <div class="card">
               
                <div class='card-body'>
                    <div class='container mt-2'>
                        <div class='row justify-content-center'>
                        <div class='col-md-8'>
                        @forelse($memes as $lib_meme)
                            @if(Auth::check())
                        
                            <a href="/meme/{{$lib_meme->meme->id}}" target="_blank">
                                <div class='card m-3 bg-dark'>
                                    <img src='{{ asset($lib_meme->meme->meme)}}' class="card-img-top pb-5 " alt='something' >
                                </div>
                            <div class="row justify-content-begin form-group">
                                <h6 class="btn btn-warning">{{ __('showmeme.Add comment') }}</h6>
                            </div>
                            <div class="row justify-content-end">
                                <!--<form action='/profile/library/{{$lib_meme->id}}' method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <input type="submit" value="{{ __('showmeme.Delete from library') }}" class="btn btn-danger">
                                </form>-->

                            </div>

                            @endif
                            @empty
                                <p>{{ __('showmeme.No memes') }}!</p>
                        @endforelse
                        
                        </div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
