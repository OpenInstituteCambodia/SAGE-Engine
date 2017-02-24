@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Create New Project</div>

                <div class="panel-body">
                    @include('project.import.create')
                </div>
            </div>
        </div>
        @if(!empty($projects))
          <div class="col-md-8">
              <div class="panel panel-default">
                  <div class="panel-heading">Project List</div>

                  <div class="panel-body">
                    <ul class="list-group">
                      @foreach($projects as $project)
                          <li class="list-group-item">
                            {{ $projectName = str_replace('projects/'.$currentUser.'/', '', $project) }}
                            <div class="pull-right">
                              <a class="btn btn-xs btn-default" href="{{ url('project/edit/'.$projectName) }}">Edit</a>
                              <a class="btn btn-xs btn-danger" href="{{ url('project/delete/'.$projectName) }}">Delete</a>
                            </div>
                          </li>
                      @endforeach
                    </ul>
                  </div>
              </div>
          </div>
        @endif




        <!-- Standard button -->
        <button type="button" class="btn btn-default">Default</button>

        <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
        <button type="button" class="btn btn-primary">Primary</button>

        <!-- Indicates a successful or positive action -->
        <button type="button" class="btn btn-success">Success</button>

        <!-- Contextual button for informational alert messages -->
        <button type="button" class="btn btn-info">Info</button>

        <!-- Indicates caution should be taken with this action -->
        <button type="button" class="btn btn-warning">Warning</button>

        <!-- Indicates a dangerous or potentially negative action -->
        <button type="button" class="btn btn-danger">Danger</button>

        <!-- Deemphasize a button by making it look like a link while maintaining button behavior -->
        <button type="button" class="btn btn-link">Link</button>



    </div>
</div>
@endsection
