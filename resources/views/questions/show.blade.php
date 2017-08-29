@extends('layouts.app')
@include('vendor.ueditor.assets')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                {{$question->title}}
                @foreach($question->topics as $topic)
                    <a class="topic" href="/topics/{{ $topic->id }}">{{ $topic->name }}</a>
                @endforeach
                </div>
                <div class="panel-body">show
                    {!! $question->body !!}
                </div>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($question))
                        <span class="edit"><a href="/questions/{{ $question->id }}/edit">编辑</a></span>
                        <form action="/questions/{{ $question->id }}" class="delete-form" method="POS">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="button is-naked delete-button">删除</button>
                        </form>
                        @endif
                        <comment type="question" model="{{$question->id}}" count="{{$question->comments_count}}"></comment>
                    </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                {{$question->answers_count}}个答案
                </div>
                <div class="panel-body">
                    @foreach($question->answers as $answer)
                        <div class="media">
                            <div class="media-left">
                                <user-vote-button count="{{ $answer->votes_count }}" answer="{{ $answer->id }}"></user-vote-button>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="/questions/">{{ $answer->user->name }}</a></h4>
                                {!! $answer->body !!}
                            </div>
                            <comment type="answer" model="{{$answer->id}}" count="{{$answer->comments()->count()}}"></comment>
                        </div>
                    @endforeach
                    @if (Auth::check())
                    <form action="/questions/{{ $question->id }}/answer" method="post">
                        {{ csrf_field() }}
                        <!-- 编辑器容器 -->
                        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                            <label for="title">内容</label>
                            <script id="container" name="body" style="height: 200px" type="text/plain">{!! old('body') !!}</script>
                            @if ($errors->has('body'))
                            <span class="help-block">
                                <strong>{{ $errors->first('body') }}</strong>
                            </span>
                            @endif
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">提交答案</button>
                    </form>
                    @else
                        <a href="/login" class="btn btn-success btn-block">登录提交答案</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h2>
                        {{ $question->followers_count }}
                    </h2>
                    <span>关注者</span>
                </div>
                <div class="panel-body">
                @if (Auth::check())
                    <!-- <a href="/questions/{{$question->id}}/follow" class="btn btn-default {{ Auth::user()->isfollowed($question->id)?'btn-danger':'' }}">
                    {{ Auth::user($question->id)->isfollowed($question->id)?'取消关注':'关注' }}
                    </a> -->
                    <question-follow-button question="{{ $question->id }}"></question-follow-button>
                @else
                    <a href="/login" class="btn btn-success btn-default">请先登录</a>
                @endif
                    <a href="#container" class="btn btn-primary">撰写回答</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <span>关于作者</span>
                </div>
                <div class="panel-body">
                <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img width="36" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="">
                                        {{ $question->user->name }}
                                    </a>
                                </h4>
                            </div>
                            <div class="user-statics" >
                                <div class="statics-item text-center">
                                    <div class="statics-text">问题</div>
                                    <div class="statics-count">{{ $question->user->questions_count }}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">回答</div>
                                    <div class="statics-count">{{ $question->user->answers_count }}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">关注者</div>
                                    <div class="statics-count">{{ $question->user->followers_count }}</div>
                                </div>
                            </div>
                        </div>
                @if (Auth::check())
                    <user-follow-button user="{{ $question->user->id }}"></user-follow-button>
                    <user-message-button user="{{ $question->user->id }}"></user-message-button>
                @else
                    <a href="/login" class="btn btn-success btn-default">请先登录</a>
                @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container',
    {
        toolbars: [
        ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
        ],
        elementPathEnabled: false,
        enableContextMenu: false,
        autoClearEmptyNode:true,
        wordCount:false,
        imagePopup:false,
        autotypeset:{ indent: true,imageBlockLine: 'center' }
    }
        );
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
    });
</script>
@endsection
