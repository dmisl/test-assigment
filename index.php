<?php

include_once('db.php');
include_once('model.php');
include_once('test.php');

$conn = get_connect();

?>
    
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User transactions information</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>User transactions information</h1>
  <form action="data.php" method="GET">
    <label for="user">Select user:</label>
    <select name="user" id="user">
    <?php
    $users = get_users($conn);
    foreach ($users as $id => $name) {
        echo "<option value=\"$id\">".$name."</option>";
    }
    ?>
    </select>
    <input id="submit" type="submit" value="Show">
  </form>

  <div id="data">
    <h2>Transactions of <span id="user_name">`User name`</span></h2>
    <table id="table">
      <tr><th>Mounth</th><th>Amount</th></tr>
    </table>
  </div>  
<script src="script.js"></script>
</body>
</html>
