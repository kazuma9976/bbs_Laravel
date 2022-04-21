<?php

namespace App\Http\Controllers;

use App\Message;
use App\Comments;  // 追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Messageモデルを使って、MySQLのmessageテーブルから15件データを取得
        $messages = Message::paginate(15);
        
        // 連想配列のデータを1セット(viewで引き出すキーワードと値のセット)を引き連れてviewを呼び出す。
        return view('messages.index', compact('messages'));
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
        
        // 連想配列のデータを1セット(viewで引き出すキーワードと値のセット)引き連れてviewを呼び出す。
        return view('messages.create', compact('message'));
    }

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
            'title' => 'required',
            'body' => 'required',
            'image' => [
                'required',
                'file',
                'mimes: jpeg,jpg,png'
            ]
        ]);
        
        // create(新規投稿)で入力された値を取得
        $name = $request->input('name');
        $title = $request->input('title');
        $body = $request->input('body');
        // 画像ファイル情報の取得だけ特殊
        $file = $request->image;
        
        // // 現在時刻ともともとのファイル名を組み合わせてランダムなファイル名を作成
        // $image = time() . $file->getClientOriginalName();
        // // アップロードするフォルダー名を取得
        // $target_path = public_path('uploads/');
        //  // 画像アップロード処理 
        // $file->move($target_path, $image);
        
        // S3用
        $path = Storage::disk('s3')->putFile('/uploads', $file, 'public');
        // パスから、最後の「ファイル名.拡張子」の部分だけ取得
        $image = basename($path);
        
        // 空のメッセージインスタンスを作成
        $message = new Message();
        
        // 入力された値をセット
        $message->name = $name;
        $message->title = $title;
        $message->body = $body;
        $message->image = $image;
        
        // メッセージインスタンスをデータベースに保存
        $message->save();
        
        // セッションにフラッシュメッセージを保存しながら、indexアクションへリダイレクト
        return redirect('/')->with('flash_message', '新規投稿が成功しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        // このメッセージに紐づいたコメント一覧を取得
        $comments = $message->comments()->get();
        // 連想配列配列のデータを2セット(viewで引き出すキーワードと値のセット)引き連れてviewを呼び出す
        return view('messages.show', compact('message', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        // 連想データを1セット(viewで引き出すキーワードとの値のセット)引き連れてviewを呼び出す。
        return view('messages.edit', compact('message'));
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
        // validation
        $this->validate($request, [
            'name' => 'required',
            'title' => 'required',
            'body' => 'required',
        ]);
        
        // resources/views/messages/edit.blade.php(投稿編集)で、入力された値を取得
        $name = $request->input('name');
        $title = $request->input('title');
        $body = $request->input('body');
        // 画像ファイル情報の取得だけ特殊
        $file = $request->image;
        
        // 画像ファイルが選択されていれば
        if($file) {
            // // 現在時刻(UNIXタイムスタンプ)と、元々のファイル名を組み合わせてランダムなファイル名を作成
            // $image = time() . $file->getClientOriginalName();
            // // アップロードするフォルダ名を取得
            // $target_path = public_path('uploads/');
            // // 画像アップロード処理
            // $file->move($target_path, $image);
            
            // S3用
            $path = Storage::disk('s3')->putFile('/uploads', $file, 'public');
            // パスから、最後の「ファイル名.拡張子」の部分だけ取得
            $image = basename($path);
            
        } else { // ファイルが選択されていなければ、元の値(登録されている画像)を保持
            $image = $message->image;
        }
        
        // 入力されたインスタンス情報を更新
        $message->name = $name;
        $message->title = $title;
        $message->body = $body;
        $message->image = $image;
            
        // データベースを更新
        $message->save();
        
        // フラッシュメッセージを保存しながら、showアクションへリダイレクト
        return redirect('/messages/' . $message->id)->with('flash_message', 'ID: ' . $message->id . 'の更新が成功しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        // 該当メッセージをデータベースから削除
        $message->delete();
        
        // フラッシュメッセージを保存しながら、showアクションへリダイレクト
        return redirect('/')->with('flash_message', 'ID: ' . $message->id . 'の投稿を削除しました');
    }
}
