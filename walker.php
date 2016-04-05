<?php
require_once( ABSPATH . 'wp-admin/includes/class-walker-category-checklist.php' );

class Walker_Cached_Category extends Walker_Category_Checklist {
    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        if ( empty( $args['taxonomy'] ) ) {
            $taxonomy = 'category';
        } else {
            $taxonomy = $args['taxonomy'];
        }

        $name = 'wpc_cached_categories';
        $args['popular_cats'] = empty( $args['popular_cats'] ) ? array() : $args['popular_cats'];
        $class = in_array( $category->term_id, $args['popular_cats'] ) ? ' class="popular-category"' : '';

        $args['selected_cats'] = empty( $args['selected_cats'] ) ? array() : $args['selected_cats'];

        if ( ! empty( $args['list_only'] ) ) {
            $aria_cheched = 'false';
            $inner_class = 'category';

            if ( in_array( $category->term_id, $args['selected_cats'] ) ) {
                $inner_class .= ' selected';
                $aria_cheched = 'true';
            }

            /** This filter is documented in wp-includes/category-template.php */
            $output .= "\n" . '<li' . $class . '>' .
                '<div class="' . $inner_class . '" data-term-id=' . $category->term_id .
                ' tabindex="0" role="checkbox" aria-checked="' . $aria_cheched . '">' .
                esc_html( apply_filters( 'the_category', $category->name ) ) . '</div>';
        } else {
            /** This filter is documented in wp-includes/category-template.php */
            $output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" .
                '<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="'.$name.'[]" id="in-'.$taxonomy.'-' . $category->term_id . '"' .
                checked( in_array( $category->term_id, $args['selected_cats'] ), true, false ) .
                disabled( empty( $args['disabled'] ), false, false ) . ' /> ' .
                esc_html( apply_filters( 'the_category', $category->name ) ) . '</label>';
        }
    }
}

?>
