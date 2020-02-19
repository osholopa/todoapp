<?php 

    include('./config/db_connect.php');

    $title = $message = '';
    $errors = array('title'=>'', 'message'=>'');

    if(isset($_POST['submit'])) {

        //check title
        if(empty($_POST['title'])){
            $errors['title'] = 'A title is required <br/>';
        } else {
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-ZäöÄÖ0-9\s]+$/', $title)) {
                $errors['title'] = 'Message must be letters and spaces only <br>';
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
            
            //create sql
            $sql = "INSERT INTO notes(note_title, note_message) VALUES('$title', '$message')";

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
        <h4 class="center">Add a note</h4>
        <form action="add.php" class="white" method="POST">
            <label for="">Title:</label>
            <input type="text" name="title" value="<?php echo $title ?>">
            <div class="red-text"><?php echo $errors['title']; ?></div>
            <label for="">Note (Max length 255 characters)</label>
            <textarea type="textfield" maxlength="255" name="message" placeholder="Your note here"><?php echo $message; ?></textarea>
            <div class="red-text"><?php echo $errors['message']; ?></div>
            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
        </form>
    </section>

    <?php include('./templates/footer.php') ?>

</html>