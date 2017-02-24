@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Application Informations</div>

                <div class="panel-body">
                  <div class="text-center">
                    <img src="{{ asset('images/icon.png') }}" alt="{{$projectName}} Icon" class="img-responsive">
                  </div>
                  <h3>{{$projectName}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Configuration</div>

                <div class="panel-body">
                  @include('project/import/upload')
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Contents</div>

                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
