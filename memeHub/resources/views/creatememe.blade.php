
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
                   
            </div>
        </div>
    </div>
</div>
</x-app-layout>
