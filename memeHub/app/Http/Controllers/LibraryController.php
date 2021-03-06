<?php

namespace App\Http\Controllers;
use App\Models\Meme;
use App\Models\Library_meme;
use App\Models\Library;
use Illuminate\Http\Request;
use Auth;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        $Library = Library::where('user_id',Auth::user()->id)->first();
        $memes = Library_meme::where('library_id',$Library->id)->get(); 
        return view('library', compact('memes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $meme = new Library_meme;
        $meme->meme_id = $request->meme_id;
        $library = Library::where('user_id',Auth::user()->id)->first();
        $meme->library_id = $library->id;
        $meme->save();

        return response()->json(['meme_id'=>$meme->id]);
    }
    public function remove(Request $request)
    {
        $meme = Library_meme::where('meme_id',$request->meme_id)->first();
        $meme->delete();
        return response()->json(['meme_id'=>$meme->meme_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showmymemes()
    {
        $memes=Meme::orderBy('id','DESC')->get();
        return view('mymemes', compact('memes'));
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
        $meme = Library_meme::findOrFail($id);
        $meme->delete();
        return redirect('library');
    }
}
