<x-app-layout>
<x-slot name="header">
</x-slot>

<div>
    <h4>{{ __('role.Username') }}: {{$user->name}}</h4>
    <p>{{ __('role.Current role') }}:  {{$user->role}}</p>
</div>

<div>
    <form method="Post" action="{{ action([App\Http\Controllers\ProfileController::class, 'ban'],$user->id)}}">
    @csrf
    <p>{{ __('role.Ban user for') }} <input style="width:200px;" id="days" type="text" name="days" > {{ __('role.days') }}</p>
    @if (count($errors) > 0)
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
             @endif
    <input type="submit" class="btn" value="{{ __('role.Ban') }}" >
    </form>
</div>
</x-app-layout>
