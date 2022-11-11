<?php

namespace App\Models;

use App\Models\Landlord\ClassRoomType;
use App\Tenant\Concerns\BelongsToTeam;
use App\Tenant\Concerns\BelongsToYear;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class ClassRoom extends Model
{
    use BelongsToTeam;
    use BelongsToYear;
    use HasFactory;
    use UsesTenantConnection;
    use SoftDeletes;

    protected $guarded = [];

    public function type(): BelongsTo
    {
        return $this->belongsTo(ClassRoomType::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
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
