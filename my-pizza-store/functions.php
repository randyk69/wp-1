<?php 

if ( ! function_exists ( 'glasseye_setup') ) :

    function glasseye_setup() {
        // let WordPress handle the Titles tags
        add_theme_support( 'title-tag' );
    }
endif;
add_action( 'after_setup_theme', 'glasseye_setup' );

/* ---- Register Menus ---- */

function register_glasseye_menus() {
    register_nav_menus(
        array(
            'primary' => __( 'Primary Menu' ),
            'footer' => __( 'Footer Menu' )
        )
    );
}
add_action( 'init', 'register_glasseye_menus' );

/* ---- Add Stylesheets ---- */

function glasseye_scripts() {
    
    // Enqueue Main Stylesheet
    wp_enqueue_style( 'glasseye_styles', get_stylesheet_uri() );
    // Enqueue Google Fonts, Raleway
    wp_enqueue_style( 'glasseye_google_fonts', 'https://fonts.googleapis.com/css?family=Raleway:300,400,400i,700' );
}
add_action( 'wp_enqueue_scripts', 'glasseye_scripts' );

/* ---- Register Widget Areas ---- */

function glasseye_widgets_init() {
    register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'glasseye' ),
		'id'            => 'main-sidebar',
		'description'   => __( 'Widgets added here will appear in all pages using the two column template.', 'glasseye' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'glasseye_widgets_init' );

/*
---------  Custom Classes Post Type --------
*/

add_theme_support('post-thumbnails'); /* this line will add Featured Image meta box in post type editor */
    
function create_post_type() {
  register_post_type( 'glasseye_classes',
    array(
      'labels' => array(
        'name' => __( 'Pizza Packages' ),
        'singular_name' => __( 'Pizza Package' ),
        'add_new' => 'Add a Package',
		'all_items' => 'All Packages',
		'add_new_item' => 'Add Package',
		'edit_item' => 'Edit Item',
		'new_item' => 'New Item',
		'view_item' => 'View Item',
		'search_item' => 'Search Portfolio',
		'not_found' => 'No items found',
		'not_found_in_trash' => 'No items found in trash',
		'parent_item_colon' => 'Parent Item'    
      ),
      'public' => true,
      'has_archive' => true,
      'publicly_queryable' => true,
      'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'hierarchical' => false,
      'supports' => array('thumbnail','title')
    )
  );
    
}
add_action( 'init', 'create_post_type' );


function awesome_custom_post_type (){
	
	$labels = array(
		'name' => 'Portfolio',
		'singular_name' => 'Portfolio',
		'add_new' => 'Add Item',
		'all_items' => 'All Items',
		'add_new_item' => 'Add Item',
		'edit_item' => 'Edit Item',
		'new_item' => 'New Item',
		'view_item' => 'View Item',
		'search_item' => 'Search Portfolio',
		'not_found' => 'No items found',
		'not_found_in_trash' => 'No items found in trash',
		'parent_item_colon' => 'Parent Item'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'revisions',
		),
		'taxonomies' => array('category', 'post_tag'),
		'menu_position' => 5,
		'exclude_from_search' => false
	);
	register_post_type('portfolio',$args);
}
add_action('init','awesome_custom_post_type');
    
    // define prefix 
    $prefix = 'pz_';

    $meta_box = array(
        'id' => 'classes-meta-box',
        'title' => 'Add New Pizza Package',
        'page' => 'glasseye_classes',
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name' => 'Pizza Name',
                'descr' => 'Enter the name of the Pizza package',
                'id' => $prefix . 'class_name',
                'type' => 'text',
                'std' => ''
            ),
            /*
            array(
                'name' => 'Instructor',
                'descr' => 'Person teaching the class',
                'id' => $prefix . 'instructor',
                'type' => 'text',
                'std' => 'Leslie Yepp'
            ),
            array(
              'name' => 'Pizza package image',
              'descr' => 'Please paste the full URL to the image/photo. You can find this in the Media Libary',
              'id' => $prefix . 'headshot',
              'type' => 'text',
              'std' => ''
            ),
            */
            array(
                'name' => 'Package Price',
                'descr' => 'Php 200, Php 350',
                'id' => $prefix . 'skill',
                'type' => 'text',
                'std' => ''
            ),
            /*
            array(
                'name' => 'Length',
                'descr' => 'How long will this class last?',
                'id' => $prefix . 'length',
                'type' => 'text',
                'std' => '9 weeks'
            ),*/
            array(
                'name' => 'Ingredients',
                'descr' => 'Please type the ingredients for this package',
                'id' => $prefix . 'description',
                'type' => 'textarea',
                'std' => ''
            )
            /*
            array(
                'name' => 'Box Theme',
                'descr' => 'This sets the color scheme for the class box.  Please look at Classes page to determine the appropriate theme for your new listing',
                'id' => $prefix . 'theme',
                'class' => $prefix . 'theme',
                'type' => 'theme_colors',
                'options' => array (
                    array('color' => 'Pink'),
                    array('color' => 'Purple'),
                    array('color' => 'Teal'),
                    array('color' => 'Green')
                )
            )*/
            
        ) //fields array
    
    
    ); // meta_box aray    
        
add_action('admin_menu', 'glasseye_add_box');

// Add meta box

function glasseye_add_box() {
    global $meta_box;
    
    add_meta_box($meta_box['id'], $meta_box['title'], 'glasseye_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}


function glasseye_show_box() {
    global $meta_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="glasseye_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['descr'];
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['descr'];
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
            case 'theme_colors':
                 echo $field['descr'], '<br><br>';
                 foreach($field['options'] as $option){
                     echo '<label>', $option['color'], ' <input type="radio" name="', $field['id'], '" value="', $option['color'], '" id="', $field['id'] . '_' . strtolower($option['color']), '"class="', $field['class'], '"', $meta == $option['color'] ? ' checked="checked"' : '', ' /></label><br>';
                 }
        }
        echo     '</td><td>',
            '</td></tr>';
    }

    echo '</table>';
}

add_action('save_post', 'glasseye_save_data');

// Save data from meta box
function glasseye_save_data($post_id) {
    global $meta_box;

    // verify nonce
    if (!wp_verify_nonce($_POST['glasseye_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}
