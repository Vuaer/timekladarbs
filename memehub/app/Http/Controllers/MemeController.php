<?php

namespace App\Http\Controllers;

use App\Models\Meme;
use App\Models\Comment;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Library_meme;
use App\Models\Library;


class MemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(){
        $this->middleware('auth',['except'=>['index','show']]);
    }
    
    public function index()
    {
        $memes=Meme::orderBy('id','DESC')->get();
        return view('dashboard', compact('memes'));
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

        $library = Library::where('user_id','=',Auth::user()->id)->get();
        $library_meme = new Library_meme;
        $library_meme->meme_id = $upload->id;
        $library_meme->library_id =  $library->first()->id;
        $library_meme->save();
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
        return view('show',compact('meme'));
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
        if (session()->has('like') && in_array($id, session()->get('like')))
        {
            
        }
        else 
        {
            if(session()->has('dislike') && in_array($id, session()->get('dislike')))
            {
                session()->forget('dislike');
            }
            $meme= Meme::findOrFail($id);
            $meme->likes++;
            $meme->save();
            $result=$meme->likes;
            session()->put('like',$id);
            return response()->json(['likes'=>$result,'isliked'=>0]);
        }
    }
        public function dislike(Request $request)
    {
        $id=$request->id;            
        if (session()->has('dislike') && in_array($id, session()->get('dislike')))
        {
            
        }
        else
        {
            if(session()->has('like') && in_array($id, session()->get('like')))
            {
                session()->forget('like');
            }
        $id=$request->id;
        $meme= Meme::findOrFail($id);
        $meme->dislikes++;
        $meme->save();
        $result=$meme->dislikes;
        return response()->json(['dislikes'=>$result,'isdisliked'=>0]);
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
        $library_meme = Library_meme::where('meme_id','=',$id)->get();
        $library_meme->first()->delete();

        $meme = Meme::findOrFail($id);
        foreach($meme->comments as $comment)
        {
            $comment->delete();
        }
        $meme->delete();
        return redirect()->route('meme.index');
    }
}
