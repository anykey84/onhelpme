@extends('layouts.app')

@section('content')
            <div class="panel panel-default">
                <div class="panel-heading">Главная</div>

                <div class="panel-body">
                    @if (Auth::guest())
                        Этот текст виден всем
                    @else
                        Этот текст виден всем<br>
                        Этот текст виден только авторизованным пользователям
                    @endif
                </div>
            </div>
@endsection
