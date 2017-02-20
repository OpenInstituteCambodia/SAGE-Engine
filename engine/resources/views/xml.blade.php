@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-heading">Dashboard</div>

                  <div class="panel-body">
                    <code>
                      @if( !empty($xpath) )
                        @for($i = 0; $i <= $xpath->query('/elements/unit')->length; $i++ )
                          {{ $xpath->evaluate('string(/elements/unit['.$i.']/@id)') }}
                          {{ $xpath->evaluate('string(/elements/unit['.$i.'])') }}
                          <br>
                        @endfor
                      @endif
                    </code>
                  </div>
              </div>
          </div>

      </div>
  </div>
@endsection
