<x-app-layout>
<x-slot name="header">
</x-slot>

<div>
    <h4>Username: {{$user->name}}</h4>
    <p>Current role: {{$user->role}}</p>
</div>

<div>
    <form method="Post" action="{{ action([App\Http\Controllers\ProfileController::class, 'ban'],$user->id)}}">
    @csrf
    <p>Ban user for <input style="width:200px;" id="days" type="text" name="days" > days</p>
    @if (count($errors) > 0)
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
             @endif
    <input type="submit" class="btn" value="Ban" >
    </form>
</div>
</x-app-layout>
