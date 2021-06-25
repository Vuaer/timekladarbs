<?php

namespace App\Http\Controllers;
use App\Models\Template;
use Illuminate\Http\Request;
use App\Models\Meme;
use Auth;

class CreateController extends Controller
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
        return view('create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('creatememe',["id"=>$id]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
       $template = Template::findOrFail(1);
       $id = $request->img;
       $txt1= $request->textinput1;
       $txt2= $request->textinput2;
       $name = $request->imgname;
     //  function postresult($id,$text1,$text2,$location1,$location2)
    // (A) OPEN IMAGE
        $imgPath = 'memes/templates/'.$id.'';
        
        $x1= $template->positionx1;
        $x2= $template->positionx2;
        $y1= $template->positiony1;
        $y2= $template->positiony2;
       // return $x2;
        $img = imagecreatefromjpeg($imgPath);
        $white = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
        $font = "C:\Windows\Fonts\arial.ttf"; 
        imagettftext($img, 32, 0, $x1, $y1, $white, $font, $txt1);
        imagettftext($img, 32, 0, $x2, $y2, $white, $font, $txt2);
                        $finalname = time().$name;
                        $templatedonelink = "memes/$finalname.jpg";                       
                        imagejpeg($img, $templatedonelink, 100);
                        imagedestroy($img);
        $upload=new Meme;
        $upload->user_id=Auth::user()->id;
        $upload->meme=$templatedonelink;
        $upload->save();
//        $keywords=$request->except('meme');
//        foreach ($keywords as $value){
//            $keyword=new Keyword;
//            $keyword->keyword=$value;
//            $keyword->meme_id=$upload->id;
//            $keyword->save();
//        }
        return redirect()->route('meme.index'); 
       
       //return view('create');  
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
