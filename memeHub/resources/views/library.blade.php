
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Library
    </h2>
</x-slot>
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-10'>
            <div class="card">
                <p>my library</p>
                   
                    @if(Auth::guest())
                    Meme list
                    @endif
                <div class='card-body'>
                    <div class='container mt-2'>
                        <div class='row justify-content-center'>
                        <div class='col-md-8'>
                        @forelse($memes as $meme)
                            <div class='card m-3 bg-dark'>
                                <img src='{{ asset($meme->meme)}}' class="card-img-top pb-5 " alt='something'>
                            </div>
                        @if(Auth::check())
                        @if($meme->user_id==Auth::user()->id)
                        <div class="row justify-content-end">
                            <form action='/meme/{{$meme->id}}' method="POST">
                                @method('DELETE')
                                @csrf
                                <input type="submit" value="Delete" class="btn btn-danger">
                            </form>
                            
                        </div>
                        
                        @endif
                        @endif
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
