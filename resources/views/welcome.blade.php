@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Создание резервной копии</div>

                <div class="panel-body">
                    {{ $output }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
