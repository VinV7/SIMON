<?php

namespace App\Models;

use Database\Factories\ActivityCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
class ActivityCategory extends Model
{
    /** @use HasFactory<ActivityCategoryFactory> */
    use HasFactory;

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
