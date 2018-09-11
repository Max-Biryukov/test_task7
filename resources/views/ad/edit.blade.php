@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Создание объявления</div>

                <div class="panel-body">
                    <form action="{{ route( 'ads.store' ) }}" method="post" enctype="multipart/form-data" >
                        <table class="table table-bordered" style="width: 70%; margin: 0 auto">
                            <tr>
                                <td>Картинка</td>
                                <td>
                                    @if( !empty($user->avatar_id) )
                                        <img src="{{ route( 'show_file', [ $user->avatar_id, 'small' ] ) }}" />
                                    @endif
                                    <input type="file" name="picture">
                                </td>
                            </tr>
                            <tr>
                                <td>Текст*</td>
                                <td>
                                    <textarea name="text" style="width: 95%"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right">
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
</div>
@endsection
