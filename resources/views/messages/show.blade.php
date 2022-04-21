@extends('layouts.app')
@section('title', '投稿詳細')
@section('header', 'id: ' .  $message->id . 'の投稿詳細')
@section('content')
            <div class="row mt-2">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="text-center">id</th>
                        <td>{{ $message->id }}</td>
                    </tr>
                    <tr>
                        <th class="text-center">名前</th>
                        <td>{{ $message->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-center">タイトル</th>
                        <td>{{ $message->title }}</td>
                    </tr>
                    <tr>
                        <th class="text-center">内容</th>
                        <td>{{ $message->body }}</td>
                    </tr>
                    <tr>
                        <th class="text-center">画像</th>
                        <td><img src="{{ Storage::disk('s3')->url('uploads/' . $message->image) }}" alt="表示する画像がありません。"></td>
                    </tr>
                </table>
            </div> 
            
            <div class="row mt-3">
                {!! link_to_route('messages.edit', '投稿の編集', ['id' => $message->id], ['class' => 'offset-sm-3 col-sm-6  btn btn-success']) !!}
            </div>
            <div class="row mt-4">
                {!! Form::model($message, ['route' => ['messages.destroy', $message->id], 'method' => 'delete', 'class' => 'offset-sm-3 col-sm-6']) !!}
            </div>   
            <div class="row">
                    {!! Form::submit('投稿の削除', ['class' => 'btn btn-danger offset-sm-3 col-sm-6', 'onclick' => 'return confirm("投稿を削除します。よろしいですか？")']) !!}
                {!! Form::close() !!}
            </div>
            
            <div class="offset-sm-2 col-sm-8 comments mt-5">
                @if(count($comments) !== 0)
                <div class="row mt-4">
                    <h3 class="offset-sm-3 col-sm-6 text-center mt-3 mb-3">コメント一覧</h3>
                </div>
                <div class="row">
                    <p class="offset-sm-3 col-sm-6 text-center text-success">現在{{ count($comments) }}件のコメントがあります。</p>
                </div>
                <div class="row">
                    <table class="col-sm-12 table table-bordered table-striped">
                        <tr class="text-center">
                            <th>コメントID</th>
                            <th>名前</th>
                            <th>コメント</th>
                            <th>コメント時刻</th>
                        </tr>   
                        @foreach($comments as $comment)
                        <tr>
                            <td class="text-center">{{ $comment->id }}</td>
                            <td class="text-center">{{ $comment->name }}</td>
                            <td>{{ $comment->body }}</td>
                            <td class="text-center">{{ $comment->created_at }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @else
                <p class="offset-sm-1 col-sm-10 text-danger text-center mt-5">※コメントはまだありません</p>
                @endif
            </div>
            <div class="row mt-4 offset-sm-12">
            {!! Form::open(['route' => ['comments.store'], 'class' => 'form-group offset-sm-1 col-sm-10']) !!}
                {!! Form::hidden('message_id', $message->id) !!}
                <div class="form-group row">
                    {!! Form::label('name', '名前: ', ['class' => 'col-sm-2 col-form-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    {!! Form::label('body', 'コメント: ', ['class' => 'col-sm-2 col-form-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('body',  old('body'), ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                {!! Form::submit('コメントの投稿', ['class' => 'offset-sm-3 col-sm-6 btn btn-primary btn-block']) !!}
            </div>
            {!! Form::close() !!}
        
            <div class="row mt-4 mb-5">
                {!! link_to_route('messages.index', '投稿一覧へ戻る', [], ['class' => 'offset-sm-3 col-sm-6 btn btn-danger']) !!}
            </div>
@endsection