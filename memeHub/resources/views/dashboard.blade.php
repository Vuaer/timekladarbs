
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('dashboard.Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <a href="{{route('sort.likes')}}" style="color:black">{{ __('dashboard.Sort by likes') }}</a>
        <a href="{{route('sort.title')}}" class='ml-5' style="color:black">{{ __('dashboard.Sort by title') }}</a>
    </div>
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
                                    <div class='col-4'>
                                        <div class="row">
                                        @if(Auth::check())
                                        @if(in_array($meme->id,$liked_memes_ids))
                                        <button class="btn disabled" onclick="a({{$meme->id}}, true)" id="btn-like_{{$meme->id}}"><i class="fa fa-thumbs-up"></i></button>
                                        @else
                                        <button class="btn" onclick="a({{$meme->id}}, true)" id="btn-like_{{$meme->id}}"><i class="fa fa-thumbs-up"></i></button>
                                        @endif
                                        @if(in_array($meme->id,$disliked_memes_ids))
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
                        @endforeach
                        </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        {{$memes->links("pagination::bootstrap-4")}}
                    </div>
                </div>
            </div>
        </div>
        @if(Auth::check())
        <div class="col-2">
            <div class="row justify-content-center mt-5">
                <a href="{{route('personalize')}}" class="text-success">{{ __('dashboard.Memes for you') }}</a>
            </div>
            <div class="row justify-content-center mt-3 ml-2">
                <a href="{{route('adapt')}}" class="text-success">{{ __('dashboard.Recently searched') }}</a>
            </div>
        </div>
        @endif
    </div>
</div>
    <script>
function library_add(meme_id)
{
    console.log(meme_id);
    var url = "{{ route('library.store') }}";
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax
    ({
        type: "Post",
        url:url,
        data: {meme_id: meme_id, _token: CSRF_TOKEN },
        success: function (result)
                {
                    $("#btn-add_"+meme_id).addClass("d-none disabled");
                    $('#btn-remove_'+meme_id).removeClass('d-none disabled');
                },
                
        error: function (data)
        {
            console.log('Error:',data);
        }
    });
}
function library_remove(meme_id)
{
    console.log(meme_id);
    var url = "{{ route('library.remove') }}";
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax
    ({
        type: "Post",
        url:url,
        data: {meme_id: meme_id, _token: CSRF_TOKEN },
        success: function (result)
                {
                    $("#btn-add_"+meme_id).removeClass("d-none disabled");
                    $('#btn-remove_'+meme_id).addClass('d-none disabled');
                },
                
        error: function (data)
        {
            console.log('Error:',data);
        }
    });
}
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
var number=0;
function newform(){
    $("#keyword").clone().attr("name","keyword"+number).appendTo("#toAppend");
    console.log("keyword"+number);
    number++;
    //var copy=$("#keyword");
}
    </script>
</x-app-layout>
