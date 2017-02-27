@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">XML Validator</div>

                <div class="panel-body">
                    @include('developer.xml.import.upload')
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Template Version</div>

                <div class="panel-body">
                    @include('developer.templates.import.update')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
