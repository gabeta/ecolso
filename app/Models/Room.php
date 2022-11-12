<?php

namespace App\Models;

use App\Models\Landlord\RoomType;
use App\Tenant\Concerns\BelongsToTeam;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Spatie\Multitenancy\Models\Tenant;

class Room extends Model
{
    use BelongsToTeam;
    use HasFactory;
    use HasUuids;
    use UsesTenantConnection;
    use SoftDeletes;

    protected $guarded = [];

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(RoomType::class, Tenant::current()->getDatabaseName().'.type_of_rooms', 'room_id', 'room_type_id');
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

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array
     */
    public function uniqueIds()
    {
        return ['uuid'];
    }
}
