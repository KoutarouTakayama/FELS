<?php

namespace App\Http\Controllers;

use App\Word;
use App\Category;
use App\learnedWord;
use App\learnedLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function categoryExists($id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }
        return $category;
    }

    public function categoriesView($pageNumber)
    {
        $categories = (new Category)->getTenCategories($pageNumber);
        return view('/user/categoryList', compact('categories', 'pageNumber'));
    }

    public function learnedWordGetByCategoryid($categoryId)
    {
        $userWords = Auth::user()->learnedWord;
        $learnedWords = collect();
        foreach ($userWords as $userWord) {
            $categoryId == $userWord->word->category_id ? $learnedWords->push($userWord) : '';
        }
        return $learnedWords;
    }

    public function lessonView($categoryId)
    {
        $category = $this->categoryExists($categoryId);

        $learnedWords = $this->learnedWordGetByCategoryid($categoryId);
        $words = $category->word;
        foreach ($words as $word) {
            $token = true;
            foreach ($learnedWords as $learnedWord) {
                $word->id == $learnedWord->word->id ? $token = false : '';
            }
            if ($token) {
                $choices = [
                    $word->answer, $word->wrong_answer_1,
                    $word->wrong_answer_2, $word->wrong_answer_3
                ];
                shuffle($choices);
                return view('/user/lesson', compact('word', 'category', 'learnedWords', 'choices'));
            }
        }

        return $this->lessonResult($categoryId);
    }

    public function answerCheck($wordId, Request $request)
    {
        $word = Word::find($wordId);
        $newWord = new learnedWord;
        $newWord->word_id = $word->id;
        $newWord->user_id = auth()->user()->id;
        $word->answer === $request->choice ? $newWord->correct = true : $newWord->correct = false;
        if (!learnedWord::where('user_id', Auth::id())->where('word_id', $wordId)->exists()) {
            $newWord->save();
        }

        return back();
    }

    public function lessonResult($categoryId)
    {
        $category = $this->categoryExists($categoryId);

        $words = $this->learnedWordGetByCategoryid($categoryId);
        $count = 0;
        foreach ($words as $word) {
            $word->correct ? $count++ : '';
        }
        if (!auth()->user()->learnedLesson()->where('category_id', $categoryId)->exists()) {
            LearnedLesson::create([
                'user_id' => auth()->user()->id,
                'category_id' => $categoryId,
            ]);
        }

        return view('/user/result', compact('words', 'category', 'count'));
    }
}
