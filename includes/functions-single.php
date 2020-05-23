<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

//add_action('the_content','post_grid_single_post');

function post_grid_single_post($content){

    $post_id = get_the_id();
    $post_grid_post_settings = get_post_meta($post_id,'post_grid_post_settings', true);

    $layout_id = !empty($post_grid_post_settings['layout_id']) ? (int) $post_grid_post_settings['layout_id'] : '';

    //var_dump($layout_id);

    if(!empty($layout_id)){


        $layout_elements_data = get_post_meta( $layout_id, 'layout_elements_data', true );
        $layout_custom_scripts = get_post_meta($layout_id,'custom_scripts', true);
        $layout_custom_css = isset($layout_custom_scripts['custom_css']) ? $layout_custom_scripts['custom_css'] : '';

        ob_start();

        ?>
        <div class="layout-<?php echo $layout_id; ?>">
        <?php

        if(!empty($layout_elements_data))
            foreach($layout_elements_data as $elementIndex=>$elementData){
                foreach($elementData as $elementId=>$element) {

                    //var_dump($elementId);

                    $element_args['element'] = $element;
                    $element_args['index'] = $elementIndex;

                    $element_args['post_id'] = $post_id;
                    $element_args['layout_id'] = $layout_id;

                    do_action('post_grid_layout_element_' . $elementId, $element_args);
                    do_action('post_grid_layout_element_css_' . $elementId, $element_args);



                }

            }
        ?>
        </div>
        <?php if(!empty($layout_custom_css)): ?>
            <style type="text/css">
                <?php
                echo str_replace('__ID__', 'layout-'.$layout_id, $layout_custom_css);
                ?>
            </style>
        <?php endif; ?>
        <?php
        $content = ob_get_clean();

    }


    return $content;

}





function post_grid_remove_post_title($post_title){

    $post_id = get_the_ID();

    $post_grid_post_settings = get_post_meta($post_id, 'post_grid_post_settings', true);
    $remove_post_title = isset($post_grid_post_settings['remove_post_title']) ? $post_grid_post_settings['remove_post_title'] : 'no';


    if($remove_post_title =='yes' && in_the_loop()){

        return '';
    }
    else{
        return $post_title;
    }

}

//add_filter('the_title','post_grid_remove_post_title');


function post_grid_remove_post_thumbnail($post_thumbnail){

    $post_id = get_the_ID();

    $post_grid_post_settings = get_post_meta($post_id, 'post_grid_post_settings', true);
    $remove_post_thumbnail = isset($post_grid_post_settings['remove_post_thumbnail']) ? $post_grid_post_settings['remove_post_thumbnail'] : 'no';


    if(is_singular() && $remove_post_thumbnail == 'yes'){

        return '';
    }
    else{
        return $post_thumbnail;
    }

}

//add_filter('post_thumbnail_html','post_grid_remove_post_thumbnail');


function post_grid_single_template($single_template) {
    global $post;

    $post_id = get_the_id();
    $post_grid_post_settings = get_post_meta($post_id,'post_grid_post_settings', true);

    $layout_id = !empty($post_grid_post_settings['layout_id']) ? (int) $post_grid_post_settings['layout_id'] : '';


    if ($post->post_type == 'post' && !empty($layout_id)) {

        $single_template = post_grid_pt_plugin_dir . 'templates/single/single-template-hook.php';

    }
    return $single_template;
}
add_filter( 'single_template', 'post_grid_single_template' );







