$(document).ready(function(){
  github();

  $('#templateUpdate').on('click', (event) => {
    $('[templateList]').empty();
    github();
  });

  // Function
  function github() {
    // Get Active Template
    $.ajax({
      url: "/developer/template/info"
    }).done(
      (info) => {
        info = JSON.parse(info);
        $.ajax({
          url: "/developer/template/releases",
          method: 'GET'
        }).done(
          (git) => {
            git = JSON.parse(git);
            var list = $('[templateList]');
            for (var i = 0; i < git.length; i++) {
              var commit = git[i].body.replace(/(\r\n|\n|\r)/gm, "<br />");
              var content =
                '<a templateID='+git[i].tag_name+' href="/developer/template/set/'+git[i].tag_name+'" class="list-group-item">' +
                  '<h4 class="list-group-item-heading">' +
                    git[i].name +
                  '</h4>' +
                  '<p class="list-group-item-text">' +
                    commit +
                    '<br>' +
                  '</p>' +
                '</a>';
              if (git[i].name == 'latest') {
                $(list).prepend(content);
              }else {
                $(list).append(content);
              }
            }
            $('a[templateID="'+info['active']+'"]').addClass('active');
            $('a[templateID="'+info['active']+'"] > .list-group-item-heading').append('&nbsp;<span class="pull-right badge" style="font-size: 12px; background-color: #fff; color: #000;">In Use <span class="glyphicon glyphicon-ok"></span></span>');
        });
      }
    );

  } // github()
});
