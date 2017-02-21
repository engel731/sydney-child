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
 * Charge les sources des formulaires
 * Emule le fonctionnement de l'element html5 input date pour tous les naviguateur
 */
function sydney_child_wpcf7_init() {
    // Arrêter le chargement du stylesheet JavaScript et CSS du pugin contact 7 sur toutes les pages
    add_filter( 'wpcf7_load_js', '__return_false' );
    add_filter( 'wpcf7_load_css', '__return_false' );

    // Fonctionnalité de repli pour formulaire type date
    add_filter( 'wpcf7_support_html5_fallback', '__return_true' );

    // Chargement scripts js,css pour formulaire de contact avec "contact 7"
    if(is_page_template( 'tpl/contact-form.php')) { 
        if(function_exists( 'wpcf7_enqueue_scripts')) {
            wpcf7_enqueue_scripts();
        }
 
        if(function_exists( 'wpcf7_enqueue_styles')) {
            wpcf7_enqueue_styles();
        }
    }
}

/**
 * Enqueue scripts and styles.
 */
function sydney_child_scripts() {
    // Chargement fichier style du theme parent
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	
	// Fichier styles du theme enfant
    wp_enqueue_style('sydney-child-style', get_stylesheet_uri());
    wp_enqueue_style('sydney-child-bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array(), true );

    // Initialise les formulaires
    sydney_child_wpcf7_init();
}
add_action('wp_enqueue_scripts', 'sydney_child_scripts');

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
 * Initialise de les nouvelle meta-box pour ajouter la date effective de l'activité
 */
function sydney_child_init_metaboxes() {
    add_meta_box(
        'meta_activity_date', 
        'Date effective de l\'activité', 
        'sydney_child_meta_date', 
        'activity', 
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'sydney_child_init_metaboxes');

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
    if(isset($_POST['date_event'])) {
        // Enregistre les heures de l'évènement
        update_post_meta($post_ID, '_date_event', esc_html($_POST['date_event']));
    }
}
add_action('save_post', 'sydney_child_save_metaboxes');


function sydney_child_modifier_content ($content) {
    if (is_page('activites-du-mois')) {
        if(strlen($content) > 150) {
            $content = substr($content, 0, 150) . ' ...';
        }
    }
    return  $content;
}
add_filter( 'the_content', 'sydney_child_modifier_content');

function sydney_child_modifier_title ($title) {
    if (is_page('activites-du-mois')) {
        if(strlen($title) > 30) {
            $title = substr($title, 0, 30) . ' ...';
        }
    }
    return  $title;
}
add_filter( 'the_title', 'sydney_child_modifier_title');