<?php
/**
 * The template for displaying all pages.
 *
 * @package Theme Freesia
 * @subpackage Edge
 * @since Edge 1.0
 */

get_header(2);
	$edge_settings = edge_get_theme_options();
	global $edge_content_layout;
	if( $post ) {
		$layout = get_post_meta( $post->ID, 'edge_sidebarlayout', true );
	}
	if( empty( $layout ) || is_archive() || is_search() || is_home() ) {
		$layout = 'default';
	}
	if( 'default' == $layout ) { //Settings from customizer
		if(($edge_settings['edge_sidebar_layout_options'] != 'nosidebar') && ($edge_settings['edge_sidebar_layout_options'] != 'fullwidth')){ ?>

<div id="primary">
<?php }
	}else{ // for page/ post
		if(($layout != 'no-sidebar') && ($layout != 'full-width')){ ?>
<div id="primary">
	<?php }
	}?>
	<main id="main" class="monodukuri-mag">

		<h1><img src="<?php echo get_stylesheet_directory_uri().'/images/magazine_logo.png'; ?>" alt="ものづくりmagazin"><h1>

		<div class="monodukuri_mag_col">

		<?php include_once( ABSPATH . WPINC . '/feed.php' ); $feeduri = 'https://techtrage.jp/'; $rss = fetch_feed($feeduri); if (!is_wp_error($rss)) { $maxitems = $rss->get_item_quantity(8); $rss_items = $rss->get_items( 0, $maxitems ); } 


		foreach ( $rss_items as $item ) : ?> 

			<div class="monodukuri_mag_in">


			<!-- 記事へのリンクを表示 --> <a href="<?php echo $item->get_permalink(); ?>"> 

				<!-- 記事の最初の画像を表示 --> <?php $first_img = ''; if ( preg_match( '/<img.+?src=[\'"]([^\'"]+?)[\'"].*?>/msi', $item->get_content(), $matches ) ) { $first_img = $matches[1]; } ?> <img src="<?php echo esc_attr( $first_img ); ?>" alt=""> 

			
				<!-- 投稿日を表示 --> <?php $item_date = $item->get_date(); $date = date('Y/m/d',strtotime( $item_date )); ?> <p class="date"><?php echo $date; ?></p> 

				<!-- 記事タイトルを表示 --> <?php $title = $item->get_title(); if(mb_strlen( $title ) > 200 ): ?> <p class="title"><?php echo mb_substr( $title,0,200 );?>...</p> <?php else : ?> <p class="title"><?php echo $title ;?></p> <?php endif; ?></a>  

			</div><!-- //monodukuri_mag_in -->	

		<?php endforeach; wp_reset_postdata(); ?> 

		</div><!-- //monodukuri_mag_col -->
		

	<?php
	if( has_post_thumbnail() && $edge_settings['edge_display_page_featured_image']!=0) { ?>
		<div class="post-image-content">
			<figure class="post-featured-image">
				<a href="<?php the_permalink();?>" title="<?php echo the_title_attribute('echo=0'); ?>">
				<?php the_post_thumbnail(); ?>
				</a>
			</figure><!-- end.post-featured-image  -->
		</div> <!-- end.post-image-content -->
	<?php }
	if( have_posts() ) {
		while( have_posts() ) {
			the_post(); ?>
	<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<article>
		<div class="entry-content clearfix">
			<?php the_content();
				wp_link_pages( array( 
				'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'edge' ),
				'after'             => '</div>',
				'link_before'       => '<span>',
				'link_after'        => '</span>',
				'pagelink'          => '%',
				'echo'              => 1
				) ); ?>
		</div> <!-- entry-content clearfix-->
		<?php  comments_template(); ?>
		</article>
	</section>
	<?php }
	} else { ?>
	<h1 class="entry-title"> <?php esc_html_e( 'No Posts Found.', 'edge' ); ?> </h1>
	<?php
	} ?>
	</main> <!-- #main -->
	<?php 
if( 'default' == $layout ) { //Settings from customizer
	if(($edge_settings['edge_sidebar_layout_options'] != 'nosidebar') && ($edge_settings['edge_sidebar_layout_options'] != 'fullwidth')): ?>
</div> <!-- #primary -->
<?php endif;
}else{ // for page/post
	if(($layout != 'no-sidebar') && ($layout != 'full-width')){
		echo '</div><!-- #primary -->';
	} 
}
get_sidebar();
get_footer();