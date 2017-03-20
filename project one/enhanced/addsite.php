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
  <script>
  function hideChip() {
    var x = document.getElementById('chip');
    if (x.style.display === 'none') {
      x.style.display = 'block';
    } else {
      x.style.display = 'none';
    }
  }</script>
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
        <a class='mdl-navigation__link' href='showsites.php'>Show Bookmarks</a>
        <a class='mdl-navigation__link' href='login.php?logout=1'>Log Out</a>
      </nav>
    </div>
    <main class="mdl-layout__content">
      <div class="page-content" style="margin: auto; width: 30%; padding: 70px 0;">
        <form method="post" autocomplete="off">
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
            <input class="mdl-textfield__input" id="title" type="text" name="title"><label class="mdl-textfield__label" for="title">Title</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
            <input class="mdl-textfield__input" id="url" type="text" name="url"><label class="mdl-textfield__label" for="url">URL</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield" style="width: 100%;">
            <textarea class="mdl-textfield__input" type="text" rows= "3" id="description" name="description"></textarea>
            <label class="mdl-textfield__label" for="description">Description</label>
          </div>
          <div class="mdl-selectfield mdl-js-selectfield" style="width: 100%;">
            <select id="category" name="category" class="mdl-selectfield__select">
              <option value=""></option>
              <option value="Entertainment">Entertainment</option>
              <option value="News">News</option>
              <option value="Social Media">Social Media</option>
              <option value="Tech">Tech</option>
              <option value="Education">Education</option>
              <option value="Games">Games</option>
              <option value="Health">Health</option>
            </select>
            <label class="mdl-selectfield__label" for="category">Category</label>
          </div>
          <input class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent' style="width: 100%;" type="submit" value="Add">
        </form>
        <?php
        if(empty($_POST['title']) || empty($_POST['url'])) {
          return;
        }
        $title = $_POST['title'];
        $url = $_POST['url'];
        $desc = $_POST['description'];
        $cat = $_POST['category'];
        $date = date("Y-m-d");

        $conn = mysqli_connect("localhost", "webuser", "password", "webdata");
        $username = $_SESSION['user'];

        $query = "SELECT id FROM users WHERE username='$username' LIMIT 1";
        $user_record = mysqli_query($conn, $query);
        $user_id = mysqli_fetch_array($user_record);
        $user_id = $user_id['id'];
        $query = "INSERT INTO bookmarks (title, url, description, category, date_added, user_id) VALUES ('$title', '$url', '$desc', '$cat', '$date', $user_id)";
        if(mysqli_query($conn, $query)) {
          echo("<div style='text-align: center; padding: 40px 0;'><span class='mdl-chip mdl-chip--deletable' style='margin: auto;' id='chip'>
          <span class='mdl-chip__text'>Bookmark Successfully Added</span>
          <button type='button' class='mdl-chip__action' onclick='hideChip();'><i class='material-icons'>cancel</i></button>
          </span></div>");
        }

        mysqli_close($conn);
        ?>
      </div>
    </main>
  </div>
</body>
</html>
