<?php 
    $category = get_category_by_slug( 'product' );

    $args = array(
        'type'                     => 'post',
        'child_of'                 => $category->term_id,
        'orderby'                  => 'name',
        'order'                    => 'ASC',
        'hide_empty'               => FALSE,
        'hierarchical'             => 1,
        'taxonomy'                 => 'category',
        'parent' => $category->term_id,
    ); 
    $list_category = get_categories( $args ); 

    if($list_category) {
        foreach ($list_category as $category) {
            echo '<li><a href="'.get_category_link( $category->term_id ).'" title="'.$category->name.'" >'.$category->name.'</a></li>';
        }
    }
?>