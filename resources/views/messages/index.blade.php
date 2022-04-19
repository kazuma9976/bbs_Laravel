@extends('layouts.app')
@section('title', '簡易掲示板')
@section('header', '投稿一覧')
@section('content')
            <div class="row mt-2">
                @if(count($messages) !== 0) 
                <table class="col-sm-12 table table-bordered table-striped">
                    <tr>
                        <th>ID</th>
                        <th>ユーザ名</th>
                        <th>タイトル</th>
                        <th>内容</th>
                        <th>投稿時間</th>
                    </tr>
                    </tr>
                    @foreach($messages as $message)
                    <tr>
                        <td>{!! link_to_route('messages.show', $message->id, ['ID' => $message->id], []) !!}</td>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->title }}</td>
                        <td>{{ $message->body }}</td>
                        <td>{{ $message->created_at }}</td>
                    </tr>
                    @endforeach
                </table>
                
                <!--ページネーションのために追記-->
                <div class="row">
                    <div class="col-sm-12">
                        {{ $messages->links() }}
                    </div>
                </div>
                
                @else
                <p>データ一件もありません。</p>
                @endif
            </div>
            <div class="row mt-5 mb-5">
                {!! link_to_route('messages.create', '新規投稿',[], ['class' => 'btn btn-primary']) !!}
            </div> 
        </div>
@endsection
