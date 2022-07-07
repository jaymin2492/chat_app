@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header font-bold bg-red-900 text-white">{{ __('Chat') }}</div>

                <div class="card-body row">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="col-sm-12 user_list_panel">
                        <div class="user_list">
                            <ul class="list-group">
                                @foreach ($users as $user)
                                <li class="list-group-item mb-3 border-1" data-user-id="{{ $user->id }}">{{ $user->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8 user_chat_panel">
                        <div class="panel panel-default">
                            <div class="panel-body">

                            </div>
                            <div class="panel-footer">
                                <form action="<?php echo URL('chat/user'); ?>" method="post" id="chat_form" class="form-horizontal row">
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control bg-blue-100" id="message" name="message" placeholder="Type your mesage here...">
                                    </div>
                                    <div class="col-sm-offset-2 col-sm-2">
                                        <button type="submit" class="btn bg-red-900 text-white">Send</button>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection