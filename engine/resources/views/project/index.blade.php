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
                            {{ str_replace('projects/'.$currentUser.'/', '', $project) }}
                            <button class="btn btn-sm btn-default" type="button" name="edit">Edit</button>
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
