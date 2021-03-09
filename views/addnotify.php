
<form action='./controllers/anotifyv2.php' method='post'>
    <input type='hidden' name='add' value='true'>
    Notification name: <input type='text' name='named'><br>
    Type: <input type='radio' name='types' value='sms'>SMS |
    <input type='radio' name='types' value='email'>Email |
    <input type='radio' name='types' value='phone'>Phone |
    <input type='radio' name='types' value='mail'>Mail |
    <input type='radio' name='types' value='pigeon'>Carrier pigeon<br>
    Status: <input type='radio' name='status' value='1'>Enabled | 
    <input type='radio' name='status' value='0'>Disabled <br>
    <input type='Submit' value='Submit'><br>
</form>
