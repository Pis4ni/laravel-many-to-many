# File Storage Process Guide 

edited by: Pisani Fabio
Github : Pis4ni

## set up work envoirment

fare i seguenti step per predisporre il progetto al lavoro:
- sul file .env
    -       modificare le impostazioni dell`accessibilità:

            FILESYSTEM_DISK=local

            <!--! sostituire con: -->

            FILESYSTEM_DISK=public

            <!--* questo modifica il file config>filesystems.php -->

            'default' => env('FILESYSTEM_DISK', 'local'),

             <!--! in  -->

            'default' => env('FILESYSTEM_DISK', 'public'),


- sul terminale
    -       creare un link con la cartella public in storage:
            
            php artisan storage:link

## migrations

### aggiungere una colonna alla tab esistente

- sul temrinale
    -       creare la nuova migrazione:
            php artisan make:migration add_cover_image_to_projects_table

- su add_cover_image_to_projects_table.php
    -       add column
            <!-- ! UP -->
            public function up()
            {
                Schema::table('projects', function (Blueprint $table) {
                    $table->string('cover_image')->nullable()->after('technologies');
                });
            }

            <!-- ! DOWN -->
            public function down()
            {
                Schema::table('projects', function (Blueprint $table) {
                    $table->dropColumn('cover_image');
                });
            }


- sul terminale
    -       lancia la migrazione
            php artisan migrate



## aggiungo il caricamento file al form

### create.blade.php

- aggiungere input type="file"
- al tag form aggiungere:
    -       enctype="multipart/form-data"


### validation StoreProjectRequest.php

-  aggiungere la richiesta per cover_image 
    -       RULES
            'cover_image' => ['mimes:jpeg,jpg,png','nullable', 'max:512']

    -       MESSAGES
            'cover_image.image' => 'il file selezionato deve essere un\'immagine'
            'cover_image.max' => 'il file selezionato deve essere massimo di 512KB'

### ProjectController.php > store

spostiamoci sulla funzione pubblica dedicata al controllo del comportamento 'store'
nel ProjectController, li, prima del '$project->save()' creiamo un altra riga ed inseriamo:
        <!-- ! ATTENZIONE SE SI USA L'ID NEL PATH IL TUTTO ANDRÀ SCRITTO DOPO IL ->save() -->
        
-       if(Arr::exist($data,'cover_image')){
        $project->cover_image = Storage::put("uploads/projects/{$project->id}/cover_image",$data['cover_image']);
        }
        <!-- ! se si usa l'id come in questo caso aggiungere anche il save (due volte uno prima uno dopo la riga di Storage ) -->
        $project->save();


### show.blade.php

aggiungere la visualizzazione dell' immagine mediante un tag img

### destroy - force destroy

prima di $project->forceDelete();
    
    if($request->hasFile('cover_image')){
        Storage::delete($project->cover_image);
    }

### edit.blade.php
- aggiungo al tag form 
- se ho seguiuto la guida fin ora scritta, copio l input dal create e lo ricopio nell edit cosi com è
altrimenti creo l`input type="file"
- aggiungo un tag img per visualizzare l'immagine attuale 
    -       <img src="{{asset('/storage/' . $project->cover_image)}}" class="img-fluid" id="cover_image_preview">

### ProjectController > update (or UpdatePostRequest)

- validare l`input come fatto in precedenza nella request del create
- public function update   
    -       if(Arr::exist($data, 'cover_image')){
                if($request->hasFile('cover_image')){
                    Storage::delete($project->cover_image);
                }
            Storage::put("uploads/projects/{$porject->id}/cover_image",$data['cover_image'])
            }
            <!-- ! se si usa l'id come in questo caso aggiungere anche il save (due volte uno prima uno dopo la riga di Storage ) -->

#### reactive img tag

- Aggiungere se non presente, uno @yeld che ospiterà la parte di script nel template
-       <script type="text/javascript" defer>
            const inputFileElement = document.getElementById('Cover_image')
            const coverImagePreview = document.getElementById('Cover_image_preview')
            
            if(!coverImagePreview.getAttribute('src')){
                coverImagePreview.src = "https://placehold.co/400"
            }
            
            inputFileElement.addEventListener('change', function() => {
                const [ file ] = this.files;
                coverImagePreview.src = URL.createObjectURL(file)
            })
        </script>
        <!-- ! con alcune modifiche si può impostare anche il create affinche abbia una preview reactive -->
