<?php
require_once('db.php');
// check new url set or not
if (isset($_GET['v'])) {
    $new_url = $_GET['v'];
    // check url valid or not
    $sql = pg_query($db, "SELECT * FROM links WHERE new_link='$new_url'");
    $row = pg_fetch_array($sql);
    if ($row == null) {
        echo '<script>alert("Invalid Url")</script>';
    } else {
        $link_id = $row['link_id'];
        // update count
        pg_query($db, "insert into views(link_id) values($link_id);");
        // redirect to orignal link
        $url = "Location: " . $row[2];
        header($url);
    }
}
