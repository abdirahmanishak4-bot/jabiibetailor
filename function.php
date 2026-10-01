<?php
/* $baseurl = "http://demo.tailor.sarutech.com";	
$dbname = "osaru_demo_tailor";
$dbhost = "localhost";
$dbuser = "osaru_tech";
$dbpass = "Sr123Th24"; */


$dbhost = getenv('MYSQLHOST') ?: "localhost";
$dbport = getenv('MYSQLPORT') ?: "3306";
$dbname = getenv('MYSQLDATABASE') ?: "tailor";
$dbuser = getenv('MYSQLUSER') ?: "root";
$dbpass = getenv('MYSQLPASSWORD') !== false ? getenv('MYSQLPASSWORD') : "";

// If MYSQL_URL or DATABASE_URL is set, parse it
$dburl = getenv('MYSQL_URL') ?: getenv('DATABASE_URL');
if (!empty($dburl)) {
	$parsed = parse_url($dburl);
	if ($parsed) {
		if (!empty($parsed['host'])) $dbhost = $parsed['host'];
		if (!empty($parsed['port'])) $dbport = $parsed['port'];
		if (!empty($parsed['user'])) $dbuser = $parsed['user'];
		if (isset($parsed['pass']))  $dbpass = $parsed['pass'];
		if (!empty($parsed['path'])) $dbname = ltrim($parsed['path'], '/');
	}
}

// Auto-detect baseurl
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
$protocol = $isHttps ? "https" : "http";
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$baseurl = $protocol . "://" . $host . "/";

error_reporting(E_ALL);
function connectdb()
{
    global $dbname, $dbuser, $dbhost, $dbpass, $dbport;
    $conms = @mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, (int)$dbport);
    if(!$conms) return false;
    mysqli_set_charset($conms, 'utf8');
    return true;
}

function dbconnect()
{
	global $pdo, $dbhost, $dbport, $dbname, $dbuser, $dbpass;

	try {
		$dsn = 'mysql:host='.$dbhost.';port='.$dbport.';dbname='.$dbname.';charset=utf8';
		$pdo = new PDO($dsn, $dbuser, $dbpass, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::MYSQL_ATTR_MULTI_STATEMENTS => true,
		]);
		
		// Auto-create tables from tailor.sql if users table is not yet present
		init_database_if_needed();
	} catch (PDOException $e) {
		die('MySQL connection fail! ' . $e->getMessage());
	}
}

function init_database_if_needed()
{
	global $pdo;
	try {
		$check = $pdo->query("SHOW TABLES LIKE 'users'");
		if ($check && $check->rowCount() == 0) {
			$sqlFile = __DIR__ . '/tailor.sql';
			if (file_exists($sqlFile)) {
				$sql = file_get_contents($sqlFile);
				$pdo->exec($sql);
			}
		}
	} catch (Exception $e) {
		// Ignore if tables exist
	}
}


function insert_new_user($username, $password)
{
	# checking username is already taken
	if (username_exists($username))
		return false;

	# insert new user info
	global $pdo;
	$stmt = $pdo->prepare('
		INSERT INTO users
		(username, password)
		values (:username, :password)');

	$stmt->execute( array(':username' => $username, ':password' => md5($password)) );

	if ($pdo->lastInsertId())
		return true;
	else
		return false;
}

function username_exists($username)
{
	global $pdo;
	
	$stmt = $pdo->prepare('
		SELECT id
		FROM users
		WHERE username = :username
		LIMIT 1');

	$stmt->execute( array('username' => $username) );
	return $stmt->fetchColumn();
}

function attempt($username, $password)
{
	global $pdo;
	
	$stmt = $pdo->prepare('
		SELECT id, username
		FROM users
		WHERE username = :username AND password = :password
		LIMIT 1');

	$stmt->execute(array(':username' => $username, 'password' => md5($password)));

	if ($data = $stmt->fetch( PDO::FETCH_OBJ )) {
		# set session
		$_SESSION['username'] = $data->username;
		return true;
	} else {
		return false;
	}
}

function is_user()
{
	if (isset($_SESSION['username']))
		return true;
}

function redirect($url)
{
	header('Location: ' .$url);
	exit;
}

function valid_username($str){
	return preg_match('/^[a-z0-9_-]{3,16}$/', $str);
}

function valid_password($str){
	return preg_match('/^[a-z0-9_-]{6,18}$/', $str);
}





?>