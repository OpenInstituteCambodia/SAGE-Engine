<div class="panel-body">
    <form class="form" action="/xmlparser" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="">XML template</label>
        <input class="form-control" type="file" name="xmlfile" value="">
      </div>

      <button class="btn btn-success" type="submit" name="button">Submit</button>
    </form>

</div>

@if( !empty($xml) )
  {{ $xml }}
@endif
