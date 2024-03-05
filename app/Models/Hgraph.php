<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Traits\UUID;
class Hgraph extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
       
       'name',
       'url',
       'description',
       'nodes',
       'edges',
       'dnodemax',
       'dedgemax',
       'dnodeavg',
       'dedgeavg',
       'dnodes',
       'dedges'
    ];

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Categories::class, 'hgraphs_categories', 'hgraph_id', 'category_id');
    }
}
