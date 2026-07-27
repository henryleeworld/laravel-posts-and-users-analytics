<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description'])]
class UserStatus extends Model
{
    /** @use HasFactory<\Database\Factories\UserStatusFactory> */
    use HasFactory;

    /**
     * Get the users for the user status.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'status_id');
    }
}
