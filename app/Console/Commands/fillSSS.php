<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Type;

use Illuminate\Support\Facades\File;

use Faker\Factory as Faker;
class fillSSS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill-sss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = public_path('post_images/use'); // Get the full path of the directory

        $pngFiles = collect(File::files($directory)) // Get all files
            //->filter(fn($file) => $file->getExtension() === 'png') // Filter PNG files
            ->map(fn($file) => $file->getFilename()) // Get only filenames
            ->values(); // Reset array keys
     //Post::truncate();
    // $types = Type::where('id','=',36)->get();
    $cats = Post::where('type_id','=',36)->where('id','<>',368)->get();
     $langs = ['TR','EN','DE'];
     $faker = Faker::create();
     foreach($cats as $cat ){
            $this->info($cat->name);
           Post::where('parent_id','=',$cat->id)->forceDelete();
             //'lang','type_id','count','title','second_title','prologue','content','link','image','second_image'
             foreach($langs as $lang){


                     for($i=1;$i< 6;$i++){
                         $p = new Post();
                         $p->lang = $lang;
                         $p->type_id = 18;
                         $p->count = $i;
                         $p->title =  $faker->sentence();
                         $p->second_title =  $faker->sentence();
                         $p->prologue = $faker->text(150);
                         $p->content = $faker->text(200);
                         $p->link = $faker->url();
                         $p->parent_id=$cat['id'];
                         $p->image = $pngFiles[ rand(0,count($pngFiles)-1)];
                         $p->second_image = $pngFiles[ rand(0,count($pngFiles)-1)];

                         $p->save();
                     }



             }//lang

     }

     return null;
    }
}
