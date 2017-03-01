$(document).ready(function(){
  github();

  // Function
  function github() {

    // Get Active Template
    $.ajax({
      url: "/developer/template/info"
    }).done(
      (info) => {
        info = JSON.parse(info);
        $.ajax({
          url: "/developer/template/update",
          method: 'GET'
        }).done(
          (git) => {
            git = JSON.parse(git);
            var list = $('[templateList]');
            for (var i = 0; i < git.length; i++) {
              var content =
                '<a templateID='+git[i].name+' href="/developer/template/set/'+git[i].name+'" class="list-group-item">' +
                  '<h4 class="list-group-item-heading">' +
                    git[i].name +
                  '</h4>' +
                  '<p class="list-group-item-text">' +
                    'Commit: ' + git[i].commit.sha +
                  '</p>' +
                '</a>';
              if (git[i].name == 'latest') {
                $(list).prepend(content);
              }else {
                $(list).append(content);
              }
            }
            $('a[templateID="'+info['active']+'"]').addClass('active');
            $('a[templateID="'+info['active']+'"] > .list-group-item-heading').append('&nbsp;<span class="badge" style="background-color: #fff; color: #000;">In Use</span>');
        });
      }
    );

  } // github()
});
