<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Ingredients extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $fillable = ['slug'];
    public $translatedAttributes = ['title'];
    public function meals()
    {

        return $this->belongsToMany(Meal::class);
    }
}
