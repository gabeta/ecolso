<?php

namespace App\Tenant\Concerns;

use App\Models\Team;
use App\Tenant\Scopes\TeamScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTeam
{
    public static function bootBelongsToTeam(): void
    {
        static::addGlobalScope(
            new TeamScope(app('currentTeam'))
        );

        static::observe(
            app("observeTeam")
        );
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}