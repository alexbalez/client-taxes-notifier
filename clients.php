<?php
    require_once "session.php";
    require_once 'model'.DIRECTORY_SEPARATOR.'functions.php';
    require_once('views'.DS.'header.php');
?>

<h1>Clients</h1>
<h2>Add client</h2>
<?php require_once('views'.DS.'addclient.php');
if (@isset($_GET['addclient'])){
    if ($_GET['addclient'] === 'true'){
        echo 'Client added successfully.';
    } else {
        echo 'Error. Do not include | or % in your client info. <br> Phone numbers must be 0-9.<br>Website must be full and valid or left blank.<br>';
    }
}
?>

<hr>

<h2>Search/update clients</h2>
<form action='clients.php' method='post'>
    <input type='hidden' name='updateclients' value='true'>
    <input type='submit' value='Search'><br><br>
</form>

<?php if(@isset($_POST['updateclients'])){
    $rows = array();
    $query = "SELECT * from clients WHERE deleted = 0";
    $resp = mysqli_query(getDB(), $query);
    userlog($_COOKIE['user'], "viewed clients", 1);
    ?>
    <table>
        <tr>
            <td>ID</td>
            <td>Company</td>
            <td>Business #</td>
            <td>Contact First</td>
            <td>Contact Last</td>
            <td>Phone</td>
            <td>Cell</td>
            <td>Website</td>
            <td>Active</td>
            <td></td>
            <td></td>
        </tr>
        <?php
        while($rows = $resp->fetch_assoc()){ ?>
        <tr>
            <form action="controllers/uclientv2.php" method="post" onSubmit="return confirm('Are you sure?')">
                <td><input type="text" size="4" name="sid" value="<?php echo $rows["id"];?>" disabled></td>
                <input type="hidden" name="id" value="<?php echo $rows["id"];?>">
                <td><input type="text" name="company" value="<?php echo $rows["company"];?>"></td>
                <td><input type="number" size="6" name="bnum" value="<?php echo $rows["bnum"];?>"></td>
                <td><input type="text" size="14" name="contactfirst" value="<?php echo $rows["contactfirst"];?>"></td>
                <td><input type="text" size="14" name="contactlast" value="<?php echo $rows["contactlast"];?>"></td>
                <td><input type="number" size="10" name="phone" value="<?php echo $rows["phone"];?>"></td>
                <td><input type="number" size="10" name="cell" value="<?php echo $rows["cell"];?>"></td>
                <td><input type="text" name="website" value="<?php echo $rows["website"];?>"></td>
                <td><input type="text" size="2" name="active" value="<?php echo $rows["active"];?>"></td>
                <td><input name="update" type="submit" value="Update"></td>
                <td><input name="delete" type="submit" value="Delete"></td>
            </form>
        </tr>
        <?php }
     ?>
    </table>
<?php } ?>

<?php
if (@isset($_GET['deleteclient'])){
    echo "Client deleted.";
} else if (@isset($_GET['updateclient'])){
    echo "Client updated.";
}

?>

        <?php /*<table>
        <tr>
            <td>ID</td>
            <td>Company</td>
            <td>Business #</td>
            <td>Contact First</td>
            <td>Contact Last</td>
            <td>Phone</td>
            <td>Cell</td>
            <td>Website</td>
            <td>Active</td>
            <td></td>
            <td></td>
        </tr>
		<?php while($rows = $resp->fetch_assoc()){?>
            <tr>
                <form action="./clients.php" method="post">
                    <td><input type="text" name="" value=""></td>
                    <td><input type="text" name="" value=""></td>
                    <td><input type="text" name="" value=""></td>
                    <td><input type="text" name="" value=""></td>
                    <td><input type="text" name="" value=""></td>
                    <td><input type="text" name="" value=""></td>
                    <td><input type="text" name="" value=""></td>
                    <td><input type="text" name="" value=""></td>
                    <td><input type="text" name="" value=""></td>
					<?php $rows["id"];?>
                </form>
            </tr>
            }
            </table>*/
?>


<?php
    echo("<br><a href=./>Go back</a><br>");
    echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; 
    require_once('views'.DS.'footer.php');?>