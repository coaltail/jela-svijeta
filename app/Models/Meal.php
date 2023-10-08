<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Meal extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;

    protected $fillable = ['status', 'slug', 'category'];
    public $translatedAttributes = ['title', 'description'];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault();
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredients::class);
    }
}
