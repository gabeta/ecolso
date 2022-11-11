<?php

namespace App\Tenant\Scopes;

use App\Tenant\TenantContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

abstract class TenantScope implements Scope
{
    private $tenant;

    public function __construct(TenantContract $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Builder $builder, Model $model)
    {
        if ($this->tenant->getForeignKey()) {
            $builder->where($this->tenant->getForeignKey(), $this->tenant->getPrimaryKeyValue());
        }
    }
}
