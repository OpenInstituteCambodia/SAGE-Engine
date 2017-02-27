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
          url: "https://api.github.com/repos/"+info["GITHUB_APP_OWNER"]+"/"+info["GITHUB_APP_REPO"]+"/tags",
          method: 'GET',
          data: {
            client_id: info['GITHUB_APP_ID'],
            client_secret: info['GITHUB_APP_SECRET'],
          }
        }).done(
          (git) => {
            var list = $('[templateList]');
            for (var i = 0; i < git.length; i++) {
              var content =
                '<a templateID='+git[i].name+' href="'+git[i].zipball_url+'" class="list-group-item">' +
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
              $('a[templateID="'+info['active']+'"]').addClass('active');
            }
        });
      }
    );

  } // github()
});
