@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">控制面板</div>
                <div class="panel-body">
                    <form action="/password/update" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="password1" class="col-md-4 control-label">请输入旧密码</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" name="old_password">
                                @if ($errors->has('old_password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password1" class="col-md-4 control-label">请输入新密码</label>
                            <div class="col-md-8">
                            <input type="password" class="form-control" name="password">
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password1" class="col-md-4 control-label">请再输入一次新密码</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                            @if ($errors->has('password-confirm'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password-confirm') }}</strong>
                                </span>
                            @endif
                        </div>
                            <button class="col-md-8 col-md-offset-4 btn btn-success" type="submit">提交</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
