@extends('layouts.app')
@section('title', '投稿詳細')
@section('header', 'ID: ' .  $message->id . 'の投稿詳細')
@section('content')
            <div class="row mt-2">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>ID</th>
                        <td>{{ $message->id }}</td>
                    </tr>
                    <tr>
                        <th>名前</th>
                        <td>{{ $message->name }}</td>
                    </tr>
                    <tr>
                        <th>タイトル</th>
                        <td>{{ $message->title }}</td>
                    </tr>
                    <tr>
                        <th>内容</th>
                        <td>{{ $message->body }}</td>
                    </tr>
                    <tr>
                        <th>画像</th>
                        <td><img src="{{ asset('uploads/' . $message->image) }}" alt="表示する画像がありません。"></td>
                    </tr>
                </table>
            </div> 
            
            <div class="row mt-5">
                {!! link_to_route('messages.edit', '編集', ['ID'=> $message->id], ['class' => 'col-sm-6 btn btn-success']) !!}
                
                {!! Form::model($message, ['route' => ['messages.destroy', $message->id], 'method' => 'delete', 'class' => 'col-sm-6']) !!}
                    {!! Form::submit('削除', ['class' => 'btn btn-danger col-sm-12', 'onclick' => 'return confirm("投稿を削除します。よろしいですか?")']) !!}
                {!! Form::close() !!}
            </div>       
        
             <div class="row mt-5">
                {!! link_to_route('messages.index', '投稿一覧', [], ['class' => 'btn btn-primary']) !!}
            </div>
@endsection