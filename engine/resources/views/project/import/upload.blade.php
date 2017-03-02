<form class="form" action="{{ url('project/upload') }}" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="">XML Template</label>
    <input class="form-control" type="file" name="xmlfile">
  </div>
  <!-- <div class="form-group">
    <label for="">Resources</label>
    <input class="form-control" type="file" name="xmlresources" webkitdirectory mozdirectory msdirectory odirectory directory multiple>
  </div> -->

  {{ csrf_field() }}
  <input class="form-control" type="hidden" name="projectName" value="{{ $project['projectName'] }}">
  <button class="btn btn-primary" type="submit" name="button">Upload</button>
</form>
