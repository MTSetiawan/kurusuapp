<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'whatsapp_number',
        'location',
        'bio',
        'profile_image_path'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function getProfileImageUrlAttribute(): ?string
    {
        return $this->profile_image_path ? asset('storage/' . $this->profile_image_path) : null;
    }
}
