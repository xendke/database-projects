<?php
session_start();
if (empty($_SESSION["user"])) {
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue_grey-light_green.min.css" />
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  <link rel="stylesheet" href="https://cdn.rawgit.com/MEYVN-digital/mdl-selectfield/master/mdl-selectfield.min.css">
  <script defer src="https://cdn.rawgit.com/MEYVN-digital/mdl-selectfield/master/mdl-selectfield.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      <div class="page-content" style="margin: auto; width: 50%; padding: 70px 0;">

        <?php

        $username = $_SESSION['user'];
        require('database.php');
        $query = "SELECT id FROM users WHERE username='$username' LIMIT 1";
        $user_record = mysqli_query($conn, $query);
        $user_id = mysqli_fetch_array($user_record);
        $user_id = $user_id['id'];

        $query = "SELECT title, url, description, category, date_added FROM bookmarks WHERE user_id=$user_id";
        $user_record = mysqli_query($conn, $query);
        echo("<table class='mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp' style='width: 100%;'>");
        echo("<thead><tr><th class='mdl-data-table__cell--non-numeric'>Title</th><th>URL</th><th>Category</th></tr></thead>");
        echo("<tbody>");
        while($record = mysqli_fetch_array($user_record)) {
          echo ("<tr id='".$record['title']."'>");
          echo("<td class='mdl-data-table__cell--non-numeric'>".$record['title']."</td><td><a style='color: black;' href='http://".$record['url']."'>".$record['url']."</td><td>".$record['category']."</td>");
          echo("</tr>");
          echo("<div class='mdl-tooltip' data-mdl-for='".$record['title']."'>".$record['description']."</div>");
        }
        echo("</tbody></table>");



        $username = $_SESSION['user'];

        mysqli_close($conn);
        ?>
      </div>
    </main>
  </div>
</body>
</html>
