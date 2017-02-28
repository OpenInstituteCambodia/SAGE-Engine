<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">XML Validator</div>

        <div class="panel-body">
          <form class="form" action="{{ url('developer/xml/validator') }}" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="">XML template</label>
              <input class="form-control" type="file" name="xmlfile" value="">
            </div>

            {{ csrf_field() }}
            <button class="btn btn-success" type="submit" name="button">Submit</button>
          </form>
        </div>
    </div>
</div>
