
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
                        <div class='col-md-8'>
                        @forelse($memes as $meme)
                            <div class='card m-3 border border-primary'>
                                <img src='{{ asset($meme->meme)}}' class="card-img-top" alt='something'>
                                <div class='row align-items-center'>
                                    <div class='col-8'>
                                        <form>
                                            <textarea rows="2"class='form-control' name='comment' id='comment' placeholder="leave a comment"></textarea>
                                        </form>
                                    </div>
                                    <div class='col-4 d-inline-flex'>
                                        <button class="btn" id="btn-like" memes-id="{{$meme->id}}"><i class="fa fa-thumbs-up"></i></button>
                                        <button class="btn" id="btn-dislike" memes-id="{{$meme->id}}"><i class="fa fa-thumbs-down"></i></button>
                                            <p id="likes">{{$meme->likes}}</p>
                                            <p>space</p>
                                            <p id="dislikes"> {{$meme->dislikes}}</p>                                          
                                    </div>
                                </div>
                                <div class="card-">
                                </div>
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
    <script>
$(document).ready(function () {
    $("#btn-like").on('click', function (e) {
        var url = "{{ route('meme.like') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: url,
            data: { id: $("#btn-like").attr('memes-id'), _token: CSRF_TOKEN },
            success: function (result) {
                $("#likes").text(result);
                //console.log(likes);
            },
            error: function (data) {
                console.log('Error:',data);
            }
        });
    })
    $("#btn-dislike").on('click', function (e) {
        var url = "{{ route('meme.dislike') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: url,
            data: { id: $("#btn-dislike").attr('memes-id'), _token: CSRF_TOKEN },
            success: function (result) {
                $("#dislikes").text(result);
            },
            error: function (data) {
                console.log('Error:',data);
            }
        });
    })  
});        
    </script> 
</x-app-layout>
