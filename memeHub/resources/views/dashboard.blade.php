
<x-app-layout>
<x-slot name="header">
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
