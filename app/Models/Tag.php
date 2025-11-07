<?php

namespace App\Models;

use App\Models\BaseModel;

class Tag extends BaseModel
{

    protected $fillable = [
        'name',
        'color',
        'description',
    ];

    /**
     * The users that belong to the tag.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tags')
            ->withTimestamps()
            ->withPivot('assigned_at');
    }
}
