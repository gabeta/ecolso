<?php

namespace Domain\SchoolYears\Models;

use Database\Factories\SchoolYearFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class SchoolYear extends Model
{
    use HasFactory;
    use HasSlug;
    use UsesLandlordConnection;

    protected $guarded = [];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return SchoolYearFactory::new();
    }

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
