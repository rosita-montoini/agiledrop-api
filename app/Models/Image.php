<?php

namespace App\Models;

use App\Traits\Sortable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory, 
        Filterable,
        Sortable
    ;

    // Specify the attributes that can be mass-assigned
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_type',
        'file_size',
    ];

    protected $defaultSortableColumns = [
        'title', 'description'
    ];

    public function getFullUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    // Relationship: Image belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
