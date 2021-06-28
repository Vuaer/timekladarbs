
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('upload.Upload meme') }}
    </h2>
</x-slot>
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-10'> 
            <div class="card-header">
                    <h4>{{ __('upload.Upload meme') }}</h4>
                    @if(Auth::check())
                    <form action='/meme' enctype="multipart/form-data" method="POST" class='form-inline'>
                        @csrf
                        <div class='form-group'>
                            <input type='file' name='meme' class="form-control-image">
                        </div>
                        <input type='submit' value="{{ __('upload.Upload') }}" class="btn btn-primary">
                    </form>
                    @endif
                    @if(Auth::guest())
                    {{ __('upload.Registration required') }}
                    @endif
                </div>
        </div>
    </div>
</div>
</x-app-layout>
