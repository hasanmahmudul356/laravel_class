<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    protected $appends = ['title2'];

    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'details'
    ];


    public function getTitleAttribute($value){
        return strtoupper($value);
    }
    public function getTitle2Attribute($value){
        return strtoupper($this->title);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
