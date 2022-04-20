<?php

namespace App\Http\Controllers;

use App\Message; // 追加
use App\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation
        $this->validate($request, [
            'name' => 'required',
            'body' => 'required',
        ]);
        
        // 前のページから飛んできた情報を取得
        $message_id = $request->input('message_id');
        $name = $request->input('name');
        $body = $request->input('body');
        
        // メッセージインスタンスを取得
        $message = Message::find($message_id);
        
        // データベースにこのメッセージに紐づいた新規コメントを保存
        $message->comments()->create(['name' => $name, 'body' => $body]);
        
        // MessageController の show アクションへリダイレクト
        return redirect()->route('messages.show', $message)->with('flash_message', 'コメントを投稿しました');
    }

}
