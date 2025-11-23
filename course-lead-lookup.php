<div class="placeholder-courselead-wrapper">

    <?php
    // Get the course lead name from custom field
    $lead_name = esc_html(get_post_meta(get_the_ID(), 'placeholder_courselead', true));

    if (empty($lead_name)) {
        echo 'Course lead not defined';
        return;
    }

    // Fetch the Team Page where all placeholder team items are stored
    $args = [
        'post_type'      => 'page',
        'pagename'       => 'team',
        'posts_per_page' => 1,
    ];

    $query = new WP_Query($args);
    $dynamic_url = '#';
    $found_match = false;

    if ($query->have_posts()) :
        while ($query->have_posts()) :
            $query->the_post();

            // Loop through team members on the Team Page
            $best_match = null;
            $best_similarity = 0;

            for ($i = 1; $i <= 100; $i++) {
                $item_name = esc_html(get_post_meta(get_the_ID(), "item_{$i}_title", true));

                if (!empty($item_name)) {

                    // Compare names to find closest team member match
                    similar_text($lead_name, $item_name, $percent);

                    if ($percent > $best_similarity) {
                        $best_similarity = $percent;

                        $best_match = [
                            'title'   => $item_name,
                            'subtitle'=> esc_html(get_post_meta(get_the_ID(), "item_{$i}_subtitle", true)),
                            'text'    => esc_html(get_post_meta(get_the_ID(), "item_{$i}_text", true)),
                            'index'   => $i,
                        ];
                    }
                }
            }

            // If a strong match is found, continue processing
            if ($best_match && $best_similarity >= 70) {

                $title = $best_match['title'];
                $subtitle = $best_match['subtitle'];
                $text = $best_match['text'];

                // Clean the name for sorting and indexing
                $clean_match_name = preg_replace('/^(Dr\.|Professor)\s+/i', '', $best_match['title']);

                // Build a sorting array of all team members for consistent ordering
                $list = [];

                for ($j = 1; $j <= 100; $j++) {
                    $name_j = esc_html(get_post_meta(get_the_ID(), "item_{$j}_title", true));
                    if (empty($name_j)) break;

                    $clean_j = preg_replace('/^(Dr\.|Professor)\s+/i', '', $name_j);

                    $list[] = [
                        'title'    => $name_j,
                        'clean'    => $clean_j,
                        'card_id'  => "placeholder-item-" . $j,
                    ];
                }

                // Alphabetical sorting for pagination consistency
                usort($list, function($a, $b) {
                    return strcmp($a['clean'], $b['clean']);
                });

                // Determine which card number the selected team member maps to
                $card_num = null;
                foreach ($list as $index => $entry) {
                    if (strcmp($entry['clean'], $clean_match_name) === 0) {
                        $card_num = $index + 1;
                        break;
                    }
                }

                // Build dynamic URL: return user to Team Page, correct tab and card
                if ($card_num !== null) {

                    $page_num = ceil($card_num / 10);
                    $card_anchor = "placeholder-item-" . $card_num;

                    $dynamic_url =
                        "/team/placeholder-team/?view=placeholder#pg-{$page_num}#{$card_anchor}";

                    $found_match = true;
                }
            }

        endwhile;
    endif;

    wp_reset_postdata();
    ?>

    <?php if ($found_match): ?>

        <!-- Placeholder for the image -->
        <div class="placeholder-courselead-image">
            <?php
            // Basic placeholder image lookup using cleaned name
            $simple_clean = strtolower(str_replace(' ', '-', $clean_match_name));
            $potential_image = "placeholder-{$simple_clean}.webp";

            $upload_dir = wp_upload_dir();
            $final_image = "https://via.placeholder.com/300";

            // Search media folders for a matching VR name
            $start_year = 2024;
            $start_month = 1;
            $current_year = date("Y");
            $current_month = date("m");

            for ($year = $start_year; $year <= $current_year; $year++) {
                for ($month = 1; $month <= 12; $month++) {

                    $folder = "/{$year}/" . str_pad($month, 2, '0', STR_PAD_LEFT) . "/";
                    $path = $upload_dir['basedir'] . $folder . $potential_image;

                    if (file_exists($path)) {
                        $final_image = $upload_dir['baseurl'] . $folder . $potential_image;
                        break 2;
                    }
                }
            }
            ?>

            <img src="<?php echo esc_url($final_image); ?>" alt="Course Lead">
        </div>

        <h3 class="placeholder-courselead-title"><?php echo $title; ?></h3>

        <?php if (!empty($subtitle)): ?>
            <p class="placeholder-courselead-subtitle"><?php echo $subtitle; ?></p>
        <?php endif; ?>

        <?php if (!empty($text)): ?>
            <p class="placeholder-courselead-description"><?php echo $text; ?></p>
        <?php endif; ?>

        <?php if (!empty($text)): ?>
            <a href="<?php echo esc_url($dynamic_url); ?>" class="placeholder-courselead-link" target="_blank">
                View Full Profile
            </a>
        <?php endif; ?>

    <?php endif; ?>

</div>
