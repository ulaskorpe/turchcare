<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='comments';
    protected $fillable = ['name','ip_address','blog_id','phone','email','message','show_comment'];

    public function blog(){
        return $this->belongsTo(Post::class,'blog_id');
    }
}
