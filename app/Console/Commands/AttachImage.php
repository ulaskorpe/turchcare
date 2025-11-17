<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Type;

use Illuminate\Support\Facades\File;

use Faker\Factory as Faker;
class AttachImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attach-image';

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
       $posts =  Post::whereIn('type_id',[5])->get();
        foreach($posts as $post){
            $this->info($post['title'].":".$post['id']);
            $post->image = $this->png_files[ rand(0,count( $this->png_files )-1)];
            $post->save();
        }
    }
}
