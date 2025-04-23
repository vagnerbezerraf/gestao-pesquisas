<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Survey;
use App\Models\QuestionGroup;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'type', 'options', 'question_group_id', 'weight', 'description'];
    protected $casts = ['options' => 'array'];

    public function surveys()
    {
        return $this->belongsToMany(Survey::class)
                    ->withPivot('order', 'group')
                    ->withTimestamps();
    }

    /**
     * Question belongs to a QuestionGroup.
     */
    public function questionGroup()
    {
        return $this->belongsTo(QuestionGroup::class);
    }
}
