@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ route('ads.create') }}">Добавить объявлние</a>
                </div>

                <div class="panel-body">
                    @if( !empty($ads) )
                        @foreach( $ads as $ad )
                            <div style="margin-top: 10px; text-align: center; border-bottom: 1px solid #d3e0e9; padding: 8px 0">

                                @if( !empty($ad->picture_id) )
                                    <div>
                                        <img src="{{ route( 'show_file', [ $ad->picture_id, 'medium' ] ) }}" />
                                    </div>
                                @endif
                                <div style="text-align: justify;">
                                    {{ $ad->text }}
                                </div>
                                <div style="text-align: left; font-size: 12px; font-style:italic">
                                    Добавлено пользователем: <a target="_blank" href="{{ route('profile.show', $ad->user_id) }}">{{ $ad->user->name }}</a> {{ $ad->created_at }}
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <div style="text-align: center">
                        {{ $ads->render() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
