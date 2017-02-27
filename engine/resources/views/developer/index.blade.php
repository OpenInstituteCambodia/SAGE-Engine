@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
          <h2>Developer Console</h2><br>
        </div>

        @include('developer.xml.import.upload')
        @include('developer.templates.import.update')

    </div>
</div>
@endsection

@section('js')
  <script src="{{ asset('js/template.update.js') }}"></script>
@endsection
