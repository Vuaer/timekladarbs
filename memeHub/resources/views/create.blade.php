
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create meme
    </h2>
</x-slot>
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-10'>
            <div class="card">
                <ul class="thumbnails" style="width: 920px; margin: 0 auto;">
                            <?php    
                            @pastetemplates();
                            ?>

                </ul>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
<?php

function pastetemplates() {
$files = glob("memes/templates/*.*");

for ($i = 0; $i < count($files); $i++) {
    $image = $files[$i];
    //echo basename($image) . "<br />"; // show only image name if you want to show full path then use this code // echo $image."<br />";
    echo '<li>';
    echo '<a href="/create/'.basename($image).' " title="' . $i .'">';
    echo '<img src="' . $image . '" class="rounded float-left" style= "width: 25%; height: 25%" alt="image gen" />';
    echo '</a>';
    echo '</li>';
}
 echo '</div>';
 echo '<br />';
}                                          
?>