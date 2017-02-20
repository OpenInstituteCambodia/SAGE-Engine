@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <!-- You are logged in! -->

                    <form class="form" action="/" method="post">
                      <div class="form-group">
                        <label for="">XML template</label>
                        <input class="form-control" type="file" name="" value="">
                      </div>

                      <button type="submit" name="button">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
