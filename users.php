<?php
    require_once "session.php";
    require_once 'model'.DIRECTORY_SEPARATOR.'functions.php';
    require_once 'views'.DS.'header.php';
?>

<h1>Users</h1>
<h2>Add user</h2>
<form method="post" action="controllers/auserv2.php" enctype="multipart/form-data">
    <input name="add" type="hidden">
    First name: <input name="first" type="text" ><br>
    Last name: <input name="last" type="text" ><br>
    Email: <input name="email" type="email" ><br>
    Cell: <input name="cell" type="number" ><br>
    Position: <input name="pos" type="text" ><br>
    Username: <input name="uname" type="text" ><br>
    Password: <input name="pw" type="password" ><br>
    Status: <input name="status" type="number" ><br>
    Picture: <input name="file" type="file" id="file" ><br>
    <input name="submit" type="submit" value="Submit"><br>

</form>
<?php
    if(@isset($_GET['adduser'])){
    if ($_GET['adduser'] === 'true'){
     echo 'Event added successfully.<br>';
    } else {
        echo 'Invalid/missing input.<br>';
    }
}
    ?>
<hr>

<h2>Search/update users</h2>
<form action='users.php' method='post'>
    <input type='hidden' name='updateusers' value='true'>
    <input type='submit' value='Search'><br><br>
</form>

<?php if(@isset($_POST['updateusers'])){
    $rows = array();
    $query = "SELECT * from users WHERE deleted = 0";
    $resp = mysqli_query(getDB(), $query);
    userlog($_COOKIE['user'], "viewed users", 1 );
    ?>
    <table>
        <tr>
            <td>ID</td>
            <td>First</td>
            <td>Last</td>
            <td>Email</td>
            <td>Cell</td>
            <td>Position</td>
            <td>Username</td>
            <td>Password</td>
            <td>Status</td>
            <td>Picture</td>
            <td></td>
            <td></td>
        </tr>
        <?php
        while($rows = $resp->fetch_assoc()){ ?>
        <tr>
            <form action="controllers/auserv2.php" method="post" onSubmit="return confirm('Are you sure?')">
                <td><input type="text" size="2" name="sid" value="<?php echo $rows["id"];?>" disabled></td>
                <input type="hidden" name="id" value="<?php echo $rows["id"];?>">
                <td><input type="text" size="10" name="first" value="<?php echo $rows["first"];?>"></td>
                <td><input type="text" size="10" name="last" value="<?php echo $rows["last"];?>"></td>
                <td><input type="email" size="15" name="email" value="<?php echo $rows["email"];?>"></td>
                <td><input type="number" size="10" name="cell" value="<?php echo $rows["cell"]?>"></td>
                <td><input type="text" size="10" name="pos" value="<?php echo $rows["position"]?>"></td>
                <td><input type="text" size="15" name="uname" value="<?php echo $rows["username"]?>"></td>
                <td><input type="password" size="10" name="pw" value="<?php echo $rows["password"]?>"></td>
                <td><input type="number" size="4" name="status" value="<?php echo $rows["status"]?>"></td>
                <td><input type="hidden" name="filename" value="<?php echo $rows["filename"]?>"> <a href="<?php echo ".".DS."controllers".DS."pics".DS.$rows["filename"]; ?>"><?php echo $rows['filename'] ;?> </a><input type="hidden" name="deleted" value="0"></td>
                <td><input name="update" type="submit" value="Update"></td>
                <td><input name="delete" type="submit" value="Delete"></td>
            </form>
        </tr>
        <?php }
     ?>
    </table>
<?php } ?>

<?php
if (@isset($_GET['deleteuser'])){
    echo "User deleted.";
} else if (@isset($_GET['updateuser'])){
    echo "User updated.";
}


?>


<?php
    echo("<br><a href=./>Go back</a><br>");
    echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; 
    require_once('views'.DS.'footer.php');?>