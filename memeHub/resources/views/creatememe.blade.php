
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        create meme
    </h2>
</x-slot>
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-10'>
            <div class="card">
                   
                      <?php    
                        
                        echo '<p>';
                        echo ''. $id .'';
                        echo '</p>';                        
                        ?>
                     <form action="foobar_submit.php" method="get">
                           <input type="text" name="subject" id="subject" value="your text">
                           <input type="submit" name="my_form_submit_button" 
                                  value="add you text"/>

                       </form>
                       <?php    
                        
                        echo '<p>';
                        postresult($id);
                        echo '</p>';                        
                        ?>
                    @if(Auth::check())
                        @csrf
                        <button>
                            
<!--                        <button  action='/meme'  type='file' name='meme' class="form-control-image" value="{$img}" >
                           press me
                        <button/>-->

                    @endif                        
                    
            </div>
        </div>
    </div>
</div>
</x-app-layout>
<?php

function findtemplate($id) {
$files = glob("memes/templates/*.*");

for ($i = 0; $i < count($files); $i++) {
    
    global $image;
    $image= $files[$i];
    //echo basename($image) . "<br />"; // show only image name if you want to show full path then use this code // echo $image."<br />";
    if(basename($image)==$id)
    {

    echo '<img src="../' . $image . '" class="rounded float-left"  alt="found'.$id.'==' . $image . '" />';
   

    }
}
 echo '</div>';
 echo '<br />';
  
}              
function postresult($id)
{
    findtemplate($id);
                        // (A) OPEN IMAGE
                        $imgPath = 'memes/templates/'.$id.'';
                       
                        global $img;
                        $img = imagecreatefromjpeg($imgPath);

                        // (B) WRITE TEXT
                        $white = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
                        $txt = "in funcion";
                        $font = "C:\Windows\Fonts\arial.ttf"; 
                        imagettftext($img, 24, 0, 5, 24, $white, $font, $txt);

                        // (C) OUTPUT IMAGE
                     header('Content-Type: image/jpeg');
                     
//                         imagedestroy($img);
//
//                        // OR SAVE TO A FILE
                        // THE LAST PARAMETER IS THE QUALITY FROM 0 to 100
                        imagejpeg($img, "18_06.jpg", 100); 
}
?>