<?php
// Simple vulnerable SQLi app for TryHackMe lab
$host = 'db';  // Docker service name
$dbname = 'sqli_lab';
$username = 'root';
$password = 'rootpass';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$level = $_GET['level'] ?? '1';
$input = $_GET['input'] ?? '1';  // Generic input for flexibility

switch ($level) {
    case '1':  // Union-based SQLi
        $query = "SELECT id, username FROM users WHERE id = $input";
        break;
    case '2':  // Blind Boolean-based
        $query = "SELECT username FROM users WHERE id = '$input'";
        break;
    case '3':  // Error-based
        $query = "SELECT name, price FROM products WHERE id = $input";
        break;
    case '4':  // Time-based
        $query = "SELECT id, username FROM users WHERE id = $input";
        break;
    case '5':  // Login bypass (tautology)
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $query = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo "<h2>Welcome, " . $user . "!</h2>";
            } else {
                echo "<h2>Login failed.</h2>";
            }
        } else {
            echo "<form method='POST'>
                    Username: <input type='text' name='username'><br>
                    Password: <input type='text' name='password'><br>
                    <input type='submit' value='Login'>
                  </form>";
            return;
        }
        break;
    default:
        die("Invalid level: 1-5 only.");
}

echo "<h3>Level $level Query:</h3><pre>$query</pre>";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($results)) {
        echo "<table border='1'>";
        echo "<tr><th>" . implode('</th><th>', array_keys($results[0])) . "</th></tr>";
        foreach ($results as $row) {
            echo "<tr><td>" . implode('</td><td>', $row) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No results.</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?>