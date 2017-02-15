<?php
/**
 * Sydney-child functions and definitions
 *
 * @package Sydney-child
 */

if ( ! function_exists( 'sydney_child_setup' ) ) :
function sydney_child_setup() {
	load_theme_textdomain( 'sydney-child', get_template_directory() . '/languages' );
}
endif; // sydney_child_setup
add_action( 'after_setup_theme', 'sydney_child_setup' );


/**
 * Enqueue scripts and styles.
 */
function sydney_child_scripts() {
	// Chargement fichier style du theme parent
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	
	// Chargement font-awesome
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/fonts/font-awesome.min.css');

	// Chargement style pour ie9
	wp_enqueue_style( 'sydney-ie9', get_template_directory_uri() . '/css/ie9.css', array( 'sydney-style' ) );
	wp_style_add_data( 'sydney-ie9', 'conditional', 'lte IE 9' );

	// Chargement fichier scripts
	wp_enqueue_script( 'sydney-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'),'', true );
	wp_enqueue_script( 'sydney-main', get_template_directory_uri() . '/js/main.min.js', array('jquery'),'20170127', true );
	wp_enqueue_script( 'sydney-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	// Chargement scripts js pour formulaire de contact
	if (is_page_template( 'tpl/contact-form.php')) { 
		wp_enqueue_script('contact-form', get_template_directory() . '/js/contact-form.js');
	}

	if ( get_theme_mod('blog_layout') == 'masonry-layout' && (is_home() || is_archive()) ) {
		wp_enqueue_script( 'sydney-masonry-init', get_template_directory_uri() . '/js/masonry-init.js', array('masonry'),'', true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Chargement des google fonts
	if ( get_theme_mod('body_font_name') !='' ) {
	    wp_enqueue_style( 'sydney-body-fonts', '//fonts.googleapis.com/css?family=' . esc_attr(get_theme_mod('body_font_name')) );
	} else {
	    wp_enqueue_style( 'sydney-body-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,600');
	}

	if ( get_theme_mod('headings_font_name') !='' ) {
	    wp_enqueue_style( 'sydney-headings-fonts', '//fonts.googleapis.com/css?family=' . esc_attr(get_theme_mod('headings_font_name')) );
	} else {
	    wp_enqueue_style( 'sydney-headings-fonts', '//fonts.googleapis.com/css?family=Raleway:400,500,600');
	}

    // Fichier styles du theme enfant
    wp_enqueue_style('sydney-child-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'sydney_child_scripts');

/**
 * Enqueue Bootstrap
 */
function sydney_child_enqueue_bootstrap() {
	wp_enqueue_style( 'sydney-bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css', array(), true );
}
add_action('wp_enqueue_scripts', 'sydney_child_enqueue_bootstrap', 9);

/**
 * Register sidebar_index
 */
function sydney_child_add_sidebar_index() {
    register_sidebar(array(
        'id' => 'sidebar_index',
        'name' => 'Sidebar d\'accueil',
        'description' => 'Apparait seulement à l\'accueil du site',
        'before_widget' => '<aside>',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>'
    ));
}
add_action('widgets_init','sydney_child_add_sidebar_index');

/**
 * Register menu_index
 */
function sydney_child_add_menu_index() {
    register_nav_menu('second_menu', 'Second menu d\'accueil');
}
add_action('init', 'sydney_child_add_menu_index');

/**
 * Enregistre le nouveau type de contenu activité
 */
function sydney_child_activity_init() {
    register_post_type(
        'activity',
        
        array(
            'label' => 'activity',
            
            'labels' => array(
                'name' => 'Activités',
                'singular_name' => 'Activité',
                'all_items' => 'Toutes les activités',
                'add_new_item' => 'Ajouter une activité',
                'edit_item' => 'Éditer l\'activité',
                'new_item' => 'Nouvelle activité',
                'view_item' => 'Voir l\'activité',
                'search_items' => 'Rechercher parmi les activités',
                'not_found' => 'Pas d\'activité(s) trouvé',
                'not_found_in_trash'=> 'Pas d\'activité(s) dans la corbeille'
            ),
            
            'public' => true,
            'capability_type' => 'post',
            
            'supports' => array(
                'title',
                'editor',
                'thumbnail'
            ),
            
            'has_archive' => true
        )
    );

    register_taxonomy(
        'type',
        'activity',
  
        array(
            'label' => 'Types',
            
            'labels' => array(
                'name' => 'Types d\'activités',
                'singular_name' => 'Type d\'activité',
                'all_items' => 'Tous les types d\'activité',
                'edit_item' => 'Éditer le type d\'activité',
                'view_item' => 'Voir le type d\'activité',
                'update_item' => 'Mettre à jour le type d\'activité',
                'add_new_item' => 'Ajouter un type d\'activité',
                'new_item_name' => 'Nouveau type d\'activité',
                'search_items' => 'Rechercher parmi les types d\'activité',
                'popular_items' => 'Types d\'activité les plus utilisés'
            ),
            
            'hierarchical' => true
        )
    );

    register_taxonomy_for_object_type( 'type', 'activity' );
}
add_action('init', 'sydney_child_activity_init');


/**
 * Enregistre le nouveau type de contenu événemment
 */
function sydney_child_event_init() {
    register_post_type(
        'event',
        
        array(
            'label' => 'event',
            
            'labels' => array(
                'name' => 'Evénements',
                'singular_name' => 'Evénement',
                'all_items' => 'Toutes les événements',
                'add_new_item' => 'Ajouter un événement',
                'edit_item' => 'Éditer l\'événement',
                'new_item' => 'Nouvelle événement',
                'view_item' => 'Voir l\'événement',
                'search_items' => 'Rechercher parmi les événements',
                'not_found' => 'Pas d\'événement(s) trouvé',
                'not_found_in_trash'=> 'Pas d\'événement(s) dans la corbeille'
            ),
            
            'public' => true,
            'capability_type' => 'post',
            
            'supports' => array(
                'title',
                'editor'
            ),
            
            'has_archive' => true
        )
    );
}
add_action('init', 'sydney_child_event_init');

/**
 * Initialise de les nouvelle meta-box pour joindre une activité à l'événement
 * et temporiser l'événemment
 */
function sydney_child_init_metaboxes() {
    add_meta_box(
        'meta_activity', 
        'Lier une activité à l\'événemment: ', 
        'sydney_child_meta_activity', 
        'event', 
        'normal',
        'high'
    );

    add_meta_box(
        'meta_date', 
        'Date de l\'evénement : ', 
        'sydney_child_meta_date', 
        'event', 
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sydney_child_init_metaboxes');

/**
 * Construit la meta-box pour lier l'activité
 */
function sydney_child_meta_activity($post) {
    $activity_name = get_post_meta($post->ID, '_activity_name', true);
    
    echo '<label>Perma-lien de l\'activité à lier : </label>';
    echo '<input type="text" name="activity_name" value="'.$activity_name.'" />';
}

/**
 * Construit la meta-box pour les horaires de l'évenement
 */
function sydney_child_meta_date($post) {
    $date_event = get_post_meta($post->ID, '_date_event', true);

    echo '<label>Date de l\'événement : </label>';
    echo '<input type="date" name="date_event" value="'.$date_event.'" />';
}

/**
 * Enregistre les données des meta-boxes
 */
function sydney_child_save_metaboxes($post_ID){
    if(isset($_POST['date_event'], $_POST['hour_event'], $_POST['duration_event'])) {
        // Enregistre les heures de l'évènement
        update_post_meta($post_ID, '_date_event', esc_html($_POST['date_event']));
    }
        
    if(isset($_POST['activity_name'])) {
        $slug_activity = esc_html($_POST['activity_name']);

        // Lie l'activité à l'évènement
        update_post_meta($post_ID, '_activity_name', $slug_activity);
        link_activity($post_ID, $slug_activity);
    }
}
add_action('save_post', 'sydney_child_save_metaboxes');

/**
 * Lie une activité à l'évènement id donné en paramètre
 * @param int $post_ID Id de l'évènement
 * @param string $slug_activity Slug de l'activité à lier
 */
function link_activity($post_ID, $slug_activity) {
    $my_query = new WP_Query(array(
        'post_type' => 'activity',
        'name' => $slug_activity
    ));

    if($my_query->have_posts()) {
        $my_query->the_post();

        update_post_meta($post_ID, '_activity_id', get_the_ID());
    }
}