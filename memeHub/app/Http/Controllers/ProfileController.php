<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if(Gate::allows('is-moder'))
        {
            if($request->has('name') & $request->name != NULL)
            {
                $users = User::Where('name','LIKE','%'.$request->name.'%')->orderBy("name","asc")->get();
                $moderators = User::where('role','=','moderator')->get();
                $administrators = User::where('role','=','administrator')->get();
                return view('profile',compact('moderators','administrators','users'));
            }
            else
            {
                $moderators = User::where('role','=','moderator')->get();
                $administrators = User::where('role','=','administrator')->get();
                return view('profile',compact('moderators','administrators'));
            }
        }
        else
        {
        return view('profile');
        }
    }

    public function findUser($id)
    {
        $user = User::findOrFail($id);
        return view('changerole',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
