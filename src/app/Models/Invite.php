<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id', 'group_id', 'email', 'token', 'sent_at', 'responded_at', 'status',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($invite) {
            $invite->token = (string) Str::uuid();
        });
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
