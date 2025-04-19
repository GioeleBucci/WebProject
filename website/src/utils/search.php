<?php
$searchResults = [];
$searchQuery = isset($_GET["q"]) ? trim($_GET["q"]) : "";
$filters = isset($_GET["filters"]) && is_array($_GET["filters"]) ? $_GET["filters"] : [];

// Sanitize search query and filters
$searchQuery = htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8');
$filters = array_map(function ($filter) {
    return htmlspecialchars($filter, ENT_QUOTES, 'UTF-8');
}, $filters);

$categories = $dbh->getCategoryNames();

$searchResults = $dbh->searchBy($searchQuery, ...$filters);
