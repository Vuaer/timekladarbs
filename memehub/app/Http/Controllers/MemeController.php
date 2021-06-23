<?php

namespace App\Http\Controllers;


use App\Models\Meme;

use App\Models\Comment;
use App\Models\Keyword;
use App\Models\Like;
use App\Models\Dislike;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Library_meme;
use App\Models\Library;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class MemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(){
        $this->middleware('auth',['except'=>['index','show','search']]);
    }
    
    public function index()
    {
        $memes=Meme::orderBy('id','DESC')->get();
        if(Auth::check())
        {
            $liked_memes_ids=Like::where('user_id','=',Auth::user()->id)->pluck('meme_id')->toArray();
            $disliked_memes_ids=Dislike::where('user_id','=',Auth::user()->id)->pluck('meme_id')->toArray();
            return view('dashboard',compact('memes','liked_memes_ids','disliked_memes_ids'));
        }
        else
        {
           $liked_memes_ids=array();
           $disliked_memes_ids=array();
           return view('dashboard', compact('memes','liked_memes_ids','disliked_memes_ids')); 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function upload(Request $request)
    {
        $this->validate($request,[
            'meme'=>'required'
        ]);
        $meme=$request->meme;
        $new_name=time().$meme->getClientOriginalName();
        $meme->move('memes',$new_name);
        $upload=new Meme;
        $upload->user_id=Auth::user()->id;
        $upload->meme='memes/'.$new_name;
        $upload->save();
        $keywords=$request->except('meme');
        foreach ($keywords as $value){
            $keyword=new Keyword;
            $keyword->keyword=$value;
            $keyword->meme_id=$upload->id;
            $keyword->save();
        }
        return redirect()->route('meme.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $meme = Meme::findOrFail($id);
        Like::where('user_id','=',Auth::user()->id)->where('meme_id','=',$id)->exists()?$isliked=1:$isliked=0;
        Dislike::where('user_id','=',Auth::user()->id)->where('meme_id','=',$id)->exists()?$isdisliked=1:$isdisliked=0;
        return view('show',compact('meme','isliked','isdisliked'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    public function like(Request $request)
    {
        $id=$request->id;
        $meme= Meme::findOrFail($id);
        if (Like::where('user_id','=',Auth::user()->id)->where('meme_id','=',$id)->exists())
        {
          $meme->likes--;
          $meme->save();
          Like::where('user_id','=',Auth::user()->id)->where('meme_id','=',$id)->delete();
          return response()->json(['likes'=>$meme->likes,'isliked'=>1]);  
        }
        else 
        {
            if(Dislike::where('user_id','=',Auth::user()->id)->where('meme_id','=',$id)->exists())
            {
                $meme->dislikes--;
                Dislike::where('user_id','=',Auth::user()->id)->where('meme_id','=',$id)->delete();
            }
            $meme->likes++;
            $meme->save();
            $likes=$meme->likes;
            $like=new Like;
            $like->user_id=Auth::user()->id;
            $like->meme_id=$meme->id;
            $like->save();
            return response()->json(['likes'=>$likes,'dislikes'=>$meme->dislikes,'isliked'=>0]);
        }
    }
        public function dislike(Request $request)
    {
        $id=$request->id;
        $meme= Meme::findOrFail($id);
        if (Dislike::where('user_id','=',Auth::user()->id)->where('meme_id','=',$id)->exists())
        {
           Dislike::where('user_id','=',Auth::user()->id)->where('meme_id','=',$id)->delete();
           $meme->dislikes--;
           $meme->save();
           
           return response()->json(['dislikes'=>$meme->dislikes,'isdisliked'=>1]); 
        }
        else
        {
        if(Like::where('user_id','=',Auth::user()->id)->where('meme_id','=',$id)->exists())
        {
            Like::where('user_id','=',Auth::user()->id)->where('meme_id','=',$id)->delete();
            $meme->likes--;
        }
        $meme->dislikes++;
        $meme->save();
        $dislikes=$meme->dislikes;
        $dislike=new Dislike;
        $dislike->user_id=Auth::user()->id;
        $dislike->meme_id=$meme->id;
        $dislike->save();
        return response()->json(['dislikes'=>$dislikes,'likes'=>$meme->likes,'isdisliked'=>0]);
        }
    }
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $meme = Meme::findOrFail($id);
        if (Gate::allows('is-moder') || Auth::user()->id == $meme->user_id)
        {

            foreach($meme->comments as $comment)
            {
                $comment->delete();
            }
            $meme->delete();
        }
        return redirect()->route('meme.index');
    }
    
    public function search(Request $request)
    {
        $memes_ids=Keyword::where('keyword','like','%'.$request->keyword.'%')->pluck('meme_id')->toArray();
        $memes=DB::table('memes')->whereIn('id',$memes_ids)->get();
        if(Auth::check())
        {
            $liked_memes_ids=Like::where('user_id','=',Auth::user()->id)->pluck('meme_id')->toArray();
            $disliked_memes_ids=Dislike::where('user_id','=',Auth::user()->id)->pluck('meme_id')->toArray();
            return view('dashboard',compact('memes','liked_memes_ids','disliked_memes_ids'));
        }
        else
        {
           $liked_memes_ids=array();
           $disliked_memes_ids=array();
           return view('dashboard', compact('memes','liked_memes_ids','disliked_memes_ids')); 
        }
    }
}
