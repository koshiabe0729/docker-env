<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * ユーザー一覧 + 検索
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $query = User::query();

        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
        }

        $users = $query->orderBy('id', 'asc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * ユーザー詳細
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }
}
