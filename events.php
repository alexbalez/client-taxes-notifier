<?php
    require_once "session.php";
    require_once "model".DIRECTORY_SEPARATOR."functions.php";
    require_once('views'.DS.'header.php');
 ?>

    <h1>Events</h1>
    <?php 

    require_once(".".DS."views".DS."addevent.php");

    if(@isset($_GET['addevent'])){
        if ($_GET['addevent'] === 'true'){
            echo 'Event added successfully.<br>';
        } else {
            echo 'Error. Do not include | or % in your event info.<br>Client ID, Notification ID, and frequency must be integers.<br>';
        }
    }
?>
    
<h2>Search/update events</h2>
<form action='events.php' method='post'>
    <input type='hidden' name='updateevents' value='true'>
    <input type='submit' value='Search'><br><br>
</form>

<?php if(@isset($_POST['updateevents'])){
	$rows = array();
	$query = "SELECT * from events WHERE deleted = 0";
	$resp = mysqli_query(getDB(), $query);
	userlog($_COOKIE['user'], "viewed events");
	?>
    <table>
        <tr>
            <td>ID</td>
            <td>Client ID</td>
            <td>Notification ID</td>
            <td>Start Date</td>
            <td>Frequency (days)</td>
            <td>Status</td>
            <td></td>
            <td></td>
        </tr>
		<?php
		while($rows = $resp->fetch_assoc()){ ?>
            <tr>
                <form action="controllers/ueventv2.php" method="post" onSubmit="return confirm('Are you sure?')">
                    <td><input type="text" size="4" name="sid" value="<?php echo $rows["id"];?>" disabled></td>
                    <input type="hidden" name="id" value="<?php echo $rows["id"];?>">
                    <td><input type="number" size="4" name="clientid" value="<?php echo $rows["clientid"];?>"></td>
                    <td><input type="number" size="4" name="notifid" value="<?php echo $rows["notifid"];?>"></td>
                    <td><input type="date" size="8" name="start" value="<?php echo $rows["start"];?>"></td>
                    <td><input type="number" size="8" name="freq" value="<?php echo $rows["freq"];?>"></td>
                    <td><input type="number" size="2" name="status" value="<?php echo $rows["status"];?>"></td>
                    <td><input name="update" type="submit" value="Update"></td>
                    <td><input name="delete" type="submit" value="Delete"></td>
                </form>
            </tr>
		<?php }
		?>
    </table>
<?php }

if(@isset($_GET['updateevent'])){
    if($_GET['updateevent']==='true'){
        echo 'Events updated.<br>';
    } else {
        echo 'Error. Do not include | or % in your notification info.<br>Client ID, Notification ID, and frequency must be integers.<br>';
    }
}

    echo("<a href='./'>Go back</a><br>");
    echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; 
   
    require_once('views'.DS.'footer.php'); ?>