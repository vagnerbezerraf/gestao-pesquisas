<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'emails'];

    protected $casts = [
        'emails' => 'array',
    ];

    public function invites()
    {
        return $this->hasMany(Invite::class);
    }
}
