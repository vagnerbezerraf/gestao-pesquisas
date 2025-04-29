<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Survey;
use App\Models\QuestionCategory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'type', 'options', 'question_category_id', 'weight', 'description'];
    protected $casts = ['options' => 'array'];

    public function surveys()
    {
        return $this->belongsToMany(Survey::class)
                    ->withPivot('order', 'group')
                    ->withTimestamps();
    }

    public function questionCategory()
    {
        return $this->belongsTo(QuestionCategory::class, 'question_category_id');
    }
}
