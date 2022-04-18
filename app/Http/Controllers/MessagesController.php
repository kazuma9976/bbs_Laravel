<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Messageモデルを使って、MySQLのmessageテーブルから全データを取得
        $messages = Message::all();
        
        // フラッシュメッセージをセッションから取得
        $flash_message = session('flash_message');
        // メッセージが重複して表示されることを防ぐためセッション情報を破棄
        session()->forget('flash_message');
        
        //エラーメッセージにnullをセット
        $errors = null;
        
        // 連想配列のデータを3セット(viewで引き出すキーワードと値のセット)を引き連れてviewを呼び出す。
        return view('messages.index', compact('messages', 'flash_message', 'errors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 空のメッセージインスタンスを作成
        $message = new Message();
        
        // セッションにメッセージが保存されていれば
        if(session('message')) {
            // セッションからメッセージ取得
            $message = session('message');
            // セッション情報の破棄
            session()->forget('message');
        }
        
        // フラッシュメッセージをnullにセット
        $flash_message = null;
        
        //エラーメッセージをnullにセット
        $errors = session('errors');
        // セッション情報の破棄
        session()->forget('errors');
        
        // 連想配列のデータを3セット(viewで引き出すキーワードと値のセット)引き連れてviewを呼び出す。
        return view('messages.create', compact('message', 'flash_message', 'errors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // create入力された値を取得
        $name = $request->input('name');
        $title = $request->input('title');
        $body = $request->input('body');
        // 画像ファイル情報の取得だけ特殊
        $file = $request->image;
        
        // 画像ファイルが選択されていれば
        if($file) {
            // 現在時刻ともともとのファイル名を組み合わせてランダムなファイル名を作成
            $image = time() . $file->getClientOriginalName();
            // アップロードするフォルダー名を取得
            $target_path = public_path('uploads/');
        } else { // ファイル名が選択されていなければ
            $image = null;
        }
        
        // 空のメッセージインスタンスを作成
        $message = new Message();
        // 入力された値をセット
        $message->name = $name;
        $message->title = $title;
        $message->body = $body;
        $message->image = $image;
        
        // 入力された値を検証
        $errors = $message->validate();
        // 入力エラーが一つもなければ
        if(count($errors) === 0) {
            // 画像アップロード処理
            $file->move($target_path, $image);
            // メッセージインスタンスをデータベースに保存
            $message->save();
            // セッションにflash_messageを保存
            session(['flash_message' => '新規投稿が成功しました']);
            // indexアクションへリダイレクト
            return redirect('/');
        } else {
            // セッションに、入力したメッセージインスタンスとエラーを保存
            session(['errors' => $errors, 'message' => $message]);
            
            // 再度訂正して入職してもらうため、createアクションへリダイレクト
            return redirect('/messages/create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
