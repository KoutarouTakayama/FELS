<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'admin', 'avatar_url'
    ];

    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function learnedWord()
    {
        return $this->hasMany(LearnedWord::class);
    }

    public function learnedLesson()
    {
        return $this->hasMany(LearnedLesson::class);
    }

    public function learnedLessonOrderByUpdatedAtDescTakeTen()
    {
        return $this->hasMany(LearnedLesson::class)->orderBy('updated_at', 'desc')->take(10);
    }

    public function relationship()
    {
        return $this->hasMany(Relationship::class);
    }

    public function checkRelationship($id)
    {
        return $this->hasMany(Relationship::class)->where('following_id', $id)->exists();
    }

    public function relationshipOrderByUpdatedAtDescTakeTen()
    {
        return $this->hasMany(Relationship::class)->orderBy('updated_at', 'desc')->take(10);
    }
}
