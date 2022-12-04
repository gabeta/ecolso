<?php

namespace App\Tenant\Concerns;

use App\Tenant\Observers\TeamObserver;
use App\Tenant\Scopes\TeamScope;
use Domain\Teams\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTeam
{
    public static function bootBelongsToTeam(): void
    {
        static::addGlobalScope(
            new TeamScope(app('currentTeam'))
        );

        static::observe(
            app(TeamObserver::class)
        );
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
