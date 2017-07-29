<?php
  require_once 'config.php';

  header('Content-Type: text/plain');

  echo "FIELDS\tIP\tPORT\tPASSWORDED\tDEDICATED\tSERVERNAME\tPLAYERS\tMAXPLAYERS\tMAPNAME\tBRICKCOUNT\r\n";
  echo "START\r\n";

  if (file_exists(SERVER_DATABASE))
  {
    $database = new SQLite3(SERVER_DATABASE);
    $statement = $database->prepare('DELETE FROM master WHERE lastupdate + :timeout < :time');
    $statement->bindValue(':timeout', SERVER_TIMEOUT, SQLITE3_INTEGER);
    $statement->bindValue(':time', time(), SQLITE3_INTEGER);
    $statement->execute();
    $statement->close();

    $statement = $database->prepare('SELECT * FROM master');
    $results = $statement->execute();

    while ($row = $results->fetchArray())
    {
      echo "{$row['ip']}\t{$row['port']}\t{$row['passworded']}\t{$row['dedicated']}\t{$row['servername']}\t{$row['players']}\t{$row['maxplayers']}\t{$row['mapname']}\t{$row['brickcount']}\r\n";
    }

    $statement->close();
  }

  echo "END\r\n";
?>