<?php
class CookieWallAdminSettingsPage {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct(){
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page(){
        // This page will be under "Settings"
        add_options_page(
            __('Cookie Wall Settings', COOKIE_WALL_TEXT_DOMAIN), 
            __('Cookie Wall', COOKIE_WALL_TEXT_DOMAIN), 
            'manage_options', 
            'setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page(){
        // Set class property
        $this->options = get_option( 'tropical_cookie_wall_options' );
        ?>
        <div class="wrap">
            <h1><?php _e('Cookie Wall Settings', COOKIE_WALL_TEXT_DOMAIN) ?></h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'option_group' );
                do_settings_sections( 'setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init(){        
        register_setting(
            'option_group', // Option group
            'tropical_cookie_wall_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'background_section', // ID
            __('Background Settings',COOKIE_WALL_TEXT_DOMAIN), // background_blur
            array( $this, 'print_section_info_background' ), // Callback
            'setting-admin' // Page
        );  

        add_settings_field(
            'background_image_url', // ID
            'URL', // background_blur 
            array( $this, 'background_url_callback' ), // Callback
            'setting-admin', // Page
            'background_section' // Section           
        );      
        
        add_settings_field(
            'background_color', 
            'Color Code, CSS compliant code', 
            array( $this, 'background_color_callback' ), 
            'setting-admin', 
            'background_section'
        );

        add_settings_field(
            'background_blur', 
            'Blur', 
            array( $this, 'background_blur_callback' ), 
            'setting-admin', 
            'background_section'
        );
        
        add_settings_section(
            'content_section', // ID
            __('Content Settings',COOKIE_WALL_TEXT_DOMAIN), // background_blur
            array( $this, 'print_section_info_content' ), // Callback
            'setting-admin' // Page
        ); 
        
        add_settings_field(
            'content_logo', 
            'Logo URL', 
            array( $this, 'content_logo_callback' ), 
            'setting-admin', 
            'content_section'
        );
        
        add_settings_field(
            'content_page', 
            'Page ID for cookie wall notice', 
            array( $this, 'content_pageID_callback' ), 
            'setting-admin', 
            'content_section'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['background_url'] ) )
            $new_input['background_url'] = sanitize_text_field( $input['background_url'] );
            
        if( isset( $input['background_color'] ) )
            $new_input['background_color'] = sanitize_text_field( $input['background_color'] );

        if( isset( $input['background_blur'] ) )
            $new_input['background_blur'] = absint( $input['background_blur'] );
            
        if( isset( $input['content_logo'] ) )
            $new_input['content_logo'] = sanitize_text_field( $input['content_logo'] );
            
        if( isset( $input['content_page'] ) )
            $new_input['content_page'] = absint( $input['content_page'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info_background(){
        print __('This section controls the background, image and blur:',COOKIE_WALL_TEXT_DOMAIN);
    }
    
    public function print_section_info_content(){
        print __('This section controls the content options:',COOKIE_WALL_TEXT_DOMAIN);
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function background_url_callback(){
        printf(
            '<input type="text" id="background_url" name="tropical_cookie_wall_options[background_url]" value="%s" />',
            isset( $this->options['background_url'] ) ? esc_attr( $this->options['background_url']) : ''
        );
    }
    
    public function background_color_callback(){
        printf(
            '<input type="text" id="background_color" name="tropical_cookie_wall_options[background_color]" value="%s" />',
            isset( $this->options['background_color'] ) ? esc_attr( $this->options['background_color']) : ''
        );
    }

    public function background_blur_callback(){
        printf(
            '<input type="text" id="background_blur" name="tropical_cookie_wall_options[background_blur]" value="%s" />',
            isset( $this->options['background_blur'] ) ? esc_attr( $this->options['background_blur']) : ''
        );
    }
    
    public function content_logo_callback(){
        printf(
            '<input type="text" id="content_logo" name="tropical_cookie_wall_options[content_logo]" value="%s" />',
            isset( $this->options['content_logo'] ) ? esc_attr( $this->options['content_logo']) : ''
        );
    }
    
    public function content_pageID_callback(){
        printf(
            '<input type="text" id="content_page" name="tropical_cookie_wall_options[content_page]" value="%s" />',
            isset( $this->options['content_page'] ) ? esc_attr( $this->options['content_page']) : ''
        );
    }
}