@extends('layouts.app')

@section('content')
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="panel panel-default">
                  <div class="panel-heading">XML Contents</div>

                  <div class="panel-body">
                    <!-- Table -->
                    <table class="table">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>XML Key</th>
                          <th>XML Value</th>
                          <th>HTML Key<th>
                          <th>HTML Value</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if( !empty($xpath) )
                          @for($i = 0; $i <= $xpath->query('/elements/unit')->length; $i++ )
                            <tr>
                              <td>{{ $xpath->evaluate('string(/elements/unit['.$i.']/@id)') }}</td>
                              <td>{{ $xpath->evaluate('string(/elements/unit['.$i.'])') }}</td>
                            </tr>
                          @endfor
                        @endif
                      </tbody>
                    </table>
                  </div>
              </div>
          </div>

          <div class="col-md-12">
              <div class="panel panel-default">
                  <div class="panel-heading">HTML Rendered</div>

                  <div class="panel-body">
                    <pre>
                      @if( !empty($template_m1) )
                        {{ html_entity_decode($template_m1) }}
                      @endif
                    </pre>

                  </div>
              </div>
          </div>

      </div>
  </div>
@endsection
