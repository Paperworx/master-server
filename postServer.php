<?php
  require_once 'config.php';

  function addServer($ip, $port, $passworded, $dedicated, $servername, $players, $maxplayers, $mapname, $brickcount)
  {
    if (!file_exists(SERVER_DATABASE))
    {
      $database = new SQLite3(SERVER_DATABASE);
      $database->exec('CREATE TABLE master (ip VARCHAR(45) NOT NULL, port VARCHAR(5) NOT NULL, passworded BOOLEAN NOT NULL, dedicated BOOLEAN NOT NULL, servername VARCHAR(48) NOT NULL, players INT(3) NOT NULL, maxplayers INT(3) NOT NULL, mapname VARCHAR(32) NOT NULL, brickcount INT(7) NOT NULL, lastupdate INT(10) NOT NULL)');
    }
    else
    {
      $database = new SQLite3(SERVER_DATABASE);
    }

    $stmt1 = $database->prepare('SELECT * FROM master WHERE ip = :ip AND port = :port');
    $stmt1->bindValue(':ip', $ip, SQLITE3_TEXT);
    $stmt1->bindValue(':port', $port, SQLITE3_TEXT);
    $result = $stmt1->execute();
    $result = $result->fetchArray();
    $stmt1->close();

    if (sizeof($result) > 1)
      $stmt2 = $database->prepare('UPDATE master SET passworded = :passworded, dedicated = :dedicated, servername = :servername, players = :players, maxplayers = :maxplayers, mapname = :mapname, brickcount = :brickcount, lastupdate = :lastupdate WHERE ip = :ip AND port = :port');
    else
      $stmt2 = $database->prepare('INSERT INTO master (ip, port, passworded, dedicated, servername, players, maxplayers, mapname, brickcount, lastupdate) VALUES (:ip, :port, :passworded, :dedicated, :servername, :players, :maxplayers, :mapname, :brickcount, :lastupdate)');

    $stmt2->bindValue(':ip', $ip, SQLITE3_TEXT);
    $stmt2->bindValue(':port', $port, SQLITE3_TEXT);
    $stmt2->bindValue(':passworded', $passworded, SQLITE3_INTEGER);
    $stmt2->bindValue(':dedicated', $dedicated, SQLITE3_INTEGER);
    $stmt2->bindValue(':servername', $servername, SQLITE3_TEXT);
    $stmt2->bindValue(':players', $players, SQLITE3_TEXT);
    $stmt2->bindValue(':maxplayers', $maxplayers, SQLITE3_TEXT);
    $stmt2->bindValue(':mapname', $mapname, SQLITE3_TEXT);
    $stmt2->bindValue(':brickcount', $brickcount, SQLITE3_INTEGER);
    $stmt2->bindValue(':lastupdate', time(), SQLITE3_INTEGER);
    $stmt2->execute();
    $stmt2->close();
  }

  $ip = $_SERVER['REMOTE_ADDR'];
  $port = $_POST['Port'];
  $blid = $_POST['blid'];
  $passworded = $_POST['Passworded'] ? 1 : 0;
  $dedicated = $_POST['Dedicated'] ? 1 : 0;
  $servername = $_POST['ServerName'];
  $players = intval($_POST['Players']);
  $maxplayers = intval($_POST['MaxPlayers']);
  $mapname = $_POST['Map'];
  $brickcount = intval($_POST['BrickCount']);
  $version = intval($_POST['ver']);

  if (is_nan($blid) || $blid < 0)
    die("FAIL invalid blid\r\n");

  if (is_nan($port) || $port < 1 || $port > 65535)
    die("FAIL invalid port\r\n");

  if ($players > 999)
    die("FAIL invalid playercount\r\n");

  if (strlen($servername) > 48)
    $servername = substr($servername, 0, 48);

  if (is_nan($players) || $players < 0)
    $players = 0;

  if ($maxplayers > 999)
    die("FAIL invalid max playercount\r\n");

  if (is_nan($maxplayers) || $maxplayers < 0)
    $maxplayers = 0;

  if (strlen($mapname) > 32)
    $mapname = substr($mapname, 0, 32);

  if ($brickcount > 9999999)
    die("FAIL invalid brickcount\r\n");

  if (is_nan($brickcount) || $brickcount < 0)
    $brickcount = 0;

  if (is_nan($version))
    die("FAIL invalid version\r\n");

  if ($version !== SERVER_VERSION)
    die("FAIL v" . SERVER_VERSION . " servers only\r\n");

  addServer($ip, $port, $passworded, $dedicated, $servername, $players, $maxplayers, $mapname, $brickcount);
?>