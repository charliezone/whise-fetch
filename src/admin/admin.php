<?php

add_action( 'admin_menu', 'wf_menu' );

function wf_menu(){
    $page = add_menu_page(
        'Whise',
        'Whise',
        'manage_options',
        'whise-menu',
        'whise_page_content',
        'dashicons-admin-generic'
    );

    add_action( 'load-' . $page, 'wf_load_admin_assets' );
}

function wf_load_admin_assets(){
    add_action( 'admin_enqueue_scripts', 'wf_enqueue_admin_assets' );
}

function wf_enqueue_admin_assets(){
    wp_enqueue_script( 'wf-script', plugin_dir_url( __FILE__ ) . '/../../../assets/js/app.js',  array('jquery'));

    wp_enqueue_style( 'wf-style', plugin_dir_url( __FILE__ ) . '/../../../assets/css/app.css' );
}

function whise_page_content(){
    ?>
        <h1>Fetch Whise Real Estate</h1>
        <?php if (isset($_GET['susses']) && $_GET['susses'] === 'true'): ?>
            <h3 style="color: #31df24;">Token save successfully.</h3>
            <?php elseif(isset($_GET['susses'])): ?>
            <h3 class="error" style="color: red;">Problem saving token, check if already exists</h3>
        <?php endif; ?>
        <form method="post" action="<?php echo esc_html( admin_url( 'admin-post.php' ) ); ?>">
 
            <div>
                <p>
                    <label>Enter the Whise API token</label>
                    <br />
                    <input type="text" name="token" value="<?php if( get_option('whise_token') ) echo get_option('whise_token') ?>" style="width: 50%;" />
                </p> 
            </div>
    
            <?php
                wp_nonce_field( 'whise-token', 'whise-token-save' );
                submit_button();
            ?>
    
        </form>
        <div class="wf-trigger-update">
            <button id="wfTriggerUpdate">Trigger update</button>
            <span id="loading-indicator">Loading...</span>
            <span id="message-text"></span>
        </div>
    <?php
}

add_action( 'admin_post', 'handle_token_save_form' );

function handle_token_save_form(){
    if ( ! wp_verify_nonce( $_POST['whise-token-save'], 'whise-token' ) ) {
        print 'Token Issue.';
        exit;
    } else {
        if( update_option( 'whise_token', sanitize_text_field($_POST['token']) ) ){
            wp_safe_redirect( urldecode( admin_url('admin.php?page=whise-menu&susses=true') ) );
        }else{
            wp_safe_redirect( urldecode( admin_url('admin.php?page=whise-menu&susses=false') ) );
        }
        
        exit;
    }
}