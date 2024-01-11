<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'date',
    ];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_activities')
            ->using(UserActivity::class)
            ->withPivot('title', 'image', 'description', 'date');
    }

    /**
     * @return HasMany
     */
    public function userActivities(): HasMany
    {
        return $this->hasMany(UserActivity::class);
    }
}
