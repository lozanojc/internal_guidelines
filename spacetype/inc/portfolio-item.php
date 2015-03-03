<?php
    $portfolio_type = of_get_option( 'sn_portfolio_type' );
    $portfolio_type_a = explode( '_', $portfolio_type );
    $portfolio_title = of_get_option( 'sn_portfolio_title' );
    $col = 'col col-1-' . $portfolio_type_a[0];
    $portfolio_filter = wp_get_object_terms($post->ID, 'sn_portfolio_category');
    $filter_class = '';
    if (!empty($portfolio_filter)) {
        foreach ( $portfolio_filter as $item ) {
            $filter_class .= 'cat-' . $item->slug . ' ';
        }
    }

?>

            <article <?php post_class( $col . ' ' . $filter_class ) ?>>
                <?php if ( $portfolio_title == 'bottom' ) : ?>
                <a href="<?php the_permalink(); ?>">
                    <p class="img-content">
                        <?php
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'portfolio_' . $portfolio_type_a[0] );
                            }
                        ?>
                        <span class="caption">
                            <span class="holder">
                                <span class="text">
                                    <span class="icon icon-hover-plus"></span>
                                </span>
                            </span>
                        </span>
                    </p>
                    <p class="small"><?php the_title(); ?></p>
                </a>
                <?php else : ?>
                <a href="<?php the_permalink(); ?>">
                    <p class="img-content">
                        <?php
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'portfolio_' . $portfolio_type_a[0] );
                            }
                        ?>
                        <span class="caption"></span>
                    </p>
                </a>
                <?php endif; ?>

            </article>