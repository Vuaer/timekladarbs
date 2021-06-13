
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-10'>
            <div class="card">
                <div class="card-header">
                    <h4>Upload meme</h4>
                    @if(Auth::check())
                    <form action='/meme' enctype="multipart/form-data" method="POST" class='form-inline'>
                        @csrf
                        <div class='form-group'>
                            <input type='file' name='meme' class="form-control-image">
                        </div>
                        <input type='submit' value="Upload" class="btn btn-primary">
                    </form>
                    @endif
                    @if(Auth::guest())
                    Meme list
                    @endif
                </div>
                <div class='card-body'>
                    <div class='container mt-2'>
                        <div class='row justify-content-center'>
                        <div class='col-md-6'>
                        @forelse($memes as $meme)
                            <div class='card m-3'>
                                <img src='{{ asset($meme->meme)}}' class="card-img-top" alt='something'>
                            </div>
                        @empty
                            <p>No memes!</p>
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
