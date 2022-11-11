<?php

namespace App\Tenant\Concerns;

use App\Models\Landlord\SchoolYear;
use App\Tenant\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToYear
{
    public static function bootBelongsToYear(): void
    {
        static::addGlobalScope(
            new TenantScope(app('currentYear'))
        );

        static::observe(
            app("observeYear")
        );
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }
}
