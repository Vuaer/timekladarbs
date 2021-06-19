
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
                   
            </div>
        </div>
    </div>
</div>
</x-app-layout>
<?php

function findtemplate($id) {
$files = glob("memes/templates/*.*");

for ($i = 0; $i < count($files); $i++) {
    $image = $files[$i];
    //echo basename($image) . "<br />"; // show only image name if you want to show full path then use this code // echo $image."<br />";
    if(basename($image)==$id)
    {

    echo '<img src="../' . $image . '" class="rounded float-left"  alt="found'.$id.'==' . $image . '" />';
   

    }
}
 echo '</div>';
 echo '<br />';
  
}                                          
?>