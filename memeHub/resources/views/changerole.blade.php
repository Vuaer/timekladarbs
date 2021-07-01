<x-app-layout>
<x-slot name="header">
</x-slot>

<div>
    <h4>{{ __('role.Username') }}: {{$user->name}}</h4>
    <p>{{ __('role.Current role') }}: {{$user->role}}</p>
</div>
<div>
    <form method="Post" action="{{ action([App\Http\Controllers\ProfileController::class, 'changeRole'],$user->id)}}">
    @csrf

    <label for="role"> {{ __('role.Choose a role') }}: </label>
    
    <select name="role" id="role">
        <option value="user">{{ __('role.User') }}</option>
        <option value="moderator">{{ __('role.Moderator') }}</option>
        <option value="administrator">{{ __('role.Administrator') }}</option>
    </select>
    <input type="submit" class="btn">
    </form>
</div>
</x-app-layout>
