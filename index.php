<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <title>Hello, world!</title>
</head>
<body>

<?php
require "DBcon.php";

// ✅ Add Activity
if (isset($_POST['addActivity'])) {
    $title = $_POST['ActTitle'];
    $desc = $_POST['ActDesc'];

    $insertQ = "INSERT INTO activitylist (ActTitle, ActDesc) VALUES ('$title', '$desc')";
    $result = mysqli_query($con, $insertQ);

    if ($result) {
        echo "<script>alert('Activity Added Successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Failed to Add Activity');</script>";
    }
}

// ✅ Edit Activity
if (isset($_POST['editActivity'])) {
    $editID = $_POST['ActID'];
    $editTitle = $_POST['ActTitle'];
    $editDesc = $_POST['ActDesc'];

    $editTitle = mysqli_real_escape_string($con, $_POST['ActTitle']);
    $editDesc = mysqli_real_escape_string($con, $_POST['ActDesc']);


    $updateQ = "UPDATE activitylist SET ActTitle='$editTitle', ActDesc='$editDesc' WHERE ActID='$editID'";
    $updateResult = mysqli_query($con, $updateQ);

    if ($updateResult) {
        echo "<script>alert('Activity Updated Successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Failed to Update Activity');</script>";
    }
}

// ✅ Delete Activity
if (isset($_GET['acID'])) {
    $dtID = $_GET['acID'];
    $dtQur = "DELETE FROM activitylist WHERE ActID='$dtID'";
    $exc1 = mysqli_query($con, $dtQur);
    if ($exc1) {
        echo "<script>alert('Deleted Successfully'); window.location.href='index.php';</script>";
    }
}
?>

<h1 class="text-center my-4">My Daily Life Activity</h1>

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Sl.No</th>
            <th scope="col">Activity</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
            <th scope="col">
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $qur = "SELECT * FROM activitylist";
        $exc = mysqli_query($con, $qur);
        $cnt = 1;
        while ($row = mysqli_fetch_assoc($exc)) {
            $modalID = "editModal_" . $row["ActID"];
            echo '
            <tr>
                <th scope="row">' . $cnt . '</th>
                <td>' . $row["ActTitle"] . '</td>
                <td>' . $row["ActDesc"] . '</td>
                <td>
                    <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#' . $modalID . '">Edit</button>&nbsp;&nbsp;
                    <a class="btn btn-outline-danger" href="index.php?acID=' . $row["ActID"] . '">Delete</a>
                </td>
                <td></td>
            </tr>

            <!-- ✅ Edit Modal -->
            <div class="modal fade" id="' . $modalID . '" tabindex="-1" role="dialog" aria-labelledby="' . $modalID . 'Label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="' . $modalID . 'Label">Edit Activity</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="ActID" value="' . $row["ActID"] . '">
                                <div class="form-group">
                                    <label>Enter Activity:</label>
                                    <input type="text" class="form-control" name="ActTitle" value="' . $row["ActTitle"] . '" required>
                                </div>
                                <div class="form-group">
                                    <label>Description:</label>
                                    <textarea class="form-control" name="ActDesc" required>' . $row["ActDesc"] . '</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="editActivity" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>';
            $cnt++;
        }
        ?>
    </tbody>
</table>

<!-- ✅ Add Activity Button -->
<div class="text-center">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addActivityModal">Add Activity</button>
</div>

<!-- ✅ Add Activity Modal -->
<div class="modal fade" id="addActivityModal" tabindex="-1" role="dialog" aria-labelledby="addActivityLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addActivityLabel">TO DO LIST</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="ActTitle">Enter Activity:</label>
                <input type="text" class="form-control" id="ActTitle" name="ActTitle" required>
            </div>
            <div class="form-group">
                <label for="ActDesc">Description:</label>
                <textarea class="form-control" id="ActDesc" name="ActDesc" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="addActivity" class="btn btn-primary">Add</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap Scripts -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

</body>
</html>
