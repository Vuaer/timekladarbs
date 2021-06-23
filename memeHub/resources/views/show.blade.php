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
                            <div class='card m-3'>
                                <img src='{{ asset($meme->meme)}}' class="card-img-top pb-5 " alt='something' >
                                <div class='col-4'>
                                     <div class="row">
                                     @if(Auth::check())
                                     @if($isliked)
                                     <button class="btn disabled" onclick="a({{$meme->id}}, true)" id="btn-like_{{$meme->id}}"><i class="fa fa-thumbs-up"></i></button>
                                     @else
                                     <button class="btn" onclick="a({{$meme->id}}, true)" id="btn-like_{{$meme->id}}"><i class="fa fa-thumbs-up"></i></button>
                                     @endif
                                     @if($isdisliked)
                                     <button class="btn disabled" id="btn-dislike_{{$meme->id}}" onclick="a({{$meme->id}}, false)"><i class="fa fa-thumbs-down"></i></button>
                                     @else
                                     <button class="btn" onclick="a({{$meme->id}}, false)" id="btn-dislike_{{$meme->id}}"><i class="fa fa-thumbs-down"></i></button>
                                     @endif
                                     @else
                                     <a class="btn" href="{{ route('login') }}"><i class="fa fa-thumbs-up"></i></a>
                                     <a class="btn" href="{{ route('login') }}"><i class="fa fa-thumbs-down"></i></a>
                                     @endif
                                     </div>
                                     <div class="row">
                                         <div class="col-2" id="likes_{{$meme->id}}">{{$meme->likes}}</div>
                                         <div class="col-2" id="dislikes_{{$meme->id}}"> {{$meme->dislikes}}</div> 
                                     </div>
                                 </div>
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
    <script>
function a(meme_id, like)
{
    console.log(meme_id);
    var url = like ? "{{ route('meme.like') }}" : "{{ route('meme.dislike') }}";

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: url,
        data: { id: meme_id, _token: CSRF_TOKEN },
        success: function (result) {
            if(like && result['isliked']==0 || !like && result['isdisliked']==0){
                $("#likes_"+meme_id).text(result['likes']);
                $("#dislikes_"+meme_id).text(result['dislikes']);
                if(like){
                    $('#btn-like_'+meme_id).addClass("btn disabled");
                    $("#btn-dislike_"+meme_id).removeClass('disabled');
                }
                else{
                    $("#btn-dislike_"+meme_id).addClass('btn disabled');
                    $('#btn-like_'+meme_id).removeClass("disabled");
                }
                console.log(like);
            }
            else
            {
                if(like){
                    $("#btn-like_"+meme_id).removeClass('disabled');
                }
                else $("#btn-dislike_"+meme_id).removeClass('disabled');
                $("#likes_"+meme_id).text(result['likes']);
                $("#dislikes_"+meme_id).text(result['dislikes']);
            }
        },
        error: function (data) {
            console.log('Error:',data);
        }
    });
}      
    </script>
</x-app-layout>
