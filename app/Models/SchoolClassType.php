<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SchoolClassType extends Model
{
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
