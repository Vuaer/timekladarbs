
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
                        @if (true)
                        <p> I have one record!</p>
                                @pastetemplates(); 
                        @endif

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
    echo basename($image) . "<br />"; // show only image name if you want to show full path then use this code // echo $image."<br />";
    echo '<img src="' . $image . '" alt="Random image" />' . "<br /><br />";

}
}
?>