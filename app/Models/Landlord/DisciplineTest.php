<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class DisciplineTest extends Model
{
    use UsesLandlordConnection;
    use HasFactory;

    protected $guarder = [];
}