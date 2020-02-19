<?php 

    include('./config/db_connect.php');

    //check GET request id param
    if(isset($_GET['edit'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id_to_edit']);

    //make sql
        $sql = "SELECT * FROM notes WHERE note_id = $id";

    //get the query results
        $result = mysqli_query($conn, $sql);

    //fetch the result in array format
        $note = mysqli_fetch_assoc($result);

        mysqli_free_result($result);
        mysqli_close($conn);
    }

    $title = $message = '';
    $errors = array('title'=>'', 'message'=>'');

    if(isset($_POST['submit'])) {

        //check title
        if(empty($_POST['title'])){
            $errors['title'] = 'A title is required <br/>';
        } else {
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-ZäöÄÖ0-9\s]+$/', $title)) {
                $errors['title'] = 'Title must be letters and spaces only <br>';
            }
        }
        //check Message
        if(empty($_POST['message'])){
            $errors['message'] = 'A message is required <br/>';
        } else {
            $message = $_POST['message'];
            if(!preg_match('/^[a-zA-ZäöÄÖ0-9,.\s]+$/', $message)){
                $errors['message'] = 'Message must be letters and spaces only <br>';
            }
        }

        if(array_filter($errors)) {
           // echo 'Errors in the form';
        } else {

            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $message = mysqli_real_escape_string($conn, $_POST['message']);
            $id = mysqli_real_escape_string($conn, $_POST['id_to_edit']);
            
            //create sql
            $sql = "UPDATE notes SET note_title='$title', note_message ='$message' WHERE note_id='$id'";

            //save to db and check
            if(mysqli_query($conn, $sql)) {
                //success
                header('Location: index.php');
            } else {
                //error
                echo 'query error: ' . mysqli_error($conn);
            }

            //echo 'Form is valid';
            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

    <?php include('./templates/header.php') ?>

    <section class="container grey-text">
        <h4 class="center">Edit note</h4>
        <form action="edit.php" class="white" method="POST">
            <label for="">Title:</label>
            <input type="text" name="title" value="<?php echo $note['note_title'] ?>">
            <input type="hidden" name="id_to_edit" value="<?php echo $note['note_id']; ?>">
            <div class="red-text"><?php echo $errors['title']; ?></div>
            <label for="">Message</label>
            <textarea type="textfield" maxlength="255" name="message" placeholder="Your note here"><?php echo $note['note_message']; ?></textarea>
            <div class="red-text"><?php echo $errors['message']; ?></div>
            <div class="center">
                <input type="submit" name="submit" value="Save" class="btn brand z-depth-0">
            </div>
        </form>
    </section>

    <?php include('./templates/footer.php') ?>

</html>