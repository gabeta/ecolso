<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class SchoolClassType extends Model
{
    use UsesLandlordConnection;
    use HasFactory;

    protected $guarded = [];


    public function disciplines(): BelongsToMany
    {
        return $this->belongsToMany(Discipline::class, 'class_disciplines', 'school_class_type_id', 'discipline_id');
    }

    public function disciplineTests(): BelongsToMany
    {
        return $this->belongsToMany(ClassTest::class, 'class_tests', 'school_class_type_id', 'discipline_test_id');
    }
}
