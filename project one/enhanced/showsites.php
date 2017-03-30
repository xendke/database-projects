<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue_grey-light_green.min.css" />
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  <link rel="stylesheet" href="https://cdn.rawgit.com/MEYVN-digital/mdl-selectfield/master/mdl-selectfield.min.css">
  <script defer src="https://cdn.rawgit.com/MEYVN-digital/mdl-selectfield/master/mdl-selectfield.min.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script>
  var delete_bookmarks = function () {
    var username = localStorage.getItem('user');
    var selected = document.querySelectorAll('tr.is-selected');
    var target_ids = [];
    for (var x = 0; x < selected.length; x++) {
      var id = selected[x].getAttribute('data-id');
      target_ids.push(id);
    }
    if(target_ids.length < 1) {
      return;
    }
    console.log(target_ids);
    console.log(username);
    axios.post('/project1/enhanced/delete.php', { // send list of ids to delete.php
      targets: target_ids,
      user: username
    })
    .then(function (response) {
      if(response.data==1) { // remove rows
        for (var x = 0; x < selected.length; x++) {
          selected[x].parentNode.removeChild(selected[x]);
        }
      }
    })
    .catch(function (error) {
      console.log(error);
    });
  }
  </script>
</head>
<body>
  <!-- Always shows a header, even in smaller screens. -->
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
      <div class="mdl-layout__header-row">
        <!-- Title -->
        <span class="mdl-layout-title"><a href="index.php" style="color: white; text-decoration: none; font-weight: normal;">Bookmarker</a></span>
        <!-- Add spacer, to align navigation to the right -->
        <div class="mdl-layout-spacer"></div>
        <!-- Navigation. We hide it in small screens. -->
        <nav class="mdl-navigation mdl-layout--large-screen-only">
          <a class='mdl-navigation__link' href='login.php?logout=1'>Log Out</a>
        </nav>
      </div>
    </header>
    <div class="mdl-layout__drawer">
      <span class="mdl-layout-title">Bookmarker</span>
      <nav class="mdl-navigation">
        <a class='mdl-navigation__link' href='index.php'>Home</a>
        <a class='mdl-navigation__link' href='addsite.php'>New Bookmark</a>
        <a class='mdl-navigation__link' href='login.php?logout=1'>Log Out</a>
      </nav>
    </div>
    <main class="mdl-layout__content">
      <div class="page-content" style="margin: auto; width: 50%; padding: 20px 0;">

        <?php

        $username = $_SESSION['user'];
        require('database.php');
        if(!empty($username)) {
          $title = "My Bookmarks";
          $query = "SELECT id FROM users WHERE username='$username' LIMIT 1";
          $user_record = mysqli_query($conn, $query);
          $user_id = mysqli_fetch_array($user_record);
          $user_id = $user_id['id'];
          $query = "SELECT id, title, url, description, category, date_added FROM bookmarks WHERE user_id=$user_id";
          $delete_button = "<button onclick='delete_bookmarks()' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent' style='width: 100%;'>Delete</button>";
          $selectable = "--selectable";
        } else {
          $title = "Public Bookmarks";
          $query = "SELECT b.title, b.url, b.category, b.description FROM bookmarks as b RIGHT JOIN public_bookmarks as pb ON b.id=pb.bookmark_id";
          $delete_button = "";
          $selectable = "";
        }

        $bookmarks = mysqli_query($conn, $query);
        if(mysqli_num_rows($bookmarks) > 0) {
          echo("<h5 style='text-align: center;'> ".$title." </h5>");
          echo("<table class='mdl-data-table mdl-js-data-table mdl-data-table".$selectable." mdl-shadow--2dp' style='width: 100%;'>");
          echo("<thead><tr><th class='mdl-data-table__cell--non-numeric'>Title</th><th>URL</th><th>Category</th></tr></thead>");
          echo("<tbody>");
          while($record = mysqli_fetch_array($bookmarks)) {
            echo ("<tr data-id='".$record['id']."'>");
            echo("<td class='mdl-data-table__cell--non-numeric'>".$record['title']."</td><td><a style='color: black;' href='http://".$record['url']."'>".$record['url']."</td><td>".$record['category']."</td>");
            echo("</tr>");
            echo("<div class='mdl-tooltip' data-mdl-for='".$record['title']."'>".$record['description']."</div>");
          }
          echo("</tbody></table>");
          echo($delete_button);
        } else {
          echo("No Bookmarks");
        }

        mysqli_close($conn);
        ?>
      </div>
    </main>
  </div>
</body>
</html>
