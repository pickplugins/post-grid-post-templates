<?php

/*
* @Author 		PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access






add_filter('post_grid_post_options_tabs', 'post_grid_pt_post_options_tabs');


function post_grid_pt_post_options_tabs($tabs){

    global $post;

    $post_id = $post->ID;
    $post_grid_post_settings = get_post_meta($post_id, 'post_grid_post_settings', true);


    $post_grid_settings_tab = array();
    $current_tab = isset($post_grid_post_settings['current_tab']) ? $post_grid_post_settings['current_tab'] : 'options';


    $tabs[] = array(
        'id' => 'post_template',
        'title' => sprintf(__('%s Post template','post-grid'), '<i class="fas fa-newspaper"></i>'),
        'priority' => 2,
        'active' => ($current_tab == 'post_template') ? true : false,

    );


    return $tabs;

}


add_action('post_grid_post_options_content_post_template', 'post_grid_post_options_content_post_template',10, 2);

function post_grid_post_options_content_post_template($tab, $post_id){

    $settings_tabs_field = new settings_tabs_field();

    $post_grid_post_settings = get_post_meta($post_id, 'post_grid_post_settings', true);

    $remove_post_title = !empty($post_grid_post_settings['remove_post_title']) ? $post_grid_post_settings['remove_post_title'] : '';
    $remove_post_thumbnail = !empty($post_grid_post_settings['remove_post_thumbnail']) ? $post_grid_post_settings['remove_post_thumbnail'] : '';


    ?>
    <div class="section">
        <div class="section-title">Post template</div>
        <p class="description section-description">Customize post template settings, will applied to single post template for this post.</p>


        <?php


//
//        $args = array(
//            'id'		=> 'remove_post_title',
//            'parent'		=> 'post_grid_post_settings',
//            'title'		=> __('Remove post title','post-grid'),
//            'details'	=> __('Remove default post title from single post template.','post-grid'),
//            'type'		=> 'radio',
//            'value'		=> $remove_post_title,
//            'default'		=> 'no',
//            'args'		=> array(
//                'yes'=>__('Yes','post-grid'),
//                'no'=>__('No','post-grid'),
//            ),
//        );
//
//        $settings_tabs_field->generate_field($args, $post_id);
//
//        $args = array(
//            'id'		=> 'remove_post_thumbnail',
//            'parent'		=> 'post_grid_post_settings',
//            'title'		=> __('Remove post thumbnail','post-grid'),
//            'details'	=> __('Remove default post thumbnail from single post template.','post-grid'),
//            'type'		=> 'radio',
//            'value'		=> $remove_post_thumbnail,
//            'default'		=> 'no',
//            'args'		=> array(
//                'yes'=>__('Yes','post-grid'),
//                'no'=>__('No','post-grid'),
//            ),
//        );
//
//        $settings_tabs_field->generate_field($args, $post_id);
//



        ?>
    </div>
    <?php


    //var_dump($post_id);
    $settings_tabs_field = new settings_tabs_field();
    $post_grid_post_settings = get_post_meta($post_id,'post_grid_post_settings', true);
    $layout_id = !empty($post_grid_post_settings['layout_id']) ? $post_grid_post_settings['layout_id'] : ''; //post_grid_get_first_post('post_grid_layout')


    ?>
    <div class="section">

        <?php



        ob_start();

        ?>
        <p><a target="_blank" class="button" href="<?php echo admin_url().'post-new.php?post_type=post_grid_layout'; ?>"><?php echo __('Create layout','post-grid'); ?></a> </p>
        <p><a target="_blank" class="button" href="<?php echo admin_url().'edit.php?post_type=post_grid_layout'; ?>"><?php echo __('Manage layouts','post-grid'); ?></a> </p>
        <?php



        $html = ob_get_clean();

        $args = array(
            'id'		=> 'post_grid_layout_create',
            //'parent'		=> 'post_grid_post_settings',
            'title'		=> __('Create layout','post-grid'),
            'details'	=> __('Please follow the links to create layouts or manage.','post-grid'),
            'type'		=> 'custom_html',
            'html'		=> $html,
        );

        $settings_tabs_field->generate_field($args);


        $item_layout_args = array();

        $query_args['post_type'] 		= array('post_grid_layout');
        $query_args['post_status'] 		= array('publish');
        $query_args['orderby']  		= 'date';
        $query_args['order']  			= 'DESC';
        $query_args['posts_per_page'] 	= -1;
        $wp_query = new WP_Query($query_args);

        $item_layout_args[''] = array('name'=>'Empty layout',  'thumb'=> 'https://i.imgur.com/JyurCtY.jpg', );


        if ( $wp_query->have_posts() ) :


            while ( $wp_query->have_posts() ) : $wp_query->the_post();

                $post_id = get_the_id();
                $layout_name = get_the_title();
                $product_thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full' );
                $product_thumb_url = isset($product_thumb['0']) ? esc_url_raw($product_thumb['0']) : '';

                $layout_options = get_post_meta($post_id,'layout_options', true);
                $layout_preview_img = !empty($layout_options['layout_preview_img']) ? $layout_options['layout_preview_img'] : 'https://i.imgur.com/JyurCtY.jpg';

                $product_thumb_url = !empty( $product_thumb_url ) ? $product_thumb_url : $layout_preview_img;

                $item_layout_args[$post_id] = array('name'=>$layout_name, 'link_text'=>'Edit', 'link'=> get_edit_post_link($post_id), 'thumb'=> $product_thumb_url, );

            endwhile;
        endif;





        $args = array(
            'id'		=> 'layout_id',
            'parent' => 'post_grid_post_settings',
            'title'		=> __('Post template layouts','post-grid'),
            'details'	=> __('Choose layout for post template.','post-grid'),
            'type'		=> 'radio_image',
            'value'		=> $layout_id,
            'default'		=> '',
            'width'		=> '250px',
            'args'		=> $item_layout_args,
        );

        $settings_tabs_field->generate_field($args);



        ?>
    </div>
    <?php



}

