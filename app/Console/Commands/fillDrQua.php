<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Type;
use Faker\Factory as Faker;

class fillDrQua extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill-dr-qua';

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
        $drs = Post::where('type_id','=',33)->get();

        $faker = Faker::create();
        $langs = ['TR','EN','DE'];
        foreach($drs as $dr ){
               $this->info($dr->name);
              Post::where('parent_id','=',$dr->id)->forceDelete();
                //'lang','type_id','count','title','second_title','prologue','content','link','image','second_image'

                    foreach($langs as $lang){

                        for($i=1;$i<6;$i++){
                            $p = new Post();
                            $p->lang = $lang;
                            $p->type_id = 38;
                            $p->count = $i;
                            $p->title =  $faker->sentence();
                            $p->second_title =  $faker->sentence();
                            $p->prologue = $faker->text(150);
                            $p->content = $faker->text(200);

                            $p->parent_id=$dr['id'];


                            $p->save();
                        }
                    }




        }

        return null;
    }
}
