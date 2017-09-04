@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">消息列表</div>

                <div class="panel-body">
                    @foreach($messages as $messageGroup)
                    @php
                    $flag = $messageGroup->every(function($item){
                        if (user()->id == $item->from_user_id) {
                        return true;
                        }
                        return $item->has_read == 'T';
                    });
                    @endphp
                        <div class="media {{ $flag ? '' : 'unread' }}">

                            <div class="media-left">
                                <a href="">
                                    @if($messageGroup->last()->fromUser->id == user()->id)
                                    <img src="{{ $messageGroup->last()->toUser->avatar }}" alt="" class="media-boject" width="24px">
                                    @else
                                    <img src="{{ $messageGroup->last()->fromUser->avatar }}" alt="" class="media-boject" width="24px">
                                    @endif
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                @if($messageGroup->last()->fromUser->id == user()->id)
                                {{ $messageGroup->last()->toUser->name }}
                                @else
                                {{ $messageGroup->last()->fromUser->name }}
                                @endif
                                </h4>
                                <p>
                                <a href="/inbox/{{ $messageGroup->last()->dialog_id }}">
                                    {{ $messageGroup->last()->body }}
                                </a>
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
