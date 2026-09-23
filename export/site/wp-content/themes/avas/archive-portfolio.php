<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*
* Portfolio archives
*
**/

get_header();

$portfolio_layout_cont = tx_get_option('portfolio_archive_layout', 'boxed');
$portfolio_layout      = ($portfolio_layout_cont === 'boxed') ? '' : $portfolio_layout_cont;
$cols                  = tx_get_option('portfolio_archive_columns', '4');
$popup                 = tx_get_option('portfolio_archive_popup', 'content');
$display               = tx_get_option('portfolio_archive_display', 'masonry');
$item_per_page         = tx_get_option('portfolio_archive_item', 9);
$title                 = tx_is_enabled('portfolio_archive_title');
$desc                  = tx_is_enabled('portfolio_archive_excerpt');
$enlarge               = tx_is_enabled('portfolio_archive_enlarge');
$link                  = tx_is_enabled('portfolio_archive_link');
$port_category         = tx_is_enabled('portfolio_archive_category');
$portfolio_filter      = tx_is_enabled('portfolio_archive_filter');
$hover_effects         = tx_get_option('portfolio_archive_hover', 'effects-1');

?>


<div class="container<?php if($portfolio_layout) : echo esc_attr($portfolio_layout); endif; ?> space-content">
  <div class="tx-row">
