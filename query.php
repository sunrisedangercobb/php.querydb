<?php

function Query($sql)
{
  $db_conn = mysqli_connect('hostname', 'user', 'pass', 'database');

  if (!$db_conn) {
    echo "Can't connect to localhost. Error: " . mysqli_connect_error();
    exit();
  }

  // Turn on auto-commit
  mysqli_autocommit($db_conn, TRUE);

  $db_result = mysqli_query($db_conn, $sql);

  if (!$db_result) {
    // Close the connection
    mysqli_close($db_conn);
    return null;
  }

    $result = null;

    $part_1 = explode(' ', strtoupper($sql));

    if ($part_1[0] === 'SELECT') {
      $result = array();

      for ($i = 0; $i < mysqli_num_rows($db_result); $i++)
      {
        $row = mysqli_fetch_assoc($db_result);
        $result[$i] = $row;
      }
    }

    else if ($part_1[0] === 'INSERT') {
        $result = mysqli_insert_id($db_conn);
        error_log("insert last id $result");
    }

  // Close the connection
  mysqli_close($db_conn);

  return $result;
}


function SanitizeSQL($value)
{
  $value = ''.$value;
  $value = str_replace("'", "''", $value);
  return $value;
}


function SanitizeOrNull($value)
{
  if ($value === null || $value === "")
  {
    return "NULL";
  }

  $value = "'".SanitizeSQL($value)."'";

  return $value;
}

function NumberOrNull($value)
{
  if ($value === null || $value === "")
  {
    return "NULL";
  }

  return $value;
}
?>
