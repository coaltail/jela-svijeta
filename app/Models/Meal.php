<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;
    use SoftDeletes;
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
