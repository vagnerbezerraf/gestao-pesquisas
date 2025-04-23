<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyDistribution extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id', 'group_id', 'sent_at'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}