
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
