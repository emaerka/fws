<?php

namespace App\Models;

use App\Enums\Project\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'status'];

    protected $casts = [
        'status' => Status::class,
    ];

    /**
     * Get the projects status
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => __('common.project.status.' . $value),
        );
    }

    public function contactPeople(): BelongsToMany
    {
        return $this->belongsToMany(ContactPerson::class, 'contact_person_x_project');
    }

 
}
