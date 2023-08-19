<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

     protected $fillable = ['parent_id', 'slug', 'title', 'content'];

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id', 'id');
    }

    public function getNestedSlugAttribute()
    {
        $segments = [$this->slug];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($segments, $parent->slug);
            $parent = $parent->parent;
        }

        return implode('/', $segments);
    }

    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }
}
