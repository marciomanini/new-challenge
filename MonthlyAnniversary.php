<?php
  include_once("util/menu.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="description" content="Monthly Anniversary">
  <meta name="author" content="Marcio Manini">

  <script type="text/javascript" src="js/jquery.js"></script>

  <link href="css/style.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
        type: "POST",
        url: "controller/conContact.php?action=getMonthyAnniversary",
        success: function(answer) {
          var data = JSON.parse(answer);
          var content = '<thead>' +
                          '<tr>' +
                            '<th>Name</th>' +
                            '<th>Birthday Date</th>' +
                          '</tr>' +
                        '</thead>' +
                        '<tbody>';
          for(var i = 0; i < data.length; i++){
            var tr_today;
            var age;
            
            if(data[i]['today'] === '1'){
              tr_today = '<tr class="today">';
              age = ' - ' +  (data[i]['current_year'] - data[i]['year']) + ' year(s) old';
            }
            else{
              tr_today = '<tr>';
              age = '';
            }

              content +=
              tr_today +
                '<td>' + data[i]['name'] + age + '</td>' +
                '<td>' + data[i]['birthday'] + '</td>' +
              '</tr>';
          }
          content += '</tbody>';
          $('#table_anniversary').html(content);
        }
      });
    });
  </script>

</head>
<body>
  <div class="container theme-showcase">
    <table class="table table-bordered" id="table_anniversary">
    </table>
  </div>
</body>
</html>