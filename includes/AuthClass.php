<?php 

namespace IgniterAuth;

! defined( 'ABSPATH' ) ? exit : '';

class AuthClass 
{
    public $realm;

    public function __construct( string $realm = 'Restricted area' )
    {
        $this->realm = $realm;
    }

    public function lock()
    {
        if( ( ! is_user_logged_in() || !empty( $_SERVER['IGNITER_AUTH_REALM'] ) ) )
        {
            $this->authenticateUser();
            $this->pluginSetup();
        }
    }

    // generate the valid response
    private function authenticateUser()
    {
        $authUser = false;

        if ( ! empty( $_SERVER['PHP_AUTH_USER'] ) && ! empty( $_SERVER['PHP_AUTH_PW'] ) ) 
        {
            $username = $_SERVER['PHP_AUTH_USER']; 
            $password = $_SERVER['PHP_AUTH_PW'];

            $authType = get_option( 'igniter_auth_method', 'wp' );
            $c_username = get_option( 'igniter_auth_username', '' );
            $c_password = get_option( 'igniter_auth_password', '' );

            if( $authType == "wp" )
            {
                $user = wp_signon( array (
                    'user_login' => $username, 
                    'user_password' => $password
                ) );

                if( ! is_wp_error($user) ) 
                {
                    $authUser = true;
                }
            }
            else
            {
                if( $username == $c_username && $password == $this->decrypt( $c_password ) )
                {
                    $authUser = true;
                    $_SERVER['IGNITER_AUTH_REALM'] = true;
                }
            }
        }
        
        if( $authUser === false )
        {
            $this->authHeader();
        }
    }

    private function authHeader()
    {
        header( 'HTTP/1.1 401 Unauthorized' );
        header('WWW-Authenticate: Basic realm="' . $this->realm . '"');
         
        die( __( 'Unauthorized Access', 'igniter-auth' ) );
    }

    public function noIndex()
    {
        $header = '';

        if( get_option( 'igniter_auth_noindex', 'Y' ) == "Y" )
        {
            $header .= '<meta name="robots" content="noindex">';
            header( 'X-Robots-Tag: noindex' );
        }

        echo $header;
    }

    public function settingsLink( $links ) 
    {
        $url = esc_url( add_query_arg(
            'page',
            'igniter-auth-settings',
            get_admin_url() . 'admin.php'
        ) );
        
        $settings_link = "<a href='$url'>" . __( 'Settings', 'igniter-auth' ) . '</a>';
        
        array_push(
            $links,
            $settings_link
        );

        return $links;
    }

    public function settingsMenu() 
    {
        add_options_page( 
            'IgniterAuth Settings', 
            'IgniterAuth', 
            'manage_options', 
            'igniter-auth-settings', 
            array(&$this, 'settingsPage')
        );
    }

    private function pluginSetup()
    {
        load_theme_textdomain('igniter-auth', get_template_directory() . '/i18n');
    }

    public function adminNoticeWarning() 
    {
        $class = 'notice notice-warning';
        $message = __( '<b>IgniterAuth is Active!</b> This site is not accessible to the public.', 'igniter-auth' );
        $message .= ' <a href="' . admin_url( 'admin.php?page=igniter-auth-settings' ) . '">' . __( 'Settings', 'igniter-auth' ) . '</a>';
        $message .= ' | <a href="' . admin_url( 'plugins.php' ) . '">' . __( 'Deactivate', 'igniter-auth' ) . '</a>';
    
        printf( '<div class="%1$s" style="margin-left: 2px;"><p>%2$s</p></div>', esc_attr( $class ), ( $message ) );
    }

    public function settingsPage()
    {
        $authType = get_option( 'igniter_auth_method', 'wp' );
        $username = get_option( 'igniter_auth_username', '' );
        $password = get_option( 'igniter_auth_password', '' );
        $noindex = get_option( 'igniter_auth_noindex', 'Y' );

        if( !empty( $password ) )
        {
            $password = $this->decrypt( $password );
        }

        if ( ! empty( $_POST['submit'] ) 
            && wp_verify_nonce( $_POST['_wpnonce'], 'igniter-auth-settings-page' ) 
        ) 
        {
            $authType = ( in_array( $_POST['igniter_auth_method'], array( 'wp', 'custom' ) ) ? $_POST['igniter_auth_method'] : 'wp' );
            $noindex = ( in_array( $_POST['igniter_auth_noindex'], array( 'Y', 'N' ) ) ? $_POST['igniter_auth_noindex'] : 'Y' );
            $username = sanitize_user( $_POST['igniter_auth_username'] );
            $password = sanitize_text_field( $_POST['igniter_auth_password'] );

            update_option( 'igniter_auth_method', $authType );
            update_option( 'igniter_auth_noindex', $noindex );
            update_option( 'igniter_auth_username', $username );
            update_option( 'igniter_auth_password', $this->encrypt( $password ) );

            echo '<div class="notice notice-success"><p><b>' . __( 'Settings saved.', 'igniter-auth' ). '</b></p></div>';
        }

        include IGNITER_AUTH_PLUGIN_PATH . "includes/templates/settings.tpl.php";
    }

    private function encrypt( $input_string, $key = AUTH_KEY )
    {
        return base64_encode( openssl_encrypt( $input_string, "AES-128-ECB", $key ) );
    }
    
    private function decrypt( $encrypted_input_string, $key = AUTH_KEY )
    {
        return openssl_decrypt( base64_decode( $encrypted_input_string ), "AES-128-ECB", $key );
    }
}