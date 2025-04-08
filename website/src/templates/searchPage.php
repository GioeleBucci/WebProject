<?php $templateParams["title"] = "Search Results" ?>

<?php
$searchResults = [];
$searchQuery = isset($_GET["q"]) ? trim($_GET["q"]) : "";
$filters = isset($_GET["filters"]) && is_array($_GET["filters"]) ? $_GET["filters"] : [];
$categories = $dbh->getCategories();

if (!empty($searchQuery) || !empty($filters)) {
    $searchResults = $dbh->searchBy($searchQuery, ...$filters);
}
?>

<div class="container mt-md-3">
    <div class="row">
        <!-- Sidebar for filters -->
        <div class="col-md-3">
            <h4>Filters</h4>
            <form method="GET" action="search">
                <input type="hidden" name="q" value="<?php echo htmlspecialchars($searchQuery); ?>">
                <?php foreach ($categories as $category): ?>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="filters[]"
                            value="<?php echo $category["name"]; ?>"
                            id="filter-<?php echo $category["name"] ?>"
                            <?php echo in_array($category["name"], $filters) ? "checked" : ""; ?>>
                        <label class="form-check-label" for="filter-<?php echo $category["name"]; ?>">
                            <?php echo $category["name"]; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary mt-3">Apply Filters</button>
            </form>
        </div>

        <!-- Main content -->
        <div class="col-md-9">
            <h2 class="mb-4">Search results for
                <?php
                if (empty($searchQuery)) {
                    echo "all products";
                }
                if (sizeof($filters) > 0) {
                    echo ' in "' . implode(', ', $filters) . '"';
                } else if (!empty($searchQuery)) {
                    echo '"' . $searchQuery . '"';
                }
                ?>
            </h2>

            <?php if (empty($searchResults)): ?>
                <p>No results found. Try refining your search.</p>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($searchResults as $prod): ?>
                        <div class="col-6 col-md-3">
                            <?php require("components/itemCard.php") ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>