<?php
// show php errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// session start
session_start();

// database connection
// $host = "localhost";
// $port = "5432";
// $dbname = "short_link";
// $user = "postgres";
// $password = "postgres";
// $connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} ";
$db = pg_connect(getenv("DATABASE_URL"));


// check database connection
if (!$db) {
    echo "Error : Unable to open database\n";
}

// get user id from session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION["user_id"];
}
// ------------------------------------------- //
// check action
$action = "";
if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

if ($action == "short_link") {
    short_link($_POST['old_url']);
}

if ($action == "delete_link") {
    delete_link($_POST['link_id']);
}


if ($action == "get_all_links") {
    get_all_links();
}
// -------------------------------------------- //
// fuctions
// create a short link
function short_link($old_url)
{
    global $db;
    global $user_id;

    // genrate unique id
    $new_url = uniqid();

    // insert old_url and new_url
    $query = pg_query($db, "INSERT  INTO links(user_id,old_link, new_link) VALUES ($user_id,'$old_url','$new_url');");
    // print_r($query);
    if ($query) {
        echo $new_url;
    } else {
        echo '<script>alert("Record Added failed")</script>';
    }
}

// delete link

function delete_link($link_id)
{
    global $db;
    $query = "DELETE FROM links WHERE link_id=$link_id";
    if ($result = pg_query($db, $query)) {
        echo "Data Deleted Successfully.";
    } else {
        echo "Error.";
    }
}

// get all links data
function get_all_links()
{
    global $db;
    global $user_id;
?>
    <table class="table table-hover border">
        <thead>
            <tr>
                <!-- <th scope="col" width="10px">No</th> -->
                <th scope="col">Orignal Link</th>
                <th scope="col" width="5px">Short</th>
                <th width="5px"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = pg_query($db, "SELECT * FROM links WHERE user_id=$user_id ORDER BY link_id DESC;");
            $i = 0;
            while ($row = pg_fetch_array($sql)) {
                $i = $i + 1;
                $link_id = $row['link_id'];
                $old_url = $row['old_link'];
                $new_url = $row['new_link'];
            ?>
                <tr>
                    <!-- <th scope="row"><?= $i ?></th> -->
                    <!-- <td><?= $old_url ?> &nbsp;<i class="fas fa-link"></i> </td> -->

                    <!-- <td data-mdb-container="body" data-mdb-trigger="hover" data-mdb-toggle="popover" data-mdb-placement="top" data-mdb-content="<?= $old_url ?>">
                        <button onclick="copy_link('<?= $old_url ?>')" type="button" class="btn btn-outline-info btn-rounded" data-mdb-ripple-color="dark">
                            <i class="fas fa-link"></i>
                        </button>
                    </td> -->

                    <td>
                        <p class="text-break">
                            <?= $old_url ?>
                        </p>
                    </td>
                    <td>
                        <button onclick="copy_link('<?= $new_url ?>')" type="button" class="btn btn-outline-info btn-sm btn-rounded" data-mdb-ripple-color="dark">
                            <i class="fas fa-link"></i>
                        </button>
                    </td>
                    <td>
                        <button onclick="delete_link('<?= $link_id ?>')" type="button" class="btn btn-outline-info btn-sm btn-rounded" data-mdb-ripple-color="dark">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

<?php
}
