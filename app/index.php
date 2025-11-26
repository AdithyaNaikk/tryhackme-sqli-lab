<?php
/**
 * ========================================
 * TryHackMe SQL Injection Lab
 * ========================================
 * EDUCATIONAL PURPOSE ONLY
 * This application is intentionally vulnerable to demonstrate SQL injection attacks.
 * It is NOT secure and should ONLY be used in isolated lab environments.
 */

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
    case '1':  
        /**
         * VULNERABILITY: Union-based SQL Injection
         * Issue: Direct string interpolation without sanitization or prepared statements
         * Attack: Attacker can append UNION SELECT to extract additional data
         * Example payload: -1 UNION SELECT 1,username FROM users--
         * Why vulnerable: No parameterization; user input directly concatenated into query
         */
        $query = "SELECT id, username FROM users WHERE id = $input";
        break;
        
    case '2':  
        /**
         * VULNERABILITY: Blind Boolean-based SQL Injection
         * Issue: Quoted input but still vulnerable to boolean logic manipulation
         * Attack: Use AND/OR conditions to infer data through true/false responses
         * Example payload: 1' AND (SUBSTRING(...),1,1)='5')--
         * Why vulnerable: Input quotes don't prevent comment injection; parser still executable
         */
        $query = "SELECT username FROM users WHERE id = '$input'";
        break;
        
    case '3':  
        /**
         * VULNERABILITY: Error-based SQL Injection
         * Issue: Direct concatenation; errors expose database structure
         * Attack: Trigger intentional errors to leak database names, versions, etc.
         * Example payload: 1 OR extractvalue(1,concat(0x7e,(SELECT database()),0x7e))--
         * Why vulnerable: No input validation; verbose error messages reveal internals
         */
        $query = "SELECT name, price FROM products WHERE id = $input";
        break;
        
    case '4':  
        /**
         * VULNERABILITY: Time-based Blind SQL Injection
         * Issue: Numeric input without protection; no output feedback
         * Attack: Use conditional delays (SLEEP) to infer data bit-by-bit
         * Example payload: 1 AND IF(SUBSTRING(...),1,1)='e',SLEEP(5),0)--
         * Why vulnerable: No output verification; timing side-channel attack viable
         */
        $query = "SELECT id, username FROM users WHERE id = $input";
        break;
        
    case '5':  
        /**
         * VULNERABILITY: Tautology Authentication Bypass
         * Issue: String concatenation in login query without sanitization
         * Attack: Comment out password check with -- or force true with OR '1'='1'
         * Example payload: username=admin'-- (disables password validation)
         * Why vulnerable: SQL syntax allows comments; attacker controls logic flow
         */
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $user = $_POST['username'];
            $pass = $_POST['password'];
            // VULNERABLE: Direct concatenation allows comment injection
            $query = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
            // Intentionally NOT using prepared statement to demonstrate vulnerability
            $stmt = $pdo->query($query);
            if ($stmt && $stmt->rowCount() > 0) {
                echo "<h2>Welcome, " . htmlspecialchars($user) . "!</h2>";
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

echo "<h3>Level $level Query:</h3><pre>" . htmlspecialchars($query) . "</pre>";

try {
    // INTENTIONALLY VULNERABLE: Direct query execution without prepared statements
    // In production code, use: $stmt = $pdo->prepare($query); $stmt->execute([$input]);
    $stmt = $pdo->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!empty($results)) {
        echo "<table border='1'>";
        echo "<tr><th>" . implode('</th><th>', array_keys($results[0])) . "</th></tr>";
        foreach ($results as $row) {
            $safe_row = array_map('htmlspecialchars', $row);
            echo "<tr><td>" . implode('</td><td>', $safe_row) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No results.</p>";
    }
} catch (Exception $e) {
    // Show errors for educational debugging (bad practice in production)
    echo "<p style='color:red'><strong>Error Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p style='color:orange'><strong>Tip:</strong> Verbose errors can leak database information to attackers.</p>";
}
?>

<!-- 
=== DEFENSE STRATEGIES ===

1. PREPARED STATEMENTS (Primary Defense)
   Secure version:
   $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
   $stmt->execute([$input]);
   
2. INPUT VALIDATION
   $input = filter_var($input, FILTER_VALIDATE_INT);
   if ($input === false) die("Invalid input");
   
3. LEAST PRIVILEGE
   Database user should have minimal permissions (SELECT only, not DROP/DELETE)
   
4. ERROR HANDLING
   Don't expose raw SQL errors; log internally, show generic message to users
   
5. WEB APPLICATION FIREWALL
   Monitor for common SQLi patterns in input streams
-->