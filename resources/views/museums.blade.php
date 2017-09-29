@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ Auth::user()->name }} - List of Pets</div>
                <div class="panel-body">
                    @if(isset($view))
                        @include('layouts.view_museums')
                    @else
                        @if(isset($edit))
                            @include('layouts.edit_museums')
                        @else
                            @include('layouts.form_museums')
                            @include('layouts.table_museums')
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection