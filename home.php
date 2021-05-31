<?php
require_once('./db.php');
require_once('./navbar.php');
require_once('./footer.php');
// check session 
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Home</title>
    <!-- MDB icon -->
    <link rel="icon" href="./img/logo.svg" type="image/x-icon" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="css/mdb.min.css" />
    <!-- toastr css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- cutom css -->
    <style>
        #new_url_div {
            display: none;
        }
    </style>
</head>

<body>
    <!-- Start your project here-->
    <?= navbar() ?>
    <header>
        <div class="container mt-5 mb-5 bg-gray">
            <!-- short link card -->
            <div class="card border p-5">
                <div class="row g-2 mb-2">
                    <label> <b>Enter Url</b></label>
                </div>
                <!-- Genrate link -->
                <div class="row">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="old_url" placeholder="Enter Url" aria-describedby="button-addon2" />
                        <button onclick="genrate_link()" class="btn btn-secondary" type="button" id="button-addon2" data-mdb-ripple-color="dark">
                            Genrate link
                        </button>
                    </div>
                </div>
                <!-- Genrate link end -->
                <!-- Genrateted link -->
                <div id="new_url_div" class="mt-3">
                    <div class="row g-2 mb-2">
                        <label>
                            <b>
                                Genrated Link
                            </b>
                        </label>
                    </div>
                    <div class="row ">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" disabled id="new_url" aria-describedby="button-addon2" />
                            <button onclick="copy_genrated_link()" class="btn btn-secondary pl-3" type="button" id="button-addon2" data-mdb-ripple-color="dark">
                                Copy Link &nbsp;<i class="fas fa-link"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Genrateted link -->
            </div>
            <!-- short link card end -->
            <!-- links table -->
            <div id="links_table" class="mt-5 mb-5">

            </div>
            <!-- links table end -->
        </div>
    </header>
    <?= footer() ?>
    <!-- End your project here-->

</body>

<!-- MDB -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- toastr js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Custom scripts -->
<script type="text/javascript">
    // get current url
    var url = window.location.href.replace("home.php", "");
    var url = url + "url.php?v="

    // call get links
    get_all_links();
    // get all links
    function get_all_links() {
        // ajax post call
        $.post("db.php", {
                action: "get_all_links"
            })
            .done(function(data) {
                // console.log(data);
                $("#links_table").empty();
                $("#links_table").append(data);
            });
    }

    // url validation
    function isValidURL(str) {
        var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
        if (!regex.test(str)) {
            return false;
        } else {
            return true;
        }
    };

    // genrate link 
    function genrate_link() {
        let old_url = $('#old_url').val();

        if (isValidURL(old_url)) {
            // ajax post call
            $.post("db.php", {
                    old_url: old_url,
                    action: "short_link"
                })
                .done(function(data) {
                    $('#new_url').val(url + data)
                    $('#new_url_div').show();
                    alert("Data Loaded: " + data);
                    toastr.success('Short Link Genrated')
                    get_all_links();
                });
        } else {
            toastr.error('Enter Valid Url!')
        }
    }

    // delete link

    function delete_link(link_id) {
        console.log(link_id);
        $.post("db.php", {
                link_id: link_id,
                action: "delete_link"
            })
            .done(function(data) {
                alert(data);
                console.log(data);
                get_all_links();
            });
    }

    // copy link 
    function copy_link(link) {
        copyToClipboard(url + link)
    }

    // copy genrated link
    function copy_genrated_link() {
        var clipboardText = "";
        clipboardText = $('#new_url').val();
        copyToClipboard(clipboardText);
    }

    // copy fuction
    function copyToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            console.log('Copying text command was ' + msg);
            toastr.success('Copy Link to Clipboard')
        } catch (err) {
            console.log('Oops, unable to copy');
        }
        document.body.removeChild(textArea);
    }
</script>

</html>