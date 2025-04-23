<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Question;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
