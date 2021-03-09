<?php
    require_once "session.php";

    require_once('model'.DIRECTORY_SEPARATOR.'functions.php');
    require_once('views'.DS.'header.php');


    echo "<h1>Notifications</h1>";
    require_once("views/addnotify.php");
    if(@isset($_GET['addnotify'])){
        if ($_GET['addnotify'] === 'true'){
            echo 'Notification added successfully.<br>';
        } else {
            echo 'Error. Do not include | or % in your notification info.<br>';
        }
    }
    ?>

    <h2>Search/update notifications</h2>
    <form action='notifys.php' method='post'>
        <input type='hidden' name='updatenotifys' value='true'>
        <input type='submit' value='Search'><br><br>
    </form>

<?php if(@isset($_POST['updatenotifys'])){
	$rows = array();
	$query = "SELECT * from notifys WHERE deleted = 0";
	$resp = mysqli_query(getDB(), $query);
	userlog($_COOKIE['user'], "viewed notifys", 1 );
	?>
    <table>
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Type</td>
            <td>Status</td>
            <td></td>
            <td></td>
        </tr>
		<?php
		while($rows = $resp->fetch_assoc()){ ?>
            <tr>
                <form action="controllers/unotifyv2.php" method="post" onSubmit="return confirm('Are you sure?')">
                    <td><input type="text" size="4" name="sid" value="<?php echo $rows["id"];?>" disabled></td>
                    <input type="hidden" name="id" value="<?php echo $rows["id"];?>">
                    <td><input type="text" size="14" name="named" value="<?php echo $rows["named"];?>"></td>
                    <?php
                    $checksms = $rows["types"] == "sms" ? "checked" : "";
                    $checkemail = $rows["types"] == "email" ? "checked" : "";
                    $checkphone = $rows["types"] == "phone" ? "checked" : "";
                    $checkmail = $rows["types"] == "mail" ? "checked" : "";
                    $checkpigeon = $rows["types"] == "pigeon" ? "checked" : "";

                    $str = "<input type='radio' name='types' value='sms' $checksms>SMS |
                    <input type='radio' name='types' value='email' $checkemail>Email |
                    <input type='radio' name='types' value='phone' $checkphone>Phone |
                    <input type='radio' name='types' value='mail' $checkmail>Mail |
                    <input type='radio' name='types' value='pigeon' $checkpigeon>Carrier pigeon
                    ";?>

                    <td><?php echo $str ?></td>
                    <td><input type="text" size="8" name="status" value="<?php echo $rows["status"];?>"></td>
                    <td><input name="update" type="submit" value="Update"></td>
                    <td><input name="delete" type="submit" value="Delete"></td>
                </form>
            </tr>
		<?php }
		?>
    </table>
<?php
} 

if(@isset($_GET['updatenotify'])){
    if($_GET['updatenotify']==='true'){
        echo 'Notifications updated.<br>';
    } else {
        echo 'Error. Do not include | or % in your notification info.<br>';
    }
}


echo("<a href='./'>Go back</a><br>");
echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; 

require_once('views/footer.php'); ?>