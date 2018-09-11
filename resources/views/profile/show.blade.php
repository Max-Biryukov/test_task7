@extends('layouts.app')

@section('content')
<div class="container">
    @if( !empty($user) )
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Информация о пользователе</div>

                    <div class="panel-body">

                        <div style="margin-top: 10px; text-align: center; border-bottom: 1px solid #d3e0e9; padding: 8px 0">

                            @if( !empty($user->avatar_id) )
                                <div>
                                    <img src="{{ route( 'show_file', [ $user->avatar_id, 'medium' ] ) }}" />
                                </div>
                            @endif
                            <div style="text-align: justify;">
                                {{ $ad->text }}
                            </div>
                            <div style="text-align: left; font-size: 12px; font-style:italic">
                                Добавлено пользователем: <a target="_blank" href="{{ route('profile.show', $ad->user_id) }}">{{ $ad->user->name }}</a>
                            </div>
                        </div>

                        <form action="{{ route( 'profile.update', \Auth::id() ) }}" method="post" enctype="multipart/form-data" >
                            <table class="table table-bordered" style="width: 70%; margin: 0 auto">
                                <tr>
                                    <td>Аватар</td>
                                    <td>
                                        @if( !empty($user->avatar_id) )
                                            <img src="{{ route( 'show_file', [ $user->avatar_id, 'small' ] ) }}" />
                                        @endif
                                        <input type="file" name="avatar">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Имя*</td>
                                    <td>
                                        <input style="width: 95%" type="text" name="name" value="{{ $user->name }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Обо мне</td>
                                    <td>
                                        <textarea name="about" style="width: 95%">{{ $user->about }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right">
                                        {{ method_field( 'PATCH' ) }}
                                        {{ csrf_field() }}
                                        <input type="submit" value="Сохранить">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div>Пользователь не определен</div>
    @endif
</div>
@endsection
