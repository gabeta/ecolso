<?php

namespace App\Tenant;

use Illuminate\Database\Eloquent\Model;

class Tenant implements TenantContract
{
    private $tenant;

    public function get()
    {
        return $this->tenant;
    }

    public function put(Model $tenant)
    {
        $this->tenant = $tenant;
    }

    public function getPrimaryKeyValue()
    {
        return $this->tenant ? $this->tenant->id : null;
    }

    public function getForeignKey()
    {
        return $this->tenant ? $this->tenant->getForeignKey() : null;
    }
}
