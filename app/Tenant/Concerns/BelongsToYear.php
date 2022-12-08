<?php

namespace App\Tenant\Concerns;

use Domain\SchoolYears\Models\SchoolYear;
use App\Tenant\Observers\YearObserver;
use App\Tenant\Scopes\YearScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToYear
{
    public static function bootBelongsToYear(): void
    {
        static::addGlobalScope(
            new YearScope(app('currentYear'))
        );

        static::observe(
            app(YearObserver::class)
        );
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }
}
