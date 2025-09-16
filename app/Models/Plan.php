<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'quota_region', 'duration_days', 'price'];

    public function userPlan()
    {
        return $this->hasMany(UserPlan::class);
    }
}
