@extends('layouts.app')

@section('content')
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="panel panel-default">
                  <div class="panel-heading">XML Contents</div>

                  <div class="panel-body">
                    <!-- Table -->
                    @if( !empty($xpath) )
                      @for($i = 1; $i <= $xpath->query('/elements/unit')->length; $i++ )
                        <h3>{{ $xpath->evaluate('string(/elements/unit['.$i.']/@id)') }}</h3>
                        <table class="table">
                          <thead>
                            <tr>
                              <th width="35%">XML Key</th>
                              <th width="35%">HTML Key</th>
                              <th width="30%">Value</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td><code>{{ html_entity_decode('<unit id="">') }}</code></td>
                              <td><code>@{{placeholder_unit_id}}</code></td>
                              <td><code>{{ $xpath->evaluate('string(/elements/unit['.$i.']/@id)') }}</code></td>
                            </tr>
                            <tr>
                              <td><code>{{ html_entity_decode('<pre-audio></pre-audio>') }}</code></td>
                              <td><code>@{{placeholder_pre-audio}}</code></td>
                              <td><code>{{ $xpath->evaluate('string(/elements/unit['.$i.']/pre-audio)') }}</code></td>
                            </tr>
                            <tr>
                              <td><code>{{ html_entity_decode('<audio></audio>') }}</code></td>
                              <td><code>@{{placeholder_audio}}</code></td>
                              <td><code>{{ $xpath->evaluate('string(/elements/unit['.$i.']/audio)') }}</code></td>
                            </tr>
                          </tbody>
                        </table>
                      @endfor
                    @endif
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
