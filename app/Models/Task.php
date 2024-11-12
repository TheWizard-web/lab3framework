<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'category_id'];

    // Definirea relației many-to-one cu Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Definirea relației many-to-many cu Tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
