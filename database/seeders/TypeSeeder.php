<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;
use App\Http\Controllers\Helpers\GeneralHelper;
use App\Models\Post;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

$array = [
['Menu Item',0],
['Menu sub',0],
['Site Phone',1],
['Site Address',1],
['Site Email',1],
['Top button',1],
['Welcome spot',1],
['Middle icons',0],
['About Us',1],
['About Us Sentences',0],
['Treatment Sentence',1],
['Treatment Images',0],
['Slider Spot',1],
['Slider Images',0],
['Travel Spot',1],
['Travel Item',0],
['Faq Spot',1],
['Faq Item',0],
['Tourism spot',1],
['Tourism Item',0],
['Video Spot',1],
['Video Item',0],
['Testmonial Spot',1],
['Comments',0],
['Blog Spot',1],
['Blog',0],
['Footer SM',0],
['Footer Quick',0],
['Footer Popular',0]
];

Type::truncate();
Post::truncate();
$fields =  "'title','second_title','content','prologue','link','count','type_id','image','second_image','lang'";

foreach($array as $item){
    // $t = new Type();
    // $t->name = $item[0];
    // $t->slug = GeneralHelper::fixName($item[0]);
    // $t->single = $item[1];
    // $t->fields=$fields;
    // $t->save();

    Type::create([
        'name'   => $item[0],
        'slug'   => GeneralHelper::fixName($item[0]),
        'single' => $item[1],
        'fields' => $fields,
    ]);

}






    }
}
