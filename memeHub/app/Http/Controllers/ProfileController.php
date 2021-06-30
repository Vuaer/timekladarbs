<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\App;
use App\Models\User_keyword;
use App\Models\Keyword;
use Illuminate\Validation\Rule;
Use \Carbon\Carbon;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth',['except'=>['changeLocale']]);
    }
    public function index(Request $request)
    {
        $keywords=User_keyword::where('user_id','=',Auth::user()->id)->pluck('keyword')->toArray();
        $meme_keywords=Keyword::select('keyword')->distinct()->pluck('keyword')->sortBy('keyword');
        $meme_keywords;
        if(Gate::allows('is-moder'))
        {
            if($request->has('name') & $request->name != NULL)
            {
                $users = User::Where('name','LIKE','%'.$request->name.'%')->orderBy("name","asc")->get();
                $moderators = User::where('role','=','moderator')->get();
                $administrators = User::where('role','=','administrator')->get();
                return view('profile',compact('moderators','administrators','users','keywords','meme_keywords'));
            }
            else
            {
                $moderators = User::where('role','=','moderator')->get();
                $administrators = User::where('role','=','administrator')->get();
                return view('profile',compact('moderators','administrators','keywords','meme_keywords'));
            }
        }
        else
        {
        return view('profile', compact('keywords','meme_keywords'));
        }
    }

    public function findUser($id)
    {
        if(Gate::allows('is-admin'))
        {
            $user = User::findOrFail($id);
            return view('changerole',compact('user'));
        }
    }
    public function changeRole(Request $request,$id)
    {
        if(Gate::allows('is-admin'))
        {
            $user = User::findOrFail($id);
            $user->role = $request->role;
            $user->save();
        }
        return redirect('profile');
    }
    public function showBanUser($id)
    {
        if(Gate::allows('is-moder'))
        {
            $user = User::findOrFail($id);
            return view('ban',compact('user'));
        }
    }

    public function ban(Request $request,$id)
    {
        $rules = array
                (
                    'days' => 'required | integer | min:1 | max:50000',
                );
        $this->validate($request,$rules);

        $user = $user = User::findOrFail($id);
        $currentDate = Carbon::now();
        $currentDate = $currentDate->addDays($request->days);
        $user->banned_until = $currentDate;
        $user->save();
        return redirect('profile');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function changeLocale($locale)
    {
       session(['locale'=>$locale]);
       App::setLocale($locale);
       return redirect()->back();
    }
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
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30 | min:1',
            'email' => 'required|string|email|max:30'
        ]);

        $user=User::find(Auth::user()->id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->update();
        $keywords=$request->except(['name','email','_method','_token']);
        foreach ($keywords as $keyword){
            if(!User_keyword::where('user_id','=',Auth::user()->id)->where('keyword','=',$keyword)->exists()){
                $user_keyword=new User_keyword;
                $user_keyword->user_id=Auth::user()->id;
                $user_keyword->keyword=$keyword;
                $user_keyword->save();
                }
        }
        return redirect()->route('profile.index');
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
    
    public function deleteKeyword($keyword)
    {
        User_keyword::where('keyword','=',$keyword)->where('user_id','=',Auth::user()->id)->delete();
        return redirect()->route('profile.index');
    }
    

}
