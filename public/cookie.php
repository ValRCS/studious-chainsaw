<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cookies</title>
</head>
<body>
    <h1>Cookies</h1>
    <button type="button" onclick="document.cookie=&quot;firstname=John;expires=Wed, 18 Dec 2023 12:00:00 GMT&quot;">Create Cookie 1</button>
    <button type="button" onclick="document.cookie=&quot;firstname=;expires=Wed; 01 Jan 1970&quot;">Delete Cookie 1</button>
 <?php       
    $cookie_name = "user";
    $cookie_value = "John Doe";
    echo "<hr>";
    

    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

    echo 'Hello ' . htmlspecialchars($_COOKIE["user"]) . '!';
    echo "<hr>";
    foreach ($_COOKIE as $key => $value) {
        echo "KEY: $key => $value <hr>";
    }
    var_dump($_COOKIE);

?>
</body>
</html>