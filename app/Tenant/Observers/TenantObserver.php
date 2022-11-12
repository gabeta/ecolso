<?php

namespace App\Tenant\Observers;

use App\Tenant\TenantContract;
use Illuminate\Database\Eloquent\Model;

abstract class TenantObserver
{
    /**
     * @var TenantContract
     */
    private $tenant;

    /**
     * TenantObserver constructor.
     * @param TenantContract $tenant
     */
    public function __construct(TenantContract $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * @param Model $model
     */
    public function creating(Model $model): void
    {
        $foreignKey = $this->tenant->getForeignKey() ?? 'team_id';

        if (! isset($model->{$foreignKey})) {
            $model->setAttribute($foreignKey, $this->tenant->getPrimaryKeyValue());
        }
    }
}
