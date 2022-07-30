<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactPerson extends User
{
    use HasFactory, SoftDeletes;

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'contact_person_x_project');
    }
}
