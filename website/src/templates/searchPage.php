<?php require "utils/search.php" ?>

<?php $templateParams["title"] = "Search Results" ?>

<div class="container mt-md-3">
    <div class="row">
        <!-- Sidebar for filters -->
        <div class="col-md-3 mt-0">
            <div class="fs-4 my-2">Filters</div>
            <form method="GET" action="search">
                <input type="hidden" name="q" value="<?php echo $searchQuery; ?>">
                <div class="d-md-block d-flex flex-wrap">
                    <?php foreach ($categories as $category): ?>
                        <div class="form-check me-3 mb-1">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="filters[]"
                                value="<?php echo $category; ?>"
                                id="filter-<?php echo str_replace(' ', '-', strtolower($category)); ?>"
                                <?php echo in_array($category, $filters) ? "checked" : ""; ?>>
                            <label class="form-check-label" for="filter-<?php echo str_replace(' ', '-', strtolower($category)); ?>">
                                <?php echo $category; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="d-flex justify-content-center justify-content-md-start">
                    <button type="submit" class="btn btn-primary mt-2 mb-4">Apply Filters</button>
                </div>
            </form>
        </div>

        <!-- Main content -->
        <div class="col-md-9">
            <div class="page-title-text mb-4">Search results for
                <?php
                echo empty($searchQuery) ? "all products" : '"' . $searchQuery . '"';
                if (sizeof($filters) > 0) {
                    echo ' in "' . implode(', ', $filters) . '"';
                } else {
                    echo ' in all categories';
                }
                ?>
            </div>

            <?php if (empty($searchResults)): ?>
                <p>No results found. Try refining your search.</p>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($searchResults as $article): ?>
                        <div class="col-6 col-md-3">
                            <?php require("components/itemCard.php") ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
