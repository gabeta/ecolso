<?php

namespace App\Models\Landlord;


use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;
    use HasSlug;

    protected $guarded = [];

    /**
    * Get the options for generating the slug.
    */
   public function getSlugOptions() : SlugOptions
   {
       return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
   }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return "slug";
    }
}
