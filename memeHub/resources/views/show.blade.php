<x-app-layout>
<x-slot name="header">
</x-slot>
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-10'>
            <div class="card">
               
                <div class='card-body'>
                    <div class='container mt-2'>
                        <div class='row justify-content-center'>
                        <div class='col-md-8'>       
                            <div class='card m-3 bg-dark'>
                                <img src='{{ asset($meme->meme)}}' class="card-img-top pb-5 " alt='something' >
                            </div>
                        @if(Auth::check())
                        @if($meme->user_id==Auth::user()->id || Auth::user()->isModer())
                        <div class="row justify-content-end">
                            <form action='/meme/{{$meme->id}}' method="POST">
                                @method('DELETE')
                                @csrf
                                <input type="submit" value="Delete" class="btn btn-danger">
                            </form>       
                        </div>
                        @endif
                        @endif 
                        <div >
                            <h5>Add comment:</h5>
                            <form method="POST" action="{{ action([App\Http\Controllers\CommentController::class, 'store']) }}">
                                @csrf
                                @if (count($errors) > 0)
                                @endif
                                <div class="form-group">
                                    <input type="hidden" name="meme_id" value="{{ $meme->id }}">
                                    <input type="text" class="form-control @error('comment_text') is-invalid @enderror" name="comment_text" id="comment_text">
                                    @error('comment_text')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-warning" value="Add Comment">
                                </div>

                            </form>
                            @foreach($meme->comments as $comment)
                            <div >
                                <strong>{{ $comment->user->name }}</strong>
                                <p>{{ $comment->comment_text }}</p>
                            </div>
                            @endforeach
                        </div>
                        </div>
                        </div>   
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