<?php if($portfolio_filter) : ?>
    <div class="portfolio-filter-wrap">
      <ul class="portfolio-filters">
        <?php
          $terms = get_terms('portfolio-category');
          $terms_count = count($terms); 
        ?>
        <li class="active" data-filter="*"><?php echo esc_html__('All', 'avas'); ?></li>
        <?php if ( $terms_count > 0 ) :
                foreach ( $terms as $term ) :
                  $term_name = strtolower($term->name);
                  $term_name = str_replace(' ', '-', $term_name);
                  echo '<li  data-filter=".'.esc_attr($term_name).'">'.esc_attr($term->name).'</li>';
                endforeach;
              endif;
        ?>
      </ul><!-- /.portfolio-filters -->
    </div> <!-- /.portfolio-filter-wrap -->
  <?php endif; ?>
  <?php
 
  if ( get_query_var('paged') ) :
      $paged = get_query_var('paged');
  elseif ( get_query_var('page') ) :
      $paged = get_query_var('page');
  else :
      $paged = 1;
  endif;
  
  // $pagination = ( $item_per_page ) ? $item_per_page : 12;

  $args = array(
          'post_type'       => 'portfolio',
          'status'          => 'published', 
          'posts_per_page'  => $item_per_page,
          'paged'           => $paged,
    );

  $port_query = new WP_Query( $args );
  ?>

  <div class="tx-portfolio">
    <?php
      if ($port_query->have_posts()) : while ($port_query->have_posts()) : $port_query->the_post();
          
        global $post;
        $terms = get_the_terms( $post->ID, 'portfolio-category' );
        if ( $terms && ! is_wp_error( $terms ) ) :
          $taxonomy = array();
          foreach ( $terms as $term ) :
            $taxonomy[] = $term->name;
          endforeach;
          $cat_name = join( " ", str_replace(' ', '-', $taxonomy));
          $cat_link = get_term_link( $term );
          $cat = strtolower($cat_name);
        else :
          $cat = '';
        endif;


        if ( has_post_thumbnail() ) :
        // $cols = ( $col ) ? $col : 4; ?>

          <div class="col-md-<?php echo esc_attr($cols); ?> <?php echo esc_attr($hover_effects); ?> tx-portfolio-item <?php echo esc_attr($cat); ?>">
            <a href="<?php echo get_the_permalink();?>">
            <div class="tx-port-overlay">

              <div class="tx-port-img">
                <?php
                  $img_url = get_the_post_thumbnail_url(get_the_ID(), '');
                  $img_h_grid = get_the_post_thumbnail_url(get_the_ID(), 'tx-port-grid-h-thumb');
                  $img_v_grid = get_the_post_thumbnail_url(get_the_ID(), 'tx-port-grid-v-thumb');
                ?>
                <?php if($display == 'masonry') : ?>
                  <img src="<?php echo esc_attr($img_url); ?>" alt="<?php echo the_title(); ?>" >
                <?php elseif($display == 'grid-h' || $display == 'card-h') : ?>
                  <img src="<?php echo esc_attr($img_h_grid); ?>" alt="<?php echo the_title(); ?>" >
                <?php elseif($display == 'grid-v' || $display == 'card-v') : ?>
                  <img src="<?php echo esc_attr($img_v_grid); ?>" alt="<?php echo the_title(); ?>" >
                <?php else : ?>
                  <img src="<?php echo esc_attr($img_url); ?>" alt="<?php the_title(); ?>" >
                <?php endif; ?>
              </div><!-- /.tx-port-img -->
            
              <div class="tx-port-overlay-content">
                <div class="tx-port-overlay-content-wrap">

                <?php if( 'masonry' === $display || 'grid-v' === $display || 'grid-h' === $display ) : ?>

                  <?php if(!empty($cat) && $port_category) : ?>
                    <div class="tx-port-cat">
                      <a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_attr($cat); ?></a>
                    </div><!-- /.tx-port-cat -->
                  <?php endif; ?> 
 
                <?php if($title) : ?>
                  <h4 class="tx-port-title"><a href="<?php echo get_the_permalink();?>"><?php the_title(); ?></a></h4>
                <?php endif; ?>
                
                <?php if($desc) : ?>
                  <p class="tx-port-excp"><?php echo esc_html(tx_excerpt_limit(5)); ?></p>  
                <?php endif; ?>
           
              <?php endif; ?>

                <div class="tx-port-enlrg-link">
                  <?php if($enlarge) : ?>
                    <a class="tx-port-enlarge" href="#item-<?php echo get_the_id(); ?>" data-effect="mfp-zoom-in"><i class="bi bi-search"></i></a>
                  <?php endif; ?>

                  <?php if($link) : ?>
                    <a class="tx-port-link" href="<?php echo get_the_permalink(); ?>"><i class="bi bi-link-45deg"></i></a>
                  <?php endif; ?>                
                </div><!-- ./tx-port-enlrg-link -->
                
                </div> <!-- tx-port-overlay-content-wrap -->
              </div><!-- /.tx-port-overlay-content -->
              
            </div><!-- ./tx-port-overlay -->
            </a>

            <?php $img_enlarge = get_the_post_thumbnail(get_the_ID(), 'full'); ?>


                  
            <?php if($popup == 'content') : ?>  
            <div id="item-<?php echo get_the_id(); ?>" class="tx-port-enlrg-content mfp-hide mfp-with-anim">
              <div class="tx-port-enlrg-content-left">
                <?php echo wp_kses_post($img_enlarge); ?>
              </div><!-- /.tx-port-enlrg-content-left -->

              <div class="tx-port-enlrg-content-right">
                <h3 class="tx-port-enlrg-content-title"><?php echo esc_html(the_title());?></h3>
                <div class="tx-port-enlarge-content-desc"><?php echo wp_kses_post( tx_content(75) ); ?></div>
              </div><!-- /.tx-port-enlrg-content-right -->
            </div><!-- /.tx-port-enlrg-content -->
            
            <?php else : ?>
              <div id="item-<?php echo get_the_id(); ?>" class="tx-port-enlrg-content mfp-hide mfp-with-anim">
                <?php echo wp_kses_post($img_enlarge); ?>
              </div>
            <?php endif; ?>

            <?php if( $display == 'card-h' || $display == 'card-v' ): ?>
            <div class="tx-port-card-content">
                <?php if( !empty($cat) && $port_category ) : ?>
                      <div class="tx-port-cat">
                        <a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_attr($cat); ?></a>
                      </div><!-- /.tx-port-cat -->
                    <?php endif; ?>

                <?php if($title) : ?>
                  <h4 class="tx-port-title"><a href="<?php echo get_the_permalink();?>"><?php the_title(); ?></a></h4>
                <?php endif; ?>
                
                <?php if($desc) : ?>
                  <p class="tx-port-excp"><?php echo tx_excerpt_limit(5); ?></p>  
                <?php endif; ?>
                
            </div><!-- tx-port-card-content -->
            <?php endif; ?>
          </div><!-- /.tx-portfolio-item -->

    <?php
        endif;
      endwhile;
      else:  
      get_template_part('template-parts/content/content', 'none');
      endif;
    ?>
  </div><!-- /.tx-portfolio -->

  <?php
    wp_reset_postdata();
  ?>

  <div class="tx-clear"></div>

  <!-- pagination -->
  <?php tx_pagination_number($port_query->max_num_pages,"",$paged); ?>
</div></div>
<?php get_footer();