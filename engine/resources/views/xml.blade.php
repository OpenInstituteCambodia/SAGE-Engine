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
                        <h3>Element ID: <code>{{ $xpath->evaluate('string(/elements/unit['.$i.']/@id)') }}</code></h3>
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
                            @if( !empty($xpath->evaluate('string(/elements/unit['.$i.']/audio)')) )
                              <tr>
                                <td><code>{{ html_entity_decode('<audio></audio>') }}</code></td>
                                <td><code>@{{placeholder_audio}}</code></td>
                                <td><code>{{ $xpath->evaluate('string(/elements/unit['.$i.']/audio)') }}</code></td>
                              </tr>
                            @endif
                            @for($c = 1; $c <= $xpath->query('/elements/unit['.$i.']/choice')->length; $c++ )
                              @if( !empty($xpath->evaluate('string(/elements/unit['.$i.']/choice['.$c.']/text)')) )
                                <tr>
                                  <td><code>{{ html_entity_decode('<choice id='.$c.'><text></text>') }}</code></td>
                                  <td><code>placeholder_choice_{{$c}}_text</code></td>
                                  <td><code>{{ $xpath->evaluate('string(/elements/unit['.$i.']/choice['.$c.']/text)') }}</code></td>
                                </tr>
                              @endif
                              @if( !empty($xpath->evaluate('string(/elements/unit['.$i.']/choice['.$c.']/image)')) )
                                <tr>
                                  <td><code>{{ html_entity_decode('<choice id='.$c.'><image></image>') }}</code></td>
                                  <td><code>placeholder_choice_{{$c}}_image</code></td>
                                  <td><code>{{ $xpath->evaluate('string(/elements/unit['.$i.']/choice['.$c.']/image)') }}</code></td>
                                </tr>
                              @endif
                              <tr>
                                <td><code>{{ html_entity_decode('<choice id='.$c.'><audio></audio>') }}</code></td>
                                <td><code>placeholder_choice_{{$c}}_audio</code></td>
                                <td><code>{{ $xpath->evaluate('string(/elements/unit['.$i.']/choice['.$c.']/audio)') }}</code></td>
                              </tr>
                            @endfor
                            <tr>
                              <td><code>{{ html_entity_decode('<correct></correct>') }}</code></td>
                              <td><code>@{{placeholder_correct}}</code></td>
                              <td><code>{{ $xpath->evaluate('string(/elements/unit['.$i.']/correct)') }}</code></td>
                            </tr>
                            <tr>
                              <td><code>{{ html_entity_decode('<correct_answer></correct_answer>') }}</code></td>
                              <td><code>@{{placeholder_correct_answer}}</code></td>
                              <td><code>{{ $xpath->evaluate('string(/elements/unit['.$i.']/correct_answer)') }}</code></td>
                            </tr>
                            <tr>
                              <td><code>{{ html_entity_decode('<wrong_answer></wrong_answer>') }}</code></td>
                              <td><code>@{{placeholder_wrong_answer}}</code></td>
                              <td><code>{{ $xpath->evaluate('string(/elements/unit['.$i.']/wrong_answer)') }}</code></td>
                            </tr>
                            <tr>
                              <td><code>{{ html_entity_decode('<next></next>') }}</code></td>
                              <td><code>@{{placeholder_next}}</code></td>
                              <td><code>{{ $xpath->evaluate('string(/elements/unit['.$i.']/next)') }}</code></td>
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
