<x-app-layout>
<x-slot name="header">
</x-slot>

<div>
    <h4>Username: {{$user->name}}</h4>
    <p>Current role: {{$user->role}}</p>
</div>
<div>
    <form method="Post" action="{{ action([App\Http\Controllers\ProfileController::class, 'changeRole'],$user->id)}}">
    @csrf

    <label for="role"> Choose a role: </label>
    
    <select name="role" id="role">
        <option value="user">User</option>
        <option value="moderator">Moderator</option>
        <option value="administrator">Administrator</option>
    </select>
    <input type="submit" class="btn">
    </form>
</div>
</x-app-layout>
