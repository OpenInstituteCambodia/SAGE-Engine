<form class="form" action="{{ url('developer/xml/validator') }}" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="">XML template</label>
    <input class="form-control" type="file" name="xmlfile" value="">
  </div>

  {{ csrf_field() }}
  <button class="btn btn-success" type="submit" name="button">Submit</button>
</form>
