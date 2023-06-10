<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Diploma extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'course',
        'status',
        'user',
        'graphics',
        'hypotheses',
        'technologies'
    ];

    public function technologies(): HasMany
    {
        return $this->hasMany(Technology::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function hypotheses(): HasMany
    {
        return $this->hasMany(Hypothese::class);
    }

    public function graphics(): HasMany
    {
        return $this->hasMany(Graphic::class);
    }

}
