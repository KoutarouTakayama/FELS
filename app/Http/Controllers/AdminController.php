<?php

namespace App\Http\Controllers;

use App\User;
use App\Word;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function categoriesView($pageNumber)
    {
        $pageNumber < 0 ? $pageNumber = 1 : '';
        $categories = app(Category::class)->orderBy('updated_at', 'desc')->skip(10 * ($pageNumber - 1))->take(10)->get();
        return view('/admin/categories', compact('categories', 'pageNumber'));
    }

    public function categoryEdit($categoryId)
    {
        $category = app(Category::class)::find($categoryId);
        return view('/admin/categoryEdit', compact('category'));
    }

    public function categoryRestore($categoryId, Request $request)
    {
        $request->validate([
            'title' => 'required | max:50',
            'description' => 'required',
        ]);
        app(Category::class)::find($categoryId)->fill($request->all())->update();
        return $this->categoriesView(1);
    }

    public function categoryDestroy($categoryId)
    {
        $category = app(Category::class)::find($categoryId);
        return view('/admin/categoryDelete', compact('category'));
    }

    public function categoryDelete($categoryId)
    {
        app(Category::class)::find($categoryId)->delete();
        return $this->categoriesView(1);
    }

    public function addWord($categoryId)
    {
        return view('/admin/addWord', compact('categoryId'));
    }

    public function addWordStore($categoryId, Request $request)
    {
        if (Category::find($categoryId) == null) {
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
        $pageNumber < 0 ? $pageNumber = 1 : '';
        $users = User::where('admin', false)->orderBy('updated_at', 'desc')->skip(10 * ($pageNumber - 1))->take(10)->get();
        return view('/admin/users', compact('users', 'pageNumber'));
    }

    public function userAddView()
    {
        return view('/admin/userAdd');
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required | min:3 | max:20',
            'email' => 'required | email | unique:users',
            'password' => 'required | min:6 | confirmed'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/admin/users/1');
    }

    public function userExists($userId)
    {
        if (User::find($userId) == null) {
            return abort(404);
        }
    }

    public function userEdit($userId)
    {
        $this->userExists($userId);
        $user = User::select('id', 'name', 'email')->find($userId);
        return view('/admin/userEdit', compact('user'));
    }

    public function accountRestore($userId, $request)
    {
        $this->userExists($userId);
        if ($request->name !== User::find($userId)->name) {
            $request->validate([
                'name' => 'required | min:3 | max:20',
            ]);
        }
        if ($request->email !== User::find($userId)->email) {
            $request->validate([
                'email' => 'required | email | unique:users',
            ]);
        }
        return User::find($userId)->fill([
            'name' => $request->name,
            'email' => $request->email
        ])->save();
    }

    public function userRestore($userId, Request $request)
    {
        try {
            $this->accountRestore($userId, $request);
        } catch (Exeption $e) {
            return back();
        }
        return redirect('/admin/users/1');
    }

    public function userDestroy($userId)
    {
        $this->userExists($userId);
        $user = User::select('id', 'name', 'email')->find($userId);
        return view('/admin/userDelete', compact('user'));
    }

    public function accountDelete($accountId)
    {
        $this->userExists($accountId);
        User::find($accountId)->delete();
    }

    public function userDelete($userId)
    {
        try {
            $this->accountDelete($userId);
        } catch (Exception $e) {
            return back();
        }
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
        $this->userExists($adminId);
        $admin = User::select('id', 'name', 'email')->find($adminId);
        return view('/admin/adminEdit', compact('admin'));
    }

    public function adminRestore($adminId, Request $request)
    {
        try {
            $this->accountRestore($adminId, $request);
        } catch (Exeption $e) {
            return back();
        }
        return redirect('/admin/admins/1');
    }

    public function adminDestroy($adminId)
    {
        $this->userExists($adminId);
        $admin = User::select('id', 'name', 'email')->find($adminId);
        return view('/admin/adminDelete', compact('admin'));
    }

    public function adminDelete($adminId)
    {
        try {
            $this->accountDelete($adminId);
        } catch (Exception $e) {
            return back();
        }
        return redirect('/admin/admins/1');
    }
}
