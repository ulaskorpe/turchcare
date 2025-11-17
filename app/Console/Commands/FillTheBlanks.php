<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Type;

use Illuminate\Support\Facades\File;

use Faker\Factory as Faker;
class FillTheBlanks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill-the-blanks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

     protected $faker;
     protected $png_files;

     public function __construct()
     {
        parent::__construct(); // BU SATIR ŞART!
         $this->faker = Faker::create();
         $this->png_files = collect(File::files(public_path('post_images/use'))) // Get all files
         //->filter(fn($file) => $file->getExtension() === 'png') // Filter PNG files
         ->map(fn($file) => $file->getFilename()) // Get only filenames
         ->values(); // Reset array keys
     }

    public function handle()
    {
       
      
    // Post::truncate();
       
 
      //$types = Type::whereNotIn('slug',Type::where('children','!=',null)->pluck('children')->toArray())->get();
      
      $types = Type::whereIn('slug',['our_shop'])->get();
      
      //where('children','!=',null)->get();

     $langs = ['tr','en'];
    
     foreach($types as $type ){
         
         //  Post::where('type_id','=',$type->id)->forceDelete();
             //'lang','type_id','count','title','second_title','prologue','content','link','image','second_image'

             
             foreach($langs as $lang){
              //  $this->info($type['children']."::".$lang);
                  $this->createData($type,$lang);

             }//lang
            

     }

     echo PHP_EOL;

     return null;
    }


    private function createData(Type $type,$lang,$parent_id=0){
        $count = ($type->single == 1)?1:15;
        $this->info($count);
        $this->info($type['name']."::".$lang);
        for($i=0;$i< $count;$i++){
            $p = new Post();
            $p->lang = strtolower($lang);
            $p->type_id = $type['id'];
            $p->parent_id = $parent_id;
            $p->count = $i+1;
            $p->title = $this->faker->sentence();
            $p->second_title = $this->faker->sentence();
            $p->third_title = $this->faker->sentence();
            $p->prologue = $this->faker->text(150);
            $p->content = $this->faker->text(200);
            $p->content_2 = $this->faker->text(200);
            $p->link = $this->faker->url();
            $p->parent_id = $parent_id;
            $p->show_post = 1;
            // $p->image = $this->png_files[ rand(0,count( $this->png_files )-1)];
            // $p->second_image = $this->png_files[ rand(0,count($this->png_files)-1)];
            // $p->third_image = $this->png_files[ rand(0,count($this->png_files)-1)];
            // $p->forth_image = $this->png_files[ rand(0,count($this->png_files)-1)];
            // $p->fifth_image = $this->png_files[ rand(0,count($this->png_files)-1)];
            $p->save();

           
                // $sub_type = Type::where('slug','=',$type['children'])->first();
                // if($sub_type){
                // $this->error($sub_type['name']."::".$lang);
                // $this->createData($sub_type,$lang,$p->id);
                //  }
           

        }
    }
}
