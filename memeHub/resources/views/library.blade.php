
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
                            <!--<div class='card m-3 border border-primary'>-->
                                <div class="row justify-content-center mt-2 ">
                                    <p class="lead">{{$lib_meme->meme->title}}</p>
                                </div>
                                @if(Auth::user()->role != 'moderator' and Auth::user()->role != 'administrator')
                                <div class="row justify-content-end mr-3">{{ __('dashboard.User') }}:{{$lib_meme->meme->user->name}}</div>
                                @endif
                                @can('is-moder')
                                <x-dropdown align="right" width="48">
                                     <x-slot name="trigger">
                                        <div class="row justify-content-end mr-3"><button class="flex-item pl-6 width-30">{{ __('dashboard.User') }}:{{$lib_meme->meme->user->name}}</button></div>
                                     </x-slot>
                             
                                     <x-slot name="content" >
                                            @can('is-admin')
                                            <form method="GET" action="{{ action([App\Http\Controllers\ProfileController::class, 'findUser'], $lib_meme->meme->user->id) }}">
                                            @csrf
                                            <p>
                                            <input type="submit" value="Change role">
                                            </p>
                                            </form>
                                            @endcan
                                           <form method="GET" action="{{ action([App\Http\Controllers\ProfileController::class, 'showBanUser'], $lib_meme->meme->user->id) }}">
                                                @csrf
                                                <p>
                                                <input type="submit" value="Block">
                                                </p>
                                           </form>
                                      </x-slot>
                                </x-dropdown>
                                @endcan
                                @if(Auth::check())                     
                                <a href="/meme/{{$lib_meme->meme->id}}" target="_blank">
                                    <div class='card m-3 bg-dark'>
                                        <img src='{{ asset($lib_meme->meme->meme)}}' class="card-img-top" alt='something' >
                                    </div>
                                <div class='col-8'>
                                            <h6 class="btn btn-warning">{{ __('dashboard.Add comment') }}</h6>
                                            <form action='/profile/library/{{$lib_meme->id}}' method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <input type="submit" value="{{ __('showmeme.Delete from library') }}" class="btn btn-danger">
                                    </form>
                                </div>
                                    <div class ="col-1">
                                        <a href="/meme/download/{{$lib_meme->meme->id}}"><i class="fa fa-download"></i></a>
                                    </div>

                                @endif
                                @empty
                                    <p>{{ __('showmeme.No memes') }}!</p>
                            </div>
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
