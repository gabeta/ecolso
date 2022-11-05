<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class Discipline extends Model
{
    use UsesLandlordConnection;
    use HasFactory;

    public function disciplineTests(): HasMany
    {
        return $this->hasMany(DisciplineTest::class);
    }
}
