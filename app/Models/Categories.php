<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Traits\UUID;

class Categories extends Model
{
    use HasFactory, UUID;
}
