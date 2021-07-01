
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('upload.Upload meme') }}
    </h2>
</x-slot>
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-10'> 
            <div class="card">
                <div class="card-header">
                    @if(Auth::check())
                    <h4>{{ __('dashboard.Upload meme') }}</h4>                
                    <form action='/meme' enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class='form-group'>
                            <input type='file' name='meme' class="form-control-image @error('meme') is-invalid @enderror mb-3">
                            @error('meme')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="title">{{ __('dashboard.Meme title') }}:</label>
                            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror input-sm" placeholder="{{ __('dashboard.Enter title') }}">
                            @error('title')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class='form-group col-4'>
                            <div id="toAppend">
                                <label for="keyword">{{ __('dashboard.Meme keywords') }}:</label>
                                <input type='text' id="keyword" name='keyword' placeholder="{{ __('dashboard.Enter keyword') }}" class="form-control input-sm mb-3 mr-2">
                            </div>
                            <button type="button" class="btn btn-light" id="btn-add" onclick="newform()"><i class="fa fa-plus"></i></button>
                        </div>
                        <input type='submit' value="{{ __('dashboard.Upload') }}" class="btn btn-primary">
                    </form>
                    @endif
                    @if(Auth::guest())
                    {{ __('dashboard.Meme list') }}
                    @endif
                </div>
                </div>
        </div>
    </div>
</div>
<script>
var number=0;
function newform(){
    $("#keyword").clone().attr("name","keyword"+number).appendTo("#toAppend");
    console.log("keyword"+number);
    number++;
    //var copy=$("#keyword");
}
</script>
</x-app-layout>
