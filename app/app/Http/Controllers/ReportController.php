<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        // 既に報告済みかチェック
        $already = Report::where('post_id', $request->post_id)
                         ->where('user_id', Auth::id())
                         ->exists();

        if ($already) {
            return back()->with('success', 'この投稿はすでに報告済みです。');
        }

        // 保存
        Report::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'reason'  => '報告理由未設定（機能拡張予定）',
        ]);

        return back()->with('success', '違反報告を送信しました。');
    }
}
