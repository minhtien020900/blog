<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fashion Photography
 */
?>

<div class="col-lg-6 col-md-6 col-sm-6">
    <article id="post-<?php the_ID(); ?>" <?php post_class('article-box'); ?>>
        <?php fashion_photography_post_thumbnail(); ?>
        <header class="entry-header">
            <?php the_title('<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>');?>
        </header>
        <div class="entry-summary">
            <?php
                the_excerpt();

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'fashion-photography'),
                    'after' => '</div>',
                ));
            ?>
        </div>
        <footer class="entry-footer">
            <?php fashion_photography_entry_footer(); ?>
        </footer>
    </article>
</div>