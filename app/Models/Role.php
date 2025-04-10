<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /**
     * Получить пользователей с этой ролью.
     */

    protected $fillable = [
        'name', // Добавьте это поле
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
