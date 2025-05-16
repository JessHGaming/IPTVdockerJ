<?php
session_start();

$dbFile = __DIR__ . '/db/database.sqlite';
if (!file_exists(dirname($dbFile))) {
    mkdir(dirname($dbFile), 0755, true);
}

$db = new PDO("sqlite:$dbFile");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT,
    role TEXT DEFAULT 'user',
    iptv_user TEXT,
    iptv_pass TEXT
)");
