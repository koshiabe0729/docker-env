<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // 管理者ログインフォーム表示
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // 管理者ログイン処理
    public function login(Request $request)
    {
        // バリデーション
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // 通常の Auth で一旦ログインしてから role をチェック
        if (Auth::attempt($credentials)) {

            // isAdmin() は Userモデルに定義（あとで説明）
            if (! Auth::user()->isAdmin()) {
                Auth::logout();
                return back()->withErrors(['email' => '管理者ではありません。']);
            }

            // OKなら管理者トップへ
            return redirect()->route('admin.top');
        }

        return back()->withErrors(['email' => 'ログイン情報が正しくありません。']);
    }

    // 管理者ログアウト
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
