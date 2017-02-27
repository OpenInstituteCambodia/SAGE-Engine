$(document).ready(function(){
  github();

  // Function
  function github() {
    $.ajax({
      url: "https://api.github.com/repos/socheatsok78/SAGE-Template/tags",
      method: 'GET',
      data: {
        login: 'socheatsok78',
        token: 'bb0c2c59ff0a01cafbdb8bd358a89248479f3b48',
      }
    }).done((suc) => {
      var list = $('[templateList]');
      for (var i = 0; i < suc.length; i++) {
        var content =
          '<a href="'+suc[i].zipball_url+'" class="list-group-item">' +
            '<h4 class="list-group-item-heading">' +
              suc[i].name +
            '</h4>' +
            '<p class="list-group-item-text">' +
              'Commit: ' + suc[i].commit.sha +
            '</p>' +
          '</a>';
        if (suc[i].name == 'latest') {
          $(list).prepend(content);
        }else {
          $(list).append(content);
        }
      }
    });
  }
});
