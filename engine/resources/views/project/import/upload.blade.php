<form class="form" action="{{ url('project/upload') }}" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="">XML Template</label>
    <input class="form-control" type="file" name="xmlfile">
    <input class="form-control" type="hidden" name="projectName" value="{{ $project['projectName'] }}">
  </div>

  {{ csrf_field() }}
  <button class="btn btn-primary" type="submit" name="button">Upload</button>
</form>
