<?php 
    include('./config/db_connect.php');

    //write query for all entries
    $sql = 'SELECT note_title, note_message, note_id FROM notes ORDER BY created_at';

    //make the query and get result
    $result = mysqli_query($conn, $sql);

    //fetch the resulting rows as an array
    $notes = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //free result from memory
    mysqli_free_result($result);

    //close connection
    mysqli_close($conn);

    explode(',', $notes[0]['note_message'])

?>

<!DOCTYPE html>
<html lang="en">
    <?php include('./templates/header.php') ?>

     <h4 class="center grey-text">Notes</h4>

    <div class="container">
        <div class="row">
            <?php foreach($notes as $note): ?>

                <div class="col s6 md3">
                    <div class="card z-depth-0">
                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($note['note_title']); ?></h6>
                            <ul>
                                <?php  foreach(explode(',', $note['note_message']) as $ing): ?>
                                    <li><?php echo htmlspecialchars($ing); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="card-action right-align">
                            <a class="brand-text" href="details.php?note_id=<?php echo $note['note_id'];?>">more info</a>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
            <p>There are <?php echo count($notes); ?> notes</p>
        </div>
    </div> 

    <?php include('./templates/footer.php') ?>
</html>