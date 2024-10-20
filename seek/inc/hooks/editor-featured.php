<?php
if (!function_exists('seek_editor_featured')) {
    /**
     * Editor Featured Section
     *
     * @since seek 1.0.0
     */
    function seek_editor_featured()
    {
        if (1 !== seek_get_option('show_editorial_featured_news_section')) {
            return;
        }
        ?>
        <div class="twp-editorial-section">
        <div class="container">
            <div class="twp-row">
                <?php if (1 === seek_get_option('show_editorial_choice_section')) { ?>
                    <div class="twp-col-12 twp-col-lg-3">
                        <div class="twp-editorial-full-post-list">
                            <h2 class="twp-section-title">
                                <span class="twp-tag-line twp-tag-line-white"><?php echo esc_html(seek_get_option('editorial_choice_section_title')); ?></span>
                            </h2>
                            <?php
                            $seek_category_editorial_section = esc_attr(seek_get_option('select_category_for_editorial_choice'));
                            $seek_editor_featured_args = array(
                                'post_type' => 'post',
                                'cat' => absint($seek_category_editorial_section),
                                'ignore_sticky_posts' => true,
                                'posts_per_page' => 8,
                            ); ?>
                            <?php
                            $seek_editor_featured_post_query = new WP_Query($seek_editor_featured_args);
                            if ($seek_editor_featured_post_query->have_posts()) :
                                while ($seek_editor_featured_post_query->have_posts()) : $seek_editor_featured_post_query->the_post();
                                    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
                                    $featured_image = isset($featured_image[0]) ? $featured_image[0] : '';
                                    ?>
                                    <div class="twp-list-post twp-d-flex twp-editorial-list-post">
                                        <div class="twp-image-section">
                                            <a href="<?php the_permalink(); ?>"
                                               class="d-block data-bg twp-overlay-image-hover"
                                               data-background="<?php echo esc_url($featured_image); ?>"></a>
                                        </div>
                                        <div class="twp-desc">
                                            <h3 class="twp-post-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            <div class="twp-author-meta">
                                                <?php seek_post_date(); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile;
                            endif;
                            wp_reset_postdata(); ?>
                        </div><!--/twp-editorial-post-list-->
                    </div><!--/col-->
                <?php } ?>
                <?php
                $editor_class = '';
                if (1 !== seek_get_option('show_editorial_choice_section')) {
                    $editor_class = "no-editor-section";
                }
                ?>
                <div class="twp-col-12 twp-col-lg-9 <?php echo esc_attr($editor_class); ?>">
                    <?php
                    $seek_category_featured_section = esc_attr(seek_get_option('select_category_for_featured_Section'));
                    $seek_featured_editor_args = array(
                        'post_type' => 'post',
                        'cat' => absint($seek_category_featured_section),
                        'ignore_sticky_posts' => true,
                        'posts_per_page' => 4,
                    ); ?>
                    <?php
                    $counter = 1;
                    $seek_featured_editor_post_query = new WP_Query($seek_featured_editor_args);
                    if ($seek_featured_editor_post_query->have_posts()) :
                    while ($seek_featured_editor_post_query->have_posts()) :
                    $seek_featured_editor_post_query->the_post();
                    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium_large');
                    $featured_image = isset($featured_image[0]) ? $featured_image[0] : '';
                    ?>
                    <?php if ($counter == 1) { ?>
                    <div class="twp-feature-single-post twp-d-flex">
                        <div class="twp-title-section twp-bg-light-gray">
                            <div class="twp-categories-with-bg twp-categories-with-bg-primary">
                                <?php seek_post_categories(); ?>
                            </div>
                            <h3 class="twp-post-title twp-post-title-lg">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="twp-social-share-section">
                                <div class="twp-author-meta">
                                    <?php seek_post_author(); ?>
                                    <?php seek_post_date(); ?>
                                    <?php seek_get_comments_count(get_the_ID()); ?>
                                </div>
                                <?php
                                if (class_exists('Booster_Extension_Class')) {
                                    do_action('booster_extension_like_dislike', 'allenable');
                                } ?>
                                <?php if (class_exists('Booster_Extension_Class')) {
                                    $args = array('layout' => 'layout-2', 'status' => 'enable');
                                    do_action('booster_extension_social_icons', $args);
                                } ?>
                            </div>
                        </div>
                        <div class="twp-image-section twp-image-hover">
                            <a href="<?php the_permalink(); ?>" class=" data-bg twp-overlay-image-hover" data-background="<?php echo esc_url($featured_image); ?>"></a>
                            <span class="twp-post-format-absolute">
                                <?php echo esc_attr(seek_post_format(get_the_ID())); ?>
                            </span>
                        </div>
                    </div>
                    <?php if ($counter <= 1) { ?>
                    <div class="twp-editorial-post-list">
                        <?php } ?>
                        <?php } else { ?>
                            <div class="twp-editorial-post">
                                <div class="twp-image-section twp-image-hover">
                                    <span class="twp-post-format-absolute"><?php echo esc_html(seek_post_format(get_the_ID())); ?></span>
                                    <a href="<?php the_permalink(); ?>" class="data-bg twp-overlay-image-hover" data-background="<?php echo esc_url($featured_image); ?>"></a>
                                </div>
                                <div class="twp-desc twp-bg-light-gray">
                                    <h3 class="twp-post-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="twp-social-share-section">
                                        <div class="twp-author-meta m-0">
                                            <?php seek_post_date(); ?>
                                        </div>
                                        <?php if (class_exists('Booster_Extension_Class')) {
                                            $args = array('layout' => 'layout-2', 'status' => 'enable');
                                            do_action('booster_extension_social_icons', $args);
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($counter == 4) {
                            echo '</div>';
                        } ?>
                        <?php
                        $counter++;
                        endwhile;
                        endif;
                        wp_reset_postdata(); ?>
                    </div><!--/col-->
                </div><!--/twp-row-->
            </div><!--/container-->
        </div><!--/twp-editorial-section-->
        <?php
    }
}
add_action('seek_action_editor_featured_section', 'seek_editor_featured', 10);
