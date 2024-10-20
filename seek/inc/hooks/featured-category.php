<?php
if (!function_exists('seek_footer_category_post')) :
    /**
     * Featued Category Section
     *
     * @since seek 1.0.0
     *
     */
    function seek_footer_category_post()
    {
        if (1 != seek_get_option('show_featured_category_section')) {
            return null;
        }
        ?>
        <div class="twp-featured-category-post-list">
            <div class="container">
                <div class="twp-row">
                    <?php
                    global $post;
                    for ($i=1; $i <= 3 ; $i++) { 
                    $category_id = absint(seek_get_option('select_category_for_featured_category_'. $i)) ;
                    $number_of_category_posts = absint(seek_get_option('number_of_post_featured_category')) ;
                        $seek_category_post_args = array(
                            'category__in' => $category_id,
                            'posts_per_page' => $number_of_category_posts, // Number of category posts to display.
                            'ignore_sticky_posts' => 1
                        ); ?>
                        <div class="twp-col-4">
                           
                            <?php if (!empty($category_id)) { ?>
                                <h2 class="twp-section-title twp-title-with-dashed"><a href="<?php echo esc_url(get_category_link( $category_id ))?>"><?php echo esc_html(get_cat_name($category_id))?></a></h2>
                            <?php } ?>
                            <ul class="twp-category-post-list twp-bg-light-gray">
                                <?php 
                                $seek_featured_category_query = new WP_Query($seek_category_post_args);
                                $counter = 0;
                                if ($seek_featured_category_query->have_posts()) :
                                    while ($seek_featured_category_query->have_posts()) : $seek_featured_category_query->the_post();
                                        $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
                                        $featured_image = isset($featured_image[0]) ? $featured_image[0] : '';
                                        ?>
                                        <?php
                                        if ($counter == 0) { ?>
                                            <?php
                                            $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium_large');
                                            $featured_image = isset($featured_image[0]) ? $featured_image[0] : '';
                                            ?>
                                            <li class="twp-full-post twp-full-post-md data-bg twp-overlay-image-hover" data-background="<?php echo esc_url($featured_image); ?>">
                                                <a class="img-link" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>" tabindex="0"></a>
                                                <span class="twp-post-format-absolute">
                                                    <?php echo esc_attr(seek_post_format(get_the_ID())); ?>
                                                </span>
                                                <div class="twp-wrapper twp-overlay twp-w-100">
                                                    <div class="twp-categories-with-bg twp-categories-with-bg-primary">
                                                        <?php seek_post_categories(); ?>
                                                    </div>
                                                    <h3 class="twp-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                    <div class="twp-social-share-section">
                                                        <div class="twp-author-meta m-0">
                                                            <?php seek_post_author(); ?>
                                                            <?php seek_post_date(); ?>
                                                            <?php seek_get_comments_count(get_the_ID()); ?>
                                                        </div>
                                                        <?php if( class_exists( 'Booster_Extension_Class') ){
                                                            $args = array('layout'=>'layout-2','status' => 'enable');
                                                            do_action('booster_extension_social_icons',$args);
                                                        } ?>

                                                    </div>
                                                </div>
                                            </li>
                                            <?php 
                                            if (has_excerpt()) { ?>
                                                <div class="twp-caption">
                                                    <?php the_excerpt(); ?>
                                                </div>
                                            <?php } ?>
                                        <?php $counter++; } else { ?>
                                                <li class="twp-list-post twp-d-flex">
                                                    <div class="twp-image-section twp-image-hover">
                                                        <a href="<?php the_permalink(); ?>" class="data-bg d-block" data-background="<?php echo esc_url($featured_image); ?>"></a>
                                                    </div>
                                                    <div class="twp-desc">
                                                        <h3 class="twp-post-title twp-post-title-sm"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                        <div class="twp-author-meta">
                                                            <?php seek_post_date(); ?>
                                                        </div>
                                                    </div>
                                                </li>
                                        <?php
                                        $counter++;
                                    }
                                        endwhile;
                                endif; 
                                wp_reset_postdata(); 
                                ?>
                            </ul>
                            
                        </div><!--col-->
                    <?php } ?>
                </div><!--/row-->
            </div><!--/container-->
        </div><!--/twp-news-main-section-->
        <?php
}  
endif;
add_action('seek_action_category_list_post', 'seek_footer_category_post', 10);
