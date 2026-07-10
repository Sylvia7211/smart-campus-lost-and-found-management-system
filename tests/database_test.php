<?php
require_once("../config/database.php");

echo "<h2>Database Test</h2>";

if ($conn) {
    echo "<h3 style='color:green;'>✓ Database Connected Successfully</h3>";
} else {
    echo "<h3 style='color:red;'>✗ Database Connection Failed</h3>";
}
?>