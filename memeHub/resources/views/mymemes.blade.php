
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        My memes
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
                        @foreach($memes as $meme)
                        @if(Auth::check())
                            @if($meme->user_id==Auth::user()->id)
                            <div class='card m-3 border border-primary'>
                                <div class="row justify-content-center mt-2 ">
                                    <p class="lead">{{$meme->title}}</p>
                                </div>
                                @if((Auth::check() and Auth::user()->role != 'moderator' and Auth::user()->role != 'administrator') or (!Auth::check()))
                                <div class="row justify-content-end mr-3">{{ __('dashboard.User') }}:{{$meme->user->name}}</div>
                                @endif
                                @can('is-moder')
                                <x-dropdown align="right" width="48">
                                     <x-slot name="trigger">
                                        <div class="row justify-content-end mr-3"><button class="flex-item pl-6 width-30">{{ __('dashboard.User') }}:{{$meme->user->name}}</button></div>
                                     </x-slot>
                             
                                     <x-slot name="content" >
                                            @can('is-admin')
                                            <form method="GET" action="{{ action([App\Http\Controllers\ProfileController::class, 'findUser'], $meme->user->id) }}">
                                            @csrf
                                            <p>
                                            <input type="submit" value="Change role">
                                            </p>
                                            </form>
                                            @endcan
                                           <form method="GET" action="{{ action([App\Http\Controllers\ProfileController::class, 'showBanUser'], $meme->user->id) }}">
                                                @csrf
                                                <p>
                                                <input type="submit" value="Block">
                                                </p>
                                           </form>
                                      </x-slot>
                                </x-dropdown>
                                @endcan
                                <a href="/meme/{{$meme->id}}" target="_blank">
                                <img src='{{ asset($meme->meme)}}' class="card-img-top" alt='something'>
                                <div class='row align-items-center'>
                                    <div class='col-8'>
                                            <h6 class="btn btn-warning">{{ __('dashboard.Add comment') }}</h6>
                                    </div>
                                    </a>
                                    @if(Auth::check() and Auth::user()->id != $meme->user_id)
                                        @if(!Auth::user()->library->library_memes($meme->id))
                                        <div class="col-2">                                         
                                            <button id="btn-add_{{$meme->id}}" title="Add to library" class="btn btn-secondary" onclick="library_add({{$meme->id}})"><i class="fa fa-plus"></i></button>
                                            <button id="btn-remove_{{$meme->id}}" title="Remove from library" class="btn btn-danger d-none" onclick="library_remove({{$meme->id}})"><i class="fa fa-minus"></i></button>
                                        </div>
                                        @else
                                        <div class="col-2">
                                            <button id="btn-add_{{$meme->id}}" title="Add to library" class="btn btn-secondary d-none" onclick="library_add({{$meme->id}})"><i class="fa fa-plus"></i></button>
                                            <button id="btn-remove_{{$meme->id}}" title="Remove from library" class="btn btn-danger" onclick="library_remove({{$meme->id}})"><i class="fa fa-minus"></i></button>
                                        </div>
                                        @endif
                                    @endif
                                      
                                    <div class ="col-1">
                                        <a href="/meme/download/{{$meme->id}}"><i class="fa fa-download"></i></a>
                                    </div>
                                </div>
                                   
                                
                            </div>

                        @if(Auth::check())
                        @if($meme->user_id==Auth::user()->id || Auth::user()->isModer())
                        <div class="row justify-content-end">
                            <form action='/meme/{{$meme->id}}' method="POST">
                                @method('DELETE')
                                @csrf
                                <input type="submit" value="{{ __('dashboard.Delete') }}" class="btn btn-danger">
                            </form>
                        </div>
                        @endif
                        @endif
                        @endif
                        @endif
                        @endforeach
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
