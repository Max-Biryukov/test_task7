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
                            <div style="text-align: center;">
                                {{ $user->name }}
                            </div>

                        </div>

                        <table class="table table-bordered" style="width: 90%; margin: 0 auto">
                            <tr>
                                <td>
                                    @if( $user->id != \Auth::user()->id )
                                        <form action="{{ route( 'profile.add_comment', $user->id ) }}" method="post" >
                                            <textarea name="comment" style="width: 95%"></textarea>
                                            {{ csrf_field() }}
                                            <input type="submit" value="Добавить комментарий">
                                        </form>
                                    @endif
                                    @foreach( $user->profileComments as $author )

                                        <div style="margin: 8px 0 ">
                                            @if( !empty($author->avatar_id) )
                                                <div style="float:left">
                                                    <img src="{{ route( 'show_file', [ $author->avatar_id, 'small' ] ) }}" />
                                                </div>
                                            @endif
                                            <div>
                                                {{ $author->name }} {{ $author->pivot->created_at }}:<br>
                                                <b>{{ $author->pivot->comment }}</b>
                                            </div>
                                            <div style="clear: both" ></div>
                                        </div>

                                    @endforeach

                                </td>
                                <td>
                                    @if( !empty($rating) && $user->id != \Auth::user()->id )
                                        <form action="{{ route( 'profile.add_rating', $user->id ) }}" method="post" >
                                            <div class="star-rating">
                                                <div class="star-rating__wrap">

                                                    @foreach( $rating as $key => $value )

                                                        <input class="star-rating__input" id="star-rating-{{ $key }}" type="radio" name="rating" value="{{ $key }}" @if( $ratingForProfile == $key ) checked="checked" @endif >
                                                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-{{ $key }}" title="{{ $value }}"></label>

                                                    @endforeach
                                                </div>
                                            </div>
                                            {{ csrf_field() }}
                                            <input type="submit" value="@if( $ratingForProfile == 0 ) Задать рейтинг @else Изменить рейтинг @endif">
                                        </form>
                                    @endif

                                    @foreach( $user->profileRating as $author )

                                        <div style="margin: 8px 0 ">
                                            @if( !empty($author->avatar_id) )
                                                <div style="float:left">
                                                    <img src="{{ route( 'show_file', [ $author->avatar_id, 'small' ] ) }}" />
                                                </div>
                                            @endif
                                            <div>
                                                {{ $author->name }} {{ $author->pivot->created_at }}:<br>
                                                Поставил оценку <b>{{ $author->pivot->rating }}</b>
                                            </div>
                                            <div style="clear: both" ></div>
                                        </div>

                                    @endforeach

                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    @else
        <div>Пользователь не определен</div>
    @endif
</div>
@endsection

@section( 'css' )
    .star-rating{
        font-size: 0;
        text-align: center;
    }
    .star-rating__wrap{
        display: inline-block;
        font-size: 2rem;
    }
    .star-rating__wrap:after{
        content: "";
        display: table;
        clear: both;
    }
    .star-rating__ico{
        float: right;
        padding-left: 2px;
        cursor: pointer;
        color: #FFB300;
    }
    .star-rating__ico:last-child{
        padding-left: 0;
    }
    .star-rating__input{
        display: none;
    }
    .star-rating__ico:hover:before,
    .star-rating__ico:hover ~ .star-rating__ico:before,
    .star-rating__input:checked ~ .star-rating__ico:before
    {
        content: "\f005";
    }
@endsection
