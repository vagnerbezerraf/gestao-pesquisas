<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'type'];

    public function surveys()
    {
        return $this->belongsToMany(Survey::class)
                    ->withPivot('order')
                    ->withTimestamps();
    }

    public function answerOptions()
    {
        return $this->hasMany(AnswerOption::class);
    }
}