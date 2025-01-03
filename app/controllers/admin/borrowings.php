<?php

require_once 'app/helpers/errors.php';
require_once 'app/helpers/Database.php';
require_once 'app/models/Book.php';

$config = require 'app/config/database.php';
$db = new Database($config['username'], $config['password'], $config['database']);

if (!$db->connect()) {
    abort(500);
}

$booksMngr = new Book($db);
$borrowings = $booksMngr->getAllBorrowed();
$borrowings = array_filter($borrowings, function ($borrowing) {
    return $borrowing['returned_at'] === null;
});
$borrowRequests = $booksMngr->getAllPendingBorrowReqs();

require 'app/views/admin/borrowings.php';
