<?php
session_start();
if (!isset($_SESSION['ime'])) {
    header("Location: index.php");
    exit;
}
echo '<h1>Hello ' . $_SESSION['ime'] . ' here is your plan for today.</h1>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="addons/jquery-ui.css">
    <link rel="stylesheet" href="addons/bootstrap.min.css">
    <link rel="stylesheet" href="css/glavna.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planner</title>
</head>

<body>
    <?php
    include "includes/navbar.php";
    ?>
    <div class="container">
        <br />
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">Search</span>
                <input type="text" name="search_text" class="form-control" id="search_text" placeholder="Search by name or start time" />
            </div>
        </div>
        <br />
        <div>
            <button type="button" name="add" id="add" class="btn btn-success
        btn-xs"> Add </button>
        </div>
        <div id="user_data" class="table-responsive">
        </div>
        <br />
    </div>
    <div id="user_dialog" title="Add Activity">
        <form method="post" id="user_form">
            <div class="form-group">
                <label>Enter Activity Name</label>
                <input type="text" name="activityName" id="activityName" placeholder="Enter name" class="form-control">
                <div id="suggesstion-box"></div>
                <span id="error_activityName" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label>Enter Starting Time</label>
                <input type="text" name="startingTime" id="startingTime" placeholder="Enter time in format 00-00" class="form-control">
                <span id="error_startingTime" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label>Enter Ending Time</label>
                <input type="text" name="endingTime" id="endingTime" placeholder="Enter time in format 00-00" class="form-control">
                <span id="error_endingTime" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="textarea" name="description" id="description" placeholder="Enter description" class="form-control">
                <span id="error_description" class="text-danger"></span>
            </div>
            <div class="form-group">
                <input type="hidden" name="action" id="action" value="insert" />
                <input type="hidden" name="hidden_id" id="hidden_id" value="hidden_id" />
                <input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Insert" />
            </div>
        </form>
    </div>

    <div id="action_alert" title="Action">

    </div>

    <div id="delete_confirmation" title="Confirmation">
        <p>Are you sure you want to Delete this data?</p>
    </div>

    <script src="addons/jquery.min.js"></script>
    <script src="addons/jquery-ui.js"></script>
    <script src="js/glavna.js"></script>
</body>

</html>