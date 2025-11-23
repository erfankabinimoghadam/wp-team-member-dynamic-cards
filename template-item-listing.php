<section class="placeholder-section d-none" id="placeholder-group">
    <div class="placeholder-container">

        <?php
        // Collect items from post meta fields using sequential numbering
        $items = [];
        $i = 1;

        while (true) {
            // Main title field; if empty, end loop
            $title = esc_html(get_post_meta(get_the_ID(), "item_{$i}_title", true));
            if (empty($title)) break;

            // Remove prefixes for sorting purposes only
            $clean_name = preg_replace('/^(Dr\.|Professor)\s+/i', '', $title);

            // Build item array
            $items[] = [
                'title' => $title,
                'clean_title' => $clean_name,
                'subtitle' => esc_html(get_post_meta(get_the_ID(), "item_{$i}_subtitle", true)),
                'image' => esc_html(get_post_meta(get_the_ID(), "item_{$i}_image", true)) ?: 'https://via.placeholder.com/150',
                'paragraph' => esc_html(get_post_meta(get_the_ID(), "item_{$i}_text", true)),
            ];

            $i++;
        }

        // Sort alphabetically using cleaned name
        usort($items, function($a, $b) {
            return strcmp($a['clean_title'], $b['clean_title']);
        });

        // Pagination setup
        $items_per_page = 10;
        $current_page = max(1, get_query_var('paged', 1));
        $offset = ($current_page - 1) * $items_per_page;
        $total_items = count($items);

        // Output items
        foreach ($items as $index => $item) {
            // Only show items belonging to current page
            $visible = ($index >= $offset && $index < ($offset + $items_per_page)) ? '' : 'd-none';
        ?>

        <!-- Single Item -->
        <div class="placeholder-item <?php echo $visible; ?>" id="placeholder-item-<?php echo $index + 1; ?>">
            <div class="placeholder-content">

                <!-- Basic item image -->
                <img src="<?php echo $item['image']; ?>" alt="" class="placeholder-image">

                <!-- Text block -->
                <div class="placeholder-text">
                    <h3><?php echo $item['title']; ?></h3>
                    <p><?php echo $item['subtitle']; ?></p>

                    <!-- Toggle paragraph availability -->
                    <?php if (!empty($item['paragraph'])) : ?>
                        <a class="placeholder-readmore" data-target="#placeholder-hidden-<?php echo $index + 1; ?>">Read More</a>
                    <?php endif; ?>

                    <!-- Hidden paragraph -->
                    <div class="placeholder-hidden d-none" id="placeholder-hidden-<?php echo $index + 1; ?>">
                        <p><?php echo $item['paragraph']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <?php } ?>

        <!-- Pagination Links -->
        <?php if ($total_items > $items_per_page) : ?>
            <nav>
                <ul class="placeholder-pagination">

                    <?php
                    $total_pages = ceil($total_items / $items_per_page);

                    // Create numbered pagination controls
                    for ($page = 1; $page <= $total_pages; $page++) {
                        $active = ($page === $current_page) ? 'active' : '';
                        echo '<li><a href="#pg-' . $page . '" class="placeholder-page-link ' . $active . '" data-page="' . $page . '">' . $page . '</a></li>';
                    }
                    ?>

                </ul>
            </nav>
        <?php endif; ?>

    </div>
</section>
