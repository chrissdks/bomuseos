@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ Auth::user()->name }} - Artefactos</div>
                <div class="panel-body">
                    @if(isset($view))
                        @include('layouts.view_artifacts')
                    @else
                        @if(isset($edit))
                            @include('layouts.edit_artifacts')
                        @else
                            @include('layouts.form_artifacts')
                            @include('layouts.table_artifacts')

                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection