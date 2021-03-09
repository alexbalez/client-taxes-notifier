
<form action='./controllers/aeventv2.php' method='post'>
    <input type='hidden' name='add' value='true'>
    Client ID: <input type='number' name='clientid'><br>
    Notification ID: <input type='number' name='notifyid'><br>
    Start date: <input type='date' name='start'><br>
    Frequency (days): <input type='number' name='freq'><br>
    Status: <input type='radio' name='status' value='1'>Active | 
    <input type='radio' name='status' value='0'>Archive <br>
    <input type='Submit' value='Submit'><br>
</form>
