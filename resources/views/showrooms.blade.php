@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ Auth::user()->name }} - Lista de salas de museo</div>
                <div class="panel-body">
                    @if(isset($view))
                        @include('layouts.view_showrooms')
                    @else
                        @if(isset($edit))
                            @include('layouts.edit_showrooms')
                        @else
                            @include('layouts.form_showrooms')
                            @include('layouts.table_showrooms')
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection