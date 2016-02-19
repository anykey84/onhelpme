@extends('layouts.app')


@section('content')
    <div class="panel panel-default" ng-controller="adminIndexController">
        <div class="panel-heading">Admin</div>

        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>Последний вход: 25.03.2015г</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Последний IP адрес входа: 123.123.123.123</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Архивация данных: @{{ buttons.archiveCopy.lastCopy }} </td>
                    <td><button class="btn btn-primary btn-block"
                        ng-class="{disabled: buttons.archiveCopy.disabled}" id="button1"
                        ng-click="pressButton('archiveCopy')">@{{ buttons.archiveCopy.buttonText }}</button></td>
                </tr>
                <tr>
                    <td>Рекурсивное копирование: @{{ buttons.recursiveCopy.lastCopy }}</td>
                    <td><button class="btn btn-primary btn-block" id="button2"
                        ng-class="{disabled: buttons.recursiveCopy.disabled}"
                        ng-click="pressButton('recursiveCopy')">@{{ buttons.recursiveCopy.buttonText }}</button></td>
                </tr>
                <tr>
                    <td>Копирование баз данных: @{{ buttons.dbCopy.lastCopy }}</td>
                    <td><button class="btn btn-primary btn-block" id="button3"
                        ng-class="{disabled: buttons.dbCopy.disabled}"
                        ng-click="pressButton('dbCopy')">@{{ buttons.dbCopy.buttonText }}</button></td>
                </tr>
            </table>
        </div>
    </div>
@endsection
