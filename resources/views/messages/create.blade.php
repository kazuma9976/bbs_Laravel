@extends('layouts.app')
@section('title', '新規投稿')
@section('header', '新規投稿')
@section('content')
            <div class="row mt-2">
                
                {!! Form::model($message, ['route' => 'messages.store', 'enctype' => 'multipart/form-data', 'class' => 'col-sm-12']) !!}
                
                    <!-- 1行 -->
                    <div class="form-group row">
                        {!! Form::label('name', '名前', ['class' => 'col-2 col-form-label']) !!}
                        <div class="col-10">
                            <!-- oldメソッドで直前に入力した内容を表示できるようにし、そうでなければ$messageが持つnameを表示-->
                            {!! Form::text('name', old('name') ? old('name') : $message->name, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                
                    <!-- 1行 -->
                    <div class="form-group row">
                        {!! Form::label('title', 'タイトル', ['class' => 'col-2 col-form-label']) !!}
                        <div class="col-10">
                            <!-- oldメソッドで直前に入力した内容を表示できるようにし、そうでなければ$messageが持つtitleを表示-->
                            {!! Form::text('title', old('title') ? old('title') : $message->title, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    
                    <!-- 1行 -->
                    <div class="form-group row">
                        {!! Form::label('body', '内容', ['class' => 'col-2 col-form-label']) !!}
                        <div class="col-10">
                            <!-- oldメソッドで直前に入力した内容を表示できるようにし、そうでなければ$messageが持つbodyを表示-->
                            {!! Form::text('body', old('body') ? old('body') : $message->body, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        {!! Form::label('image', '画像アップロード', ['class' => 'col-2 col-form-label']) !!}
                        <div class="col-3">
                            {!! Form::file('image', ['accept' => 'image/*', 'onchange' => "previewImage(this)"]) !!}
                        </div> 
                        <div class="col-7">
                            <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:200px;">
                        </div>
                    </div>
                    
                    <!-- 1行 -->
                    <div class="form-group row">
                        <div class="offset-2 col-10">
                            {!! Form::submit('投稿', ['class' => 'col-sm-4 btn btn-primary']) !!}
                        </div>
                    </div>
                    
                {!! Form::close() !!}
                
            </div>
            <div class="row mt-5">
                {!! link_to_route('messages.index', '投稿一覧へ戻る', [], ['class' => 'col-sm-2 btn btn-danger']) !!}
            </div>
@endsection