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
                        findtemplate($id);
                        ?>
                     <form action='{{ route('meme.create') }}' method="POST" >
                           @csrf
                           <label for="imgn"> image name </label>
                           <input type="text" name="imgname" id="imgn" placeholder="your text">
                           <label for="text1"> First text </label>
                           <input type="text" name="textinput1" id="text1" placeholder="your text">
                           <label for="text2"> Second text </label>
                           <input type="text" name="textinput2" id="text2" placeholder="your text">
                           <input type="hidden" name="img" id="imgid" value="<?= $id ?>">
                           <input type="submit" name="my_form_submit_button" >

                       </form>
                       
                           <?php    
                        
                        echo '<p>';
                        postresult($id,"first text","second text","location1","location2");
                        echo '</p>';                        
                        ?>


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
function postresult($id,$text1,$text2,$location1,$location2)
{
   
                        // (A) OPEN IMAGE
                        $imgPath = 'memes/templates/'.$id.'';
                       
                        global $img;
                        $img = imagecreatefromjpeg($imgPath);
                        
                        // (B) WRITE TEXT
                        $white = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
                        $font = "C:\Windows\Fonts\arial.ttf"; 
                        imagettftext($img, 24, 0, 5, 24, $white, $font, $text1);
                        imagettftext($img, 24, 0, 5, 224, $white, $font, $text2);

                       
                        // (C) OUTPUT IMAGE
                     header('Content-Type: image/jpeg');
                     
                        // THE LAST PARAMETER IS THE QUALITY FROM 0 to 100
                        $time = time();
                        $templatedonelink = "memes/templatesDone/$time.jpg";
                        
                        //imagejpeg($img, $templatedonelink, 100);
                        //imagejpeg($img);
                        //echo ($img);
                        imagedestroy($img);
                        return $templatedonelink;
}
?>
