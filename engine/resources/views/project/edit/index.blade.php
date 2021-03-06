@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Application Informations</div>

                <div class="panel-body">
                  <div class="text-center">
                    <img src="{{ asset('images/icon.png') }}" alt="{{$project['projectName']}} Icon" class="img-responsive">
                  </div>
                  <h3>{{ $project['projectName'] }}</h3>
                  <h4>Package Name: <code>{{ $project['projectPackageName'] }}</code></h4>
                  <h4>Version: <code>{{ $project['projectVersion'] }}</code></h4>
                  <h4>Description: <code>{{ $project['projectDescription'] }}</code></h4>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Edit</div>

                <div class="panel-body">
                  @include('project/import/upload')

                  <div class="">
                    <br>
                    <button class="btn btn-default btn-lg" >Compile Debug Packages</button>
                    <button class="btn btn-default btn-lg" >Download Packages</button>
                  </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
          <h2>Application Content</h2>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">XML Contents</div>

                <div class="panel-body">
                  <textarea class="form-control" rows="20" style="resize: none;">
                    @if( !empty($unit) )
                      {{ html_entity_decode($unit) }}
                    @endif
                  </textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Question Contents</div>

                <div class="panel-body">
                  <textarea class="form-control" rows="20" style="resize: none;">
                    @if( !empty($htmlQuestion) )
                      {{ html_entity_decode($htmlQuestion) }}
                    @endif
                  </textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
