<?php

namespace App\Http\Controllers;

use App\User;
use App\Word;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AccountController as Account;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminController extends Controller
{
    public function categoriesView($pageNumber)
    {
        $pageNumber < 1 ? $pageNumber = 1 : '';
        $categories = app(Category::class)->orderBy('updated_at', 'desc')->skip(10 * ($pageNumber - 1))->take(10)->get();
        return view('/admin/categories', compact('categories', 'pageNumber'));
    }

    public function categoryEdit($categoryId)
    {
        try {
            $category = app(Category::class)::findOrFail($categoryId);
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }

        return view('/admin/categoryEdit', compact('category'));
    }

    public function categoryRestore($categoryId, Request $request)
    {
        $request->validate([
            'title' => 'required | max:50',
            'description' => 'required',
        ]);
        try {
            app(Category::class)::findOrFail($categoryId)->fill($request->all())->update();
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }

        return $this->categoriesView(1);
    }

    public function categoryDestroy($categoryId)
    {
        try {
            $category = app(Category::class)::findOrFail($categoryId);
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }

        return view('/admin/categoryDelete', compact('category'));
    }

    public function categoryDelete($categoryId)
    {
        try {
            app(Category::class)::findOrFail($categoryId)->delete();
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }

        return $this->categoriesView(1);
    }

    public function addWord($categoryId)
    {
        return view('/admin/addWord', compact('categoryId'));
    }

    public function addWordStore($categoryId, Request $request)
    {
        try {
            Category::findOrFail($categoryId);
        } catch (ModelNotFoundException $e) {
            return $this->categoriesView(1);
        }
        $request->validate([
            'word' => 'required | max:50', 'answer' => 'required | in:choice1,choice2,choice3,choice4',
            'choice1' => 'required | max:50', 'choice2' => 'required | max:50',
            'choice3' => 'required | max:50', 'choice4' => 'required | max:50',
        ]);
        $n = 1;
        $newWord = new Word;
        $newWord->word = $request->word;
        $newWord->category_id = $categoryId;
        for ($i = 1; $i < 5; $i++) {
            $choicei = 'choice' . $i;
            $wrong_answer_n = "wrong_answer_" . $n;
            if ($request->answer == $choicei) {
                $newWord->answer = $request->$choicei;
            } else {
                $newWord->$wrong_answer_n = $request->$choicei;
                $n++;
            }
        }
        $newWord->save();
        return back();
    }

    public function categoryAdd()
    {
        return view('/admin/categoryAdd');
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'title' => 'required | max:50',
            'description' => 'required | max:5000',
        ]);
        (new Category)->fill($request->all())->create($request->all());
        return $this->categoriesView(1);
    }

    public function usersView($pageNumber)
    {
        $pageNumber < 1 ? $pageNumber = 1 : '';
        $users = User::where('admin', false)->orderBy('updated_at', 'desc')->skip(10 * ($pageNumber - 1))->take(10)->get();
        return view('/admin/users', compact('users', 'pageNumber'));
    }

    public function userAddView()
    {
        return view('/admin/userAdd');
    }

    public function userStore(Request $request)
    {
        (new Account)->store($request);
        return redirect('/admin/users/1');
    }

    public function userEdit($userId)
    {
        $user = (new Account)->accountIdNameEmail($userId);
        return view('/admin/userEdit', compact('user'));
    }

    public function userRestore($userId, Request $request)
    {
        (new Account)->restore($userId, $request);
        return redirect('/admin/users/1');
    }

    public function userDestroy($userId)
    {
        $user = (new Account)->accountIdNameEmail($userId);
        return view('/admin/userDelete', compact('user'));
    }

    public function userDelete($userId)
    {
        (new Account)->delete($userId);
        return redirect('/admin/users/1');
    }

    public function adminsIndex($pageNumber)
    {
        $admins = User::where('admin', true)->orderBy('updated_at', 'desc')->skip(10 * ($pageNumber - 1))->take(10)->get();
        return view('/admin/admins', compact('admins', 'pageNumber'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'name' => 'required | min:3 | max:20', 'email' => 'required | email | unique:users',
            'password' => 'required | min:6 | confirmed'
        ]);
        User::create([
            'name' => $request->name, 'email' => $request->email,
            'password' => Hash::make($request->password), 'admin' => true
        ]);
        return redirect('/admin/admins/1');
    }

    public function adminEdit($adminId)
    {
        (new Account)->accountIdNameEmail($adminId);
        return view('/admin/adminEdit', compact('admin'));
    }

    public function adminRestore($adminId, Request $request)
    {
        (new Account)->restore($adminId, $request);
        return redirect('/admin/admins/1');
    }

    public function adminDestroy($adminId)
    {
        (new Account)->accountIdNameEmail($adminId);
        return view('/admin/adminDelete', compact('admin'));
    }

    public function adminDelete($adminId)
    {
        (new Account)->delete($adminId);
        return redirect('/admin/admins/1');
    }

    public function dashboardView()
    {
        return view('/admin/dashboard');
    }

    public function userProfileView($id)
    {
        $user = (new User)->exists($id);
        return view('/admin/userProfile',compact('user'));
    }
}
