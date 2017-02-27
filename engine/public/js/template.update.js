$(document).ready(function(){
  $.ajax({
    url: "https://api.github.com/repos/socheatsok78/SAGE-Template/zipball/master"
  }).done((suc) => {
    console.log(suc);
  });
});
