<?php
// Creating PHP apps using Microsoft SQL Server 2002 
// DEVELOPER EDITION on Windows and xampp control panel

echo ('<br/><br/>');

//Server connection configuration
$serverName = "XXXXXX\SQLDEVELOPER";
$connectionOptions = array(
  "DATABASE" => "SamplePHP",
  "UID" => "your_usernamr",
  "PWD" => "your_password"
);

//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn) {
  echo "Connection established for user: " . $connectionOptions['UID'] . ".<br/>" . "Using database: " . $connectionOptions['DATABASE'] . " " . "on server: " . $serverName . ".<br/><br/>";
} else {
  echo "Connection could not be established for the user: " . $connectionOptions['UID'] . ".<br/>";
  die(FormatErrors(sqlsrv_errors()));
}

// retrieving information about the server
echo ('Server Info: <br/>');
if ($server_info = sqlsrv_server_info($conn)) {
  foreach ($server_info as $key => $value) {
    echo $key . ": " . $value . "<br/>";
  }
} else {
  echo "Error in retrieving server info.<br/>";
  die(FormatErrors(sqlsrv_errors()));
}
echo ('<br/>');

// retrieving information about the client
echo ('Client Info: <br/>');
if ($client_info = sqlsrv_client_info($conn)) {
  foreach ($client_info as $key => $value) {
    echo $key . ": " . $value . "<br/>";
  }
} else {
  echo "Error in retrieving client info.<br/>";
}
echo ('<br/>');

/* Display errors. */
function FormatErrors($errors)
{
  echo "<br/><br/>Error information: <br/>";
  foreach ($errors as $error) {
    echo "SQLSTATE: " . $error['SQLSTATE'] . "" . '<br/>';
    echo "Code: " . $error['code'] . "" . '<br/>';
    echo "Message: " . $error['message'] . "" . '<br/><br/>';
  }
}

// function to execute query
function manipulateDatabase($textMsg1, $tsql, $conn, $params, $textMsg2)
{
  echo ($textMsg1 . PHP_EOL . '<br/>');
  $getResults = sqlsrv_query($conn, $tsql, $params);
  echo $getResults ? "Query Executed!<br/>" : "Query Failed!<br/>";
  $rowsAffected = sqlsrv_rows_affected($getResults);
  $rowsText = $rowsAffected == 1 ? ' row' : ' rows';
  if ($getResults == FALSE or $rowsAffected == FALSE)
    die(FormatErrors(sqlsrv_errors()));
  echo ($rowsAffected . $rowsText . $textMsg2 . ' ' . PHP_EOL . '<br/>');
  sqlsrv_free_stmt($getResults);

  /* If both queries were successful, commit the transaction. */
  /* Otherwise, rollback the transaction. */
  if ($getResults) {
    sqlsrv_commit($conn);
    echo strtok($tsql, ' ') . " transaction committed.<br/><br/>";
  } else {
    sqlsrv_rollback($conn);
    echo strtok($tsql, ' ') . " transaction rolled back.<br/>";
  }
}

/* Begin the transaction. */
if (sqlsrv_begin_transaction($conn) === false) {
  die(FormatErrors(sqlsrv_errors()));
}

// Insert New Query
$tsql = "INSERT INTO Employees (Name, Location) VALUES (?,?);";
$params = array('Matt', 'Finley');
manipulateDatabase("Inserting a new row into the table", $tsql, $conn, $params, " inserted: ");

// Insert Another Query
$tsql = "INSERT INTO Employees (Name, Location) VALUES (?,?);";
$params = array('Victor', 'Waking');
manipulateDatabase("Inserting a new row into the table", $tsql, $conn, $params, " inserted: ");


// Update Existing Query
$userToUpdate = 'Malik';
$tsql = "UPDATE Employees SET Location = ? WHERE Name = ?";
$params = array('Southminster', $userToUpdate);
manipulateDatabase("Updating Name of employee: ", $tsql, $conn, $params, " updated: ");

// Update Existing Query
$locToUpdate = 'Basildon';
$tsql = "UPDATE Employees SET Name = ? WHERE Location = ?";
$params = array('Aha', $locToUpdate);
manipulateDatabase("Updating Location for employee: ", $tsql, $conn, $params, " updated: ");

// Delete Query
$userToDelete = 'Sam';
$tsql = "DELETE FROM Employees WHERE Name = ?";
$params = array($userToDelete);
manipulateDatabase("Deleting user ", $tsql, $conn, $params, " deleted: ");

// Read Query from the table Employees
$tsql = "SELECT Id, Name, Location FROM Employees;";
$getResults = sqlsrv_query($conn, $tsql);
echo ("Reading data from table:" . PHP_EOL . '<br/>');
if ($getResults == FALSE)
  die(FormatErrors(sqlsrv_errors()));
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC))
  echo ($row['Id'] . " " . $row['Name'] . " " . $row['Location'] . PHP_EOL . '<br/>');

// free resource
sqlsrv_free_stmt($getResults);

echo ('<br/><br/>');
// Close the connection.
sqlsrv_close($conn);
echo ("Server connection closed." . PHP_EOL . '<br/>');
?>