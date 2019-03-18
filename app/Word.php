<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'word', 'answer', 'wrong_answer_1', 'wrong_answer_2', 'wrong_answer_3', 'category_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function learnedWord()
    {
        return $this->hasMany(learnedWord::class, 'word_id', 'id');
    }
}
