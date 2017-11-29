document.onreadystatechange = function () {

   if (document.readyState == "complete") {
     $( "#nicknameBtn" ).on( "click", function() {
        localStorage.setItem("user",$( "#nickname" ).val());

        localStorage.setItem("start",true);
        localStorage.setItem("playMode",$('input[name="mode"]:checked').val());
        window.location = './playPage.html';
      });

  }
 }
