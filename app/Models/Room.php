<?php

namespace App\Models;

use App\Models\Landlord\RoomType;
use App\Tenant\Concerns\BelongsToTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\SlugOptions;

class Room extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BelongsToTeam;

    protected $guarded = [];

    public function type(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return "uuid";
    }
}
