<?php
define("host", "localhost");
define("username", "root");
define("password", "");
define("database_name", "school_db");

$conn = new mysqli(host, username, password, database_name);
if ($conn->connect_error) {
    die("Connection failed." . $conn->connect_error);
}
