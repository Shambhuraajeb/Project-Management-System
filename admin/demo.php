


<?php
$username = 'system';
$password = 'admin';
$connection_string = '//localhost:1521/xe';

$conn = oci_connect($username, $password, $connection_string);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$query = "SELECT id FROM demo WHERE some_column = 'DEMO'";

$stid = oci_parse($conn, $query);
if (!oci_execute($stid)) {
    $e = oci_error($stid);
    echo "Error executing query: " . $e['message'];
    // Handle error or exit
} else {
    while (($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
        // Process each row
        echo $row['TABLE_NAME'] . "\n";
    }
}

?>
