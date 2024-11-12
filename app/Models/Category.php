<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description']; 

    // Definirea relației one-to-many cu Task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
