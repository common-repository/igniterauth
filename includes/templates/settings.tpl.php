<div class="wrap">
    <h1><?php _e( 'IgniterAuth Settings', 'igniter-auth' );?></h1>
    <p><?php _e ( 'Choose whether to allow access to the site WordPress users or create a custom username and password.', 'igniter-auth' );?></p>

<form action="" method="post" role="form">
    <?php wp_nonce_field( 'igniter-auth-settings-page' );?>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><?php _e( 'Authenticate users', 'igniter-auth' );?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e( 'Authenticate users', 'igniter-auth' );?></span></legend>
                        <p><label>
                            <input name="igniter_auth_method" type="radio" value="wp" class="tog" <?php echo $authType == 'wp' ? 'checked="checked"': '';?>>
		                    <?php _e( 'WordPress users', 'igniter-auth' );?>	
                        </label></p>
                        <p><label>
                            <input name="igniter_auth_method" type="radio" value="custom" class="tog" <?php echo $authType == 'custom' ? 'checked="checked"': '';?>>
		                    <?php _e( 'Custom username & password', 'igniter-auth' );?>	
                        </label></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e( "Enable 'noindex' header", 'igniter-labs' );?></th>
                <td>
                <select name="igniter_auth_noindex" id="igniter_auth_noindex">
                    <option value="Y" <?php echo $noindex == 'Y' ? 'selected="selected"': '';?>><?php _e( 'Yes', 'igniter-auth' );?></option>
                    <option value="N" <?php echo $noindex == 'N' ? 'selected="selected"': '';?>><?php _e( 'No', 'igniter-auth' );?></option>
                </select>
                </td>
            </tr>
            <tr>
                <th scope="row" colspan="2">
                    <h2><?php _e( 'Custom username & password', 'igniter-auth' );?></h2>
                </th>
            </tr>
            <tr>
                <th scope="row"><label for="igniter_auth_username"><?php _e( 'Username', 'igniter-auth' );?></label></th>
                <td>
                    <input name="igniter_auth_username" id="igniter_auth_username" type="text" value="<?php echo esc_attr( $username );?>" class="regular-text ltr" placeholder="<?php echo esc_attr( 'username', 'igniter-auth' );?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="igniter_auth_password"><?php _e( 'Password', 'igniter-auth' );?></label></th>
                <td>
                    <input name="igniter_auth_password" id="igniter_auth_password" type="password" value="<?php echo esc_attr( $password );?>" class="regular-text ltr" placeholder="<?php echo esc_attr( 'password', 'igniter-auth' );?>">
                    <p><a href="#" id="showPasswd"><?php _e( 'Show password', 'igniter-auth' );?></a></p>
                </td>
            </tr>
        </tbody>
    </table>

    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo esc_attr( 'Save Changes', 'igniter-auth' );?>"></p>
</form>
</div>
<script>
document.getElementById("showPasswd").addEventListener("click", showHidePasswd);
function showHidePasswd(e)
{
    e.preventDefault();
    let iType = document.getElementById('igniter_auth_password').getAttribute('type');
    
    if(iType == 'password') {
        document.getElementById('igniter_auth_password').setAttribute( 'type', 'text' );
    } else {
        document.getElementById('igniter_auth_password').setAttribute( 'type', 'password' );
    }
}
</script>