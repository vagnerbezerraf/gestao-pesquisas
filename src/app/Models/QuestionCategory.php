<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'question_category_id');
    }
}
