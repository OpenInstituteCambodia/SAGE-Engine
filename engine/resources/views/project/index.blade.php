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
                  <div class="panel-heading">
                    My Projects
                    <span class="pull-right badge">{{ count($projects) }}</span>
                  </div>

                  <div class="panel-body">
                    <ul class="list-group">
                      @foreach($projects as $project)
                          <li class="list-group-item">
                            {{ $projectName = str_replace('projects/'.$userEmail.'/', '', $project) }}
                            <div class="pull-right">
                              <a class="btn btn-xs btn-info" href="{{ url('project/edit/'.$projectName) }}">Edit</a>
                              <a class="btn btn-xs btn-danger" href="{{ url('project/delete/'.$projectName) }}">Delete</a>
                            </div>
                          </li>
                      @endforeach
                    </ul>
                  </div>
              </div>
          </div>
        @endif
    </div>
</div>
@endsection
