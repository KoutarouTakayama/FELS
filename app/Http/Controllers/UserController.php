<?php

namespace App\Http\Controllers;

use App\Word;
use App\User;
use App\Category;
use App\Relationship;
use App\LearnedWord;
use App\LearnedLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccountController as AccountController;
use App\Http\Controllers\CategoryController as CategoryController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function userFollowingActivities($id)
    {
        $activities = collect();
        $user = User::find($id);
        $followingUsersId = $user->relationshipOrderByUpdatedAtDescTakeTen;
        foreach ($followingUsersId as $followingUserId) {
            $followingUser = User::find($followingUserId->following_id);
            if ($id == Auth::id()) {
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
        $user = User::find($id);
        $learnedLessons = $user->learnedLessonOrderByUpdatedAtDescTakeTen;
        foreach ($learnedLessons as $learnedLesson) {
            if ($id == Auth::id()) {
                $user->userName = 'You';
            } else {
                $user->userName = $user->name;
            }
            $learnedCategory = Category::find($learnedLesson->category_id);
            $activities->push([
                'message' => '<a href="/Category/' . $user->id . '">' . $user->userName . '</a> learned ' .
                    (new CategoryController)->learnedWordGetByCategoryid($learnedCategory->id)->where('correct', true)->count() . ' of ' .
                    (new CategoryController)->learnedWordGetByCategoryid($learnedCategory->id)->count() . ' words in <a href="/category/' .
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
        $user = Auth::user();
        $followingUsersId = $user->relationship;

        $activities = $activities->concat($this->userFollowingActivities($user->id));
        foreach ($followingUsersId as $followingUserId) {
            $activities = $activities->concat($this->userFollowingActivities($followingUserId->following_id));
        }

        $activities = $activities->concat($this->userLearnedLessonsActivities($user->id));
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
        $user = User::find($id);
        $learnedWords = $user->learnedWord;

        foreach ($learnedWords as $learnedWord) {
            $learnedWord->word = Word::find($learnedWord->word_id);
        }

        return view('/user/learnedWords', compact(
            'learnedWords',
            'user'
        ));
    }

    public function profileLearnedLessonsView($id)
    {
        $user = User::find($id);
        $activities = $this->userLearnedLessonsActivities($id);
        $activities = $activities->sortByDesc('updated_at');
        return view('/user/learnedLessons', compact('activities', 'user'));
    }

    public function profileView($id)
    {
        $user = User::find($id);
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
        Relationship::where('user_id', Auth::id())->where('following_id', $request->id)->delete();
        return back();
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
        if ((new AccountController)->reestore(Auth::id(), $request)) {
            return redirect()
                ->back()
                ->with('message', 'Profile was changed!')
                ->with('color', 'success');
        } else {
            return redirect()
                ->back()
                ->with('message', 'Profile was not changed!')
                ->with('color', 'danger');
        }
        return back();
    }

    public function settingsPasswordRestore(Request $request)
    {
        if ((new AccountController)->passwordRestore($request)) {
            return redirect()
                ->back()
                ->with('message', 'Password was changed!')
                ->with('color', 'success');
        } else {
            return redirect()
                ->back()
                ->with('message', 'Password was not changed!')
                ->with('color', 'danger');
        }
    }

    public function settingsAvatarRestore(Request $request)
    {
        if ((new AccountController)->avatarRestore($request)) {
            return redirect()
                ->back()
                ->with('message', 'Avatar image was updated!')
                ->with('color', 'success');
        } else {
            return redirect()
                ->back()
                ->with('message', 'Avatar image was not updated!')
                ->with('color', 'danger');
        }
    }
}
