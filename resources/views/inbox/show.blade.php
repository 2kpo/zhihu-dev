@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">消息列表</div>

                <div class="panel-body">
                <form action="/inbox/{{$messages->first()->dialog_id}}/store" class="">

                </form>
                    @foreach($messages as $message)
                        <div class="media">
                            <div class="media-left">
                                <a href="">
                                    <img src="{{ $message->fromUser->avatar }}" alt="" class="media-boject" width="24px">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                {{ $message->fromUser->name }}
                                </h4>
                                <p>
                                    {{ $message->body }}
                                    <span class="pull-right">{{ $message->created_at->format('Y-m-d H:i:m') }}</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
