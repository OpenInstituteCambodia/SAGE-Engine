@extends('layouts.app')

@section('content')
  <div class="container-fluid">
      <div class="row">
        @if( !empty($xPath) )
          <div class="col-md-12">
              <div class="panel panel-default">
                  <div class="panel-heading">XML Contents</div>

                  <div class="panel-body">
                    <!-- Table -->
                      @for($i = 1; $i <= $xPath->query($rootElement)->length; $i++ )
                        <h3>Element: <code>{{$i}}</code> - Unit ID: <code>{{ $xPath->evaluate('string('.$rootElement.'['.$i.']/@id)') }}</code> Style: <code>{{ $xPath->evaluate('string('.$rootElement.'['.$i.']/@style)') }}</code></h3>
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
                              <td><code>{{ $xPath->evaluate('string('.$rootElement.'['.$i.']/@id)') }}</code></td>
                            </tr>
                            @if( !empty($xPath->evaluate('string('.$rootElement.'['.$i.']/text)')) )
                              <tr>
                                <td><code>{{ html_entity_decode('<text></text>') }}</code></td>
                                <td><code>@{{placeholder_text}}</code></td>
                                <td><code>{{ $xPath->evaluate('string('.$rootElement.'['.$i.']/text)') }}</code></td>
                              </tr>
                            @endif
                            <tr>
                              <td><code>{{ html_entity_decode('<pre-audio></pre-audio>') }}</code></td>
                              <td><code>@{{placeholder_pre_audio}}</code></td>
                              <td><code>{{ $xPath->evaluate('string('.$rootElement.'['.$i.']/pre-audio)') }}</code></td>
                            </tr>
                            @if( !empty($xPath->evaluate('string('.$rootElement.'['.$i.']/audio)')) )
                              <tr>
                                <td><code>{{ html_entity_decode('<audio></audio>') }}</code></td>
                                <td><code>@{{placeholder_audio}}</code></td>
                                <td><code>{{ $xPath->evaluate('string('.$rootElement.'['.$i.']/audio)') }}</code></td>
                              </tr>
                            @endif
                            @for($c = 1; $c <= $xPath->query($rootElement.'['.$i.']/choice')->length; $c++ )
                              <tr>
                                <td><code>{{ html_entity_decode('<choice id='.$c.'>') }}</code></td>
                                <td></td>
                                <td></td>
                              </tr>
                              @if( !empty($xPath->evaluate('string('.$rootElement.'['.$i.']/choice['.$c.']/text)')) )
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>{{ html_entity_decode('<text></text>') }}</code></td>
                                  <td><code>placeholder_choice_{{$c}}_text</code></td>
                                  <td><code>{{ $xPath->evaluate('string('.$rootElement.'['.$i.']/choice['.$c.']/text)') }}</code></td>
                                </tr>
                              @endif
                              @if( !empty($xPath->evaluate('string('.$rootElement.'['.$i.']/choice['.$c.']/image)')) )
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>{{ html_entity_decode('<image></image>') }}</code></td>
                                  <td><code>placeholder_choice_{{$c}}_image</code></td>
                                  <td><code>{{ $xPath->evaluate('string('.$rootElement.'['.$i.']/choice['.$c.']/image)') }}</code></td>
                                </tr>
                              @endif
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>{{ html_entity_decode('<audio></audio>') }}</code></td>
                                <td><code>placeholder_choice_{{$c}}_audio</code></td>
                                <td><code>{{ $xPath->evaluate('string('.$rootElement.'['.$i.']/choice['.$c.']/audio)') }}</code></td>
                              </tr>
                              <tr>
                                <td><code>{{ html_entity_decode('<choice>') }}</code></td>
                                <td></td>
                                <td></td>
                              </tr>
                            @endfor
                            <tr>
                              <td><code>{{ html_entity_decode('<correct></correct>') }}</code></td>
                              <td><code>@{{placeholder_correct}}</code></td>
                              <td><code>{{ $xPath->evaluate('string('.$rootElement.'['.$i.']/correct)') }}</code></td>
                            </tr>
                            <tr>
                              <td><code>{{ html_entity_decode('<correct_answer></correct_answer>') }}</code></td>
                              <td><code>@{{placeholder_correct_answer}}</code></td>
                              <td><code>{{ $xPath->evaluate('string('.$rootElement.'['.$i.']/correct_answer)') }}</code></td>
                            </tr>
                            <tr>
                              <td><code>{{ html_entity_decode('<wrong_answer></wrong_answer>') }}</code></td>
                              <td><code>@{{placeholder_wrong_answer}}</code></td>
                              <td><code>{{ $xPath->evaluate('string('.$rootElement.'['.$i.']/wrong_answer)') }}</code></td>
                            </tr>
                            <tr>
                              <td><code>{{ html_entity_decode('<next></next>') }}</code></td>
                              <td><code>@{{placeholder_next}}</code></td>
                              <td><code>{{ $xPath->evaluate('string('.$rootElement.'['.$i.']/next)') }}</code></td>
                            </tr>
                          </tbody>
                        </table>
                      @endfor
                  </div>
              </div>
            </div>
          @endif

          <div class="col-md-12">
              <div class="panel panel-default">
                  <div class="panel-heading">HTML Rendered</div>

                  <div class="panel-body">
                    <textarea class="form-control" rows="20" style="resize: none;">
                      @if( !empty($htmlTemplate) )
                        {{ html_entity_decode($htmlTemplate) }}
                      @endif
                    </textarea>

                  </div>
              </div>
          </div>

      </div>
  </div>
@endsection
