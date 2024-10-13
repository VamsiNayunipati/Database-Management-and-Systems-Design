<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login Page</title>
<script>
function showReaderForm() {
    document.getElementById('readerForm').style.display = 'block';
    document.getElementById('adminForm').style.display = 'none';
}

function showAdminForm() {
    document.getElementById('adminForm').style.display = 'block';
    document.getElementById('readerForm').style.display = 'none';
}
</script>
</head>
<body>

<h2>Login</h2>
<button onclick="showReaderForm()">Reader</button>
<button onclick="showAdminForm()">Admin</button>

<div id="readerForm" style="display:none;">
    <form action="readerMenu.php" method="post">
        <label for="readerId">Reader ID:</label>
        <input type="text" id="readerId" name="readerId" required>
        <input type="submit" value="Submit">
    </form>
</div>

<div id="adminForm" style="display:none;">
    <form action="adminMenu.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Submit">
    </form>
</div>

</body>
</html>
