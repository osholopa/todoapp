<?php 

include('./config/db_connect.php');

if(isset($_POST['delete'])) {

    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM notes WHERE note_id = $id_to_delete";

    if(mysqli_query($conn, $sql)) {
        header('Location: index.php');
    } {
        echo 'Query error: ' . mysqli_error($conn);
    }

}

//check GET request id param
if(isset($_GET['note_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['note_id']);

    //make sql
    $sql = "SELECT * FROM notes WHERE note_id = $id";

    //get the query results
    $result = mysqli_query($conn, $sql);

    //fetch the result in array format
    $note = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
</head>
<body>
    <?php include('./templates/header.php') ?>

    <div class="container center">
        <?php if($note): ?>

            <h4><?php echo htmlspecialchars($note['note_title']); ?></h4>
            <p>Message: <?php echo htmlspecialchars($note['note_message']);?> </p>
            <p><?php echo date($note['created_at']);?></p>

            <!-- EDIT FORM -->
            <form action="edit.php" method="GET">
                <input type="hidden" name="id_to_edit" value="<?php echo $note['note_id']; ?>">
                <input type="submit" name="edit" value="Edit" class="btn brand z-depth-0">
            </form>
       
            <!-- DELETE FORM -->
            <form action="details.php" method="POST">
                <input type="hidden" name="id_to_delete" value="<?php echo $note['note_id']; ?>">
                <input type="submit" name="delete" value="Delete" class="btn delete-button z-depth-0">
            </form>

        <?php else: ?>
            <h5>No such note exists</h5>
        <?php endif; ?>
    </div>


    <?php include('./templates/footer.php') ?>

</body>
</html>