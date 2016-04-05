<?php

class CacheStatus {
     private $_post;
     private $_cached_by_category;
     private $_post_status;

     private $_labels;

     function __construct(WP_Post $post) {
          $this->_post = $post;
          $this->_labels= array(
               __( 'Explicitely: no' ),
               __( 'Explicitely: yes' ),
               __( 'From category: no' ),
               __( 'From category: yes' )
          );

     }

     function status() {
          $post_status = $this->post_status();
          if ( $post_status === NULL ) {
               if ( $this->is_cached_by_category() ) {
                    return 3;
               } else {
                    return 2;
               }
          }
          return $post_status;
     }

     function short_status() {
         $status = $this->status();
         if ( $status > 2) {
             return 2;
         }
         return $status;
     }

    function post_status() {
        if ( ! isset( $this->_post_status ) ) {
             $meta = get_post_meta( $this->_post->ID, '_wpc_cached', true );
             $this->_post_status = NULL;
             if ( $meta === 0 || $meta === '0' ) {
                  $this->_post_status = 0;
             } elseif ( $meta === 1 || $meta === '1' ) {
                  $this->_post_status = 1;
             }
        }
        return $this->_post_status;
    }

     function is_cached_by_category() {
         if ( ! isset( $this->_cached_by_category ) ) {
              $post_categories = wp_get_post_categories( $this->_post->ID );
              $cached_categories = get_option( 'wpc_cached_categories', Array() );

              if ( ! $cached_categories ) {
                  $cached_categories = Array();
              }

              $common_categories = array_intersect( $post_categories, $cached_categories );

              $this->_cached_by_category = count( $common_categories ) > 0;
         }
         return $this->_cached_by_category;
    }

    function display( $status = NULL ) {
        if ( $status == NULL ) {
             $status = $this->status();
        }
        return $this->_labels[$status];
    }

    function choice_display( $status ) {
        if ( $status == 2) {
            if ( $this->is_cached_by_category() ) {
                 return $this->_labels[3];
            }
        }
        return $this->_labels[$status];
    }
}


function wpc_post_submitbox_misc_actions( $post ){
    $cache_status = new CacheStatus( $post );
    ?>
<div class="misc-pub-section misc-pub-post-cache" id="cacheability">
<span class="dashicons dashicons-portfolio wp-media-buttons-icon"></span>&nbsp;
        <?php
        echo __( 'Cache' );
        ?> &nbsp;:&nbsp;<b id="cacheability-label">
        <?php
        echo $cache_status->display();
        ?></b>
        <a href="#cacheability" class="edit-cacheability hide-if-no-js"><span aria-hidden="true">
        Modifier
        </span> <span class="screen-reader-text">
        Modifier la visibilit
        </span></a>
        <div id="post-cacheability-select" class="hide-if-js">
            <input type="hidden" name="initial-cacheability" id="hidden-post-cacheabililty" value="<?php echo $cache_status->short_status(); ?>">
            <input type="radio" name="cacheability" id="cacheability-radio-0" value="0" <?php checked( 0, $cache_status->status() ); ?>> <label for="cacheability-radio-0" class="selectit"><?php echo $cache_status->choice_display(0) ?></label><br>
            <input type="radio" name="cacheability" id="cacheability-radio-1" value="1" <?php checked( 1, $cache_status->status() ); ?>> <label for="cacheability-radio-1" class="selectit"><?php echo $cache_status->choice_display(1) ?></label><br>
            <input type="radio" name="cacheability" id="cacheability-radio-2" value="2" <?php checked( 2, $cache_status->short_status() ); ?>> <label for="cacheability-radio-2" class="selectit"><?php echo $cache_status->choice_display(2) ?></label><br>

            <p>
               <a href="#cacheability" class="save-post-cacheability hide-if-no-js button"><?php echo __( 'OK' ); ?></a>
               <a href="#cacheability" class="cancel-post-cacheability hide-if-no-js button-cancel"><?php echo __( 'Cancel' ); ?></a>
            </p>
        </div>
</div>
<?php
}


function wpc_save_post($post_ID){
    if(isset($_POST['cacheability'])){
         switch($_POST['cacheability']) {
             case 0:
             if ( ! add_post_meta( $post_ID, '_wpc_cached', $_POST['cacheability'], true ) ) {
                  update_post_meta( $post_ID, '_wpc_cached', $_POST['cacheability'] );
             }
             break;
             case 1:
             if ( ! add_post_meta( $post_ID, '_wpc_cached', $_POST['cacheability'], true ) ) {
                  update_post_meta( $post_ID, '_wpc_cached', $_POST['cacheability'] );
             }
             break;
             case 2:
             delete_post_meta( $post_ID, '_wpc_cached' );
             break;
         }
    }
}


function wpc_posts_run( $version = '1.0.0') {
	wp_enqueue_script( 'ẃpc-posts-js', plugin_dir_url( __FILE__ ) . 'wpc_posts.js', array( 'jquery' ), $version, false );
	add_action( 'post_submitbox_misc_actions', 'wpc_post_submitbox_misc_actions' );
	add_action('save_post','wpc_save_post');
}

?>