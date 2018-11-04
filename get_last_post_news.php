<?php 
   // the query
   $the_query = new WP_Query( array(
     'category_name' => 'news',
      'posts_per_page' => 3,
   )); 
?>

<?php if ( $the_query->have_posts() ) : ?>
  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

      // Title
     <?php the_title(); ?>
     <?php the_excerpt(); ?>

      // link
     <?php echo get_permalink( $post->ID );?>

      // Custom field
     <?= get_post_meta(get_the_ID(),'label_description',true);?>

      // image
     <?php if (has_post_thumbnail( $post->ID ) ): ?>
     <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
     <img src="<?php echo $image[0]; ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" />
     <?php endif; ?>


  <?php endwhile; ?>
  <?php wp_reset_postdata(); ?>

<?php else : ?>
  <p><?php __('No News'); ?></p>
<?php endif; ?>
