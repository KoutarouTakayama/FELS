<?php

namespace App\Http\Controllers;

use App\Word;
use App\User;
use App\Category;
use App\Relationship;
use App\LearnedWord;
use App\LearnedLesson;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController as Admin;

class UserController extends Controller
{
    public function userFollowingActivities($id)
    {
        $activities = collect();
        $user = app(User::class)::find($id);
        $followingUsersId = $user->relationshipOrderByUpdatedAtDescTakeTen;
        foreach ($followingUsersId as $followingUserId) {
            $followingUser = app(User::class)::find($followingUserId->following_id);
            if ($id == auth()->user()->id) {
                $user->userName = 'You';
            } else {
                $user->userName = $user->name;
            }
            $activities->push([
                'message' => '<a href="/profile/' . $user->id . '">' . $user->userName . '</a> followed <a href="/profile/' . $followingUser->id . '">' . $followingUser->name . '</a>.',
                'avatar_url' => $user->avatar_url,
                'updated_at' => $followingUserId->updated_at
            ]);
        }
        return $activities;
    }

    public function userLearnedLessonsActivities($id)
    {
        $activities = collect();
        $user = app(User::class)::find($id);
        $learnedLessons = $user->learnedLessonOrderByUpdatedAtDescTakeTen;
        foreach ($learnedLessons as $learnedLesson) {
            if ($id == auth()->user()->id) {
                $user->userName = 'You';
            } else {
                $user->userName = $user->name;
            }
            $learnedCategory = app(Category::class)::find($learnedLesson->category_id);
            $activities->push([
                'message' => '<a href="/Category/' . $user->id . '">' . $user->userName . '</a> learned ' .
                    $this->learnedWordGetByCategoryid($learnedCategory->id)->where('correct', true)->count() . ' of ' .
                    $this->learnedWordGetByCategoryid($learnedCategory->id)->count() . ' words in <a href="/category/' .
                    $learnedCategory->id . '">' . $learnedCategory->title . '</a>.',
                'avatar_url' => $user->avatar_url,
                'updated_at' => $learnedLesson->updated_at
            ]);
        }
        return $activities;
    }

    public function dashboardView()
    {
        $activities = collect();
        $user = app(User::class)::find(auth()->user()->id);
        $followingUsersId = $user->relationship;

        $activities = $activities->concat($this->userFollowingActivities(auth()->user()->id));
        foreach ($followingUsersId as $followingUserId) {
            $activities = $activities->concat($this->userFollowingActivities($followingUserId->following_id));
        }

        $activities = $activities->concat($this->userLearnedLessonsActivities(auth()->user()->id));
        foreach ($followingUsersId as $followingUserId) {
            $activities = $activities->concat($this->userLearnedLessonsActivities($followingUserId->following_id));
        }

        $activities = $activities->sortByDesc('updated_at');

        return view('/user/dashboard', compact(
            'activities',
            'user'
        ));
    }

    public function profileLearnedWordsView($id)
    {
        $user = app(User::class)::find($id);
        $learnedWords = $user->learnedWord;

        foreach ($learnedWords as $learnedWord) {
            $learnedWord->word = app(Word::class)::find($learnedWord->word_id);
        }

        return view('/user/learnedWords', compact(
            'learnedWords',
            'user'
        ));
    }

    public function profileLearnedLessonsView($id)
    {
        $user = app(User::class)::find($id);
        $activities = $this->userLearnedLessonsActivities($id);
        $activities = $activities->sortByDesc('updated_at');
        return view('/user/learnedLessons', compact('activities', 'user'));
    }

    public function profileView($id)
    {
        $user = app(User::class)::find($id);
        $activities = collect();
        $activities = $activities->concat($this->userFollowingActivities($id));
        $activities = $activities->concat($this->userLearnedLessonsActivities($id));
        $activities = $activities->sortByDesc('updated_at');

        return view('/user/profile', compact('user', 'activities'));
    }

    public function userFollow(Request $request)
    {
        Relationship::create([
            'user_id' => auth()->user()->id,
            'following_id' => $request->id,
        ]);
        return back();
    }

    public function userUnfollow(Request $request)
    {
        Relationship::where('user_id', auth()->user()->id)->where('following_id', $request->id)->delete();
        return back();
    }

    public function categoriesView($pageNumber)
    {
        $categories = app(Category::class)->getTenCategories($pageNumber);
        return view('/user/categoryList', compact('categories', 'pageNumber'));
    }

    public function learnedWordGetByCategoryid($categoryId)
    {
        $userWords = auth()->user()->learnedWord;
        $learnedWords = collect();
        foreach ($userWords as $userWord) {
            $categoryId == $userWord->word->category_id ? $learnedWords->push($userWord) : '';
        }
        return $learnedWords;
    }

    public function lessonView($categoryId)
    {
        $category = app(Category::class)::find($categoryId);
        !$category ? abort(404) : '';
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
        $word = app(Word::class)::find($wordId);
        $newWord = new LearnedWord();
        $newWord->word_id = $word->id;
        $newWord->user_id = auth()->user()->id;
        $word->answer === $request->choice ? $newWord->correct = true : $newWord->correct = false;
        if (!app(LearnedWord::class)->where('user_id', auth()->user()->id)->where('word_id', $wordId)->exists()) {
            $newWord->save();
        }

        return back();
    }

    public function lessonResult($categoryId)
    {
        $category = app(Category::class)::find($categoryId);
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

    public function userlistView($pageNumber)
    {
        $users = User::orderBy('updated_at')->skip(10 * ($pageNumber - 1))->take(10)->get();
        return view('/user/userlist', compact('users', 'pageNumber'));
    }

    public function settingsView()
    {
        $user = Auth::user();
        return view('/user/settings', compact('user'));
    }

    public function settingsProfileRestore(Request $request)
    {
        if ((new Admin)->accountRestore(Auth::user()->id, $request)) {
            return redirect()
                ->back()
                ->with('message', 'Profile was changed!')->with('color', 'success');
        } else {
            return redirect()
                ->back()
                ->with('message', 'Profile was not changed!')->with('color', 'danger');
        }
        return back();
    }

    public function settingsPasswordRestore(Request $request)
    {
        $request->validate([
            'newPassword' => 'required | min:6 | confirmed'
        ]);
        if (Hash::check($request->currentPassword, Auth::user()->password)) {
            User::find(Auth::user()->id)->fill([
                'password' => Hash::make($request->newPassword)
            ])->save();
            return redirect()
                ->back()
                ->with('message', 'Password was changed!')
                ->with('color', 'success');
        } else {
            return redirect()
                ->back()
                ->with('message', 'Password is wrong!')
                ->with('color', 'danger');
        }
        return back();
    }

    public function settingsAvatarRestore(Request $request)
    {
        $request->validate([
            'avatar' => 'required | file | image | mimes:jpeg,png',
        ]);
        if ($request->file('avatar')->isValid()) {
            $filename = Auth::user()->id . "-" . time() . '.jpg';
            $request->avatar->storeAs('public', $filename);
            Storage::disk('public')->delete(Auth::user()->avatar_url);
            User::find(Auth::id())->fill(['avatar_url' => $filename])->save();
            return back()
                ->with('message', 'Avatar image was updated!')
                ->with('color', 'success');
        } else {
            return back()
                ->with('message', 'Avatar image was not updaated!')
                ->with('color', 'danger');
        }
    }
}
