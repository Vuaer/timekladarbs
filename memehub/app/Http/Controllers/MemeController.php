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
use App\Models\User_keyword;
use App\Models\Searched_meme;
use Illuminate\Support\Facades\File; 

class MemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(){
        $this->middleware('auth',['except'=>['index','show','search','download','sortByLikes', 'sortByTitle']]);
    }
    
    public function index($modified=0,$content=NULL)
    {
        if(Auth::check())
        {
            $liked_memes_ids=Like::where('user_id','=',Auth::user()->id)->pluck('meme_id')->toArray();
            $disliked_memes_ids=Dislike::where('user_id','=',Auth::user()->id)->pluck('meme_id')->toArray();
            if($modified==0){
                $memes=Meme::orderBy('id','DESC')->paginate(3);
                }
            else{
                $memes=$content;
                }
            return view('dashboard',compact('memes','liked_memes_ids','disliked_memes_ids'));
        }
        else
        {
           $liked_memes_ids=array();
           $disliked_memes_ids=array();
           if($modified==0){
                $memes=Meme::orderBy('id','DESC')->paginate(3);
           }
           else{
                $memes=$content;
           }
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
            'meme'=>'required',
            'title'=>'required | string | min:1'
        ]);
        $meme=$request->meme;
        $new_name=time().$meme->getClientOriginalName();
        $meme->move('memes',$new_name);
        $upload=new Meme;
        $upload->user_id=Auth::user()->id;
        $upload->meme='memes/'.$new_name;
        $upload->title=$request->title;
        $upload->save();
        $keywords=$request->except(['meme','title','_token']);
        foreach ($keywords as $value){
            if($value != NULL)
            {
                $keyword=new Keyword;
                $keyword->keyword=$value;
                $keyword->meme_id=$upload->id;
                $keyword->save();
            }
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
        if(Auth::check())
        {
            Like::where('user_id','=',Auth::user()->id)->where('meme_id','=',$id)->exists()?$isliked=1:$isliked=0;
            Dislike::where('user_id','=',Auth::user()->id)->where('meme_id','=',$id)->exists()?$isdisliked=1:$isdisliked=0;
            return view('show',compact('meme','isliked','isdisliked'));
        }
        else
        {
            return view('show',compact('meme'));
        }
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
        if (auth()->user()->can('delete',$meme))
        {

            foreach($meme->comments as $comment)
            {
                $comment->delete();
            }
            File::delete($meme->meme);
            $meme->delete();
        }
        return redirect()->route('meme.index');
    }
    
    public function search(Request $request)
    {
        $memes_ids=Keyword::where('keyword','like',$request->keyword)->pluck('meme_id')->toArray();
        $memes_ids2=Meme::where('title','like',$request->keyword)->pluck('id');
        $memes=Meme::whereIn('id',$memes_ids)->orWhereIn('id',$memes_ids2)->orderBy('id','DESC')->get();
        if(auth::check())
        {
            foreach ($memes as $meme)
            {
                $searched_meme=new Searched_meme;
                $searched_meme->user_id=Auth::user()->id;
                $searched_meme->meme_id=$meme->id;
                $searched_meme->save();
            }
        }
        $memes=Meme::whereIn('id',$memes_ids)->orWhereIn('id',$memes_ids2)->orderBy('id','DESC')->paginate(3);
        return $this->index(1,$memes);
//        if(Auth::check())
//        {
//            $liked_memes_ids=Like::where('user_id','=',Auth::user()->id)->pluck('meme_id')->toArray();
//            $disliked_memes_ids=Dislike::where('user_id','=',Auth::user()->id)->pluck('meme_id')->toArray();
//            return view('dashboard',compact('memes','liked_memes_ids','disliked_memes_ids'));
//        }
//        else
//        {
//           $liked_memes_ids=array();
//           $disliked_memes_ids=array();
//           return view('dashboard', compact('memes','liked_memes_ids','disliked_memes_ids')); 
//        }
    }
    
    public function download($id)
    {
        $meme=Meme::find($id);
        $title= substr($meme->meme, 6);
        $file= public_path()."/memes/".$title;
        return \Illuminate\Support\Facades\Response::download($file,$title);
    }
    
    public function personalize()
    {
        $user_keywords=User_keyword::where('user_id','=',Auth::user()->id)->pluck('keyword');
        $memes_ids=Keyword::select('meme_id')->whereIn('keyword',$user_keywords)->pluck('meme_id');
        $memes=Meme::whereIn('id',$memes_ids)->orderBy('id','DESC')->paginate(3);
        return $this->index(1,$memes);
    }
    
    public function sortByLikes()
    {
        $memes=Meme::orderBy('likes','DESC')->paginate(3);
        return $this->index(1,$memes);
    }
    
    public function sortByTitle()
    {
        $memes=Meme::orderBy('title')->paginate(3);
        return $this->index(1,$memes);
    }
    
    public function recentlySearched()
    {
        $memes=Searched_meme::where('user_id','=',Auth::user()->id)->latest()->take(3);
//        foreach($memes as $meme){
//            echo $meme->meme();
//        }
        $memes_ids=Searched_meme::where('user_id','=',Auth::user()->id)->latest()->take(3)->pluck('meme_id');
        $memes=Meme::whereIn('id',$memes_ids)->paginate(3);
        return $this->index(1,$memes);  
    }
}
