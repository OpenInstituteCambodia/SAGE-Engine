<form action="{{ url('project/create') }}" method="post">
  <div class="form-group">
    <label for="projectName">Project Name</label>
    <input class="form-control" type="text" name="projectName" placeholder="Project Name Random">
  </div>
  <div class="form-group">
    <label for="projectVersion">Version</label>
    <input class="form-control" type="text" name="projectVersion" placeholder="1.0.0">
  </div>
  <div class="form-group">
    <label for="projectPackageName">Package Name</label>
    <input class="form-control" type="text" name="projectPackageName" placeholder="eg. org.open.kh.self-ivr">
  </div>
  <div class="form-group">
    <label for="projectDescription">Description</label>
    <textarea class="form-control" rows="3" name="projectDescription" placeholder="A short description about you application." style="resize: vertical;"></textarea>
  </div>

  {{ csrf_field() }}
  <button type="submit" class="btn btn-primary">
    Submit
  </button>
</form>
