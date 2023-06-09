<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
