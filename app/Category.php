<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'title', 'description'
    ];
    public function learnedLesson()
    {
        return $this->hasMany(learnedLesson::class);
    }

    public function word()
    {
        return $this->hasMany(Word::class);
    }

    public function getTenCategories($pageNumber)
    {
        if ($pageNumber <= 0) {
            $pageNumber = 1;
        }
        return $this::orderBy('updated_at', 'desc')->skip(10 * ($pageNumber - 1))->take(10)->get();
    }
}
