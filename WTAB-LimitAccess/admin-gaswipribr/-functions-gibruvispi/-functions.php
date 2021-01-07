<?php

function set_device_code( $user_login, $user ) {
    $cookie_name = "device_code";
    if(intval($user->ID) > 0){
        $_user_id = $user->ID;
        //# Ha un codice nei cookie?
        $_trovato_device_code = false;
        if(isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] != ''){
            $_device_code_device_code = get_user_meta($_user_id, 'device_code_1', true);
            if($_device_code_device_code && $_device_code_device_code != '' && $_device_code_device_code == $_COOKIE[$cookie_name]){
                $_trovato_device_code = true;
            }
            $_device_code_device_code = get_user_meta($_user_id, 'device_code_2', true);
            if($_device_code_device_code && $_device_code_device_code != '' && $_device_code_device_code == $_COOKIE[$cookie_name]){
                $_trovato_device_code = true;
            }
            $_device_code_device_code = get_user_meta($_user_id, 'device_code_2', true);
            if($_device_code_device_code && $_device_code_device_code != '' && $_device_code_device_code == $_COOKIE[$cookie_name]){
                $_trovato_device_code = true;
            }
            if(!$_trovato_device_code){
                $_device_code_count = get_user_meta($_user_id, 'device_code_count', true);
                if(isset($_device_code_count) && intval($_device_code_count) > 0){
                    $_device_code_count = intval($_device_code_count);
                }else{
                    $_device_code_count = 0;
                    add_user_meta($_user_id, 'device_code_count', $_device_code_count);
                }
                $_device_code_device_code = get_user_meta($_user_id, 'device_code_'.$_device_code_count, true);
                if($_device_code_device_code && $_device_code_device_code != '' && $_device_code_device_code == $_COOKIE[$cookie_name]){
                    //# ha nel cookie un device code riconosciuto
                    $__result_create_device_code = true;
                }else{
                    //# crea
                    $__result_create_device_code = _create_device_code('who1', $_device_code_count, $_user_id, $cookie_name);
                }
            }else{
                //# ha nel cookie un device code riconosciuto
                $__result_create_device_code = true;
            }
        }else{
            //# crea
            $_device_code_count = get_user_meta($_user_id, 'device_code_count', true);
            if(isset($_device_code_count) && intval($_device_code_count) > 0){
                $_device_code_count = intval($_device_code_count);
            }else{
                $_device_code_count = 0;
                add_user_meta($_user_id, 'device_code_count', $_device_code_count);
            }

            $__result_create_device_code = _create_device_code('who2', $_device_code_count, $_user_id, $cookie_name);
        }
        
        if(!$__result_create_device_code){
            die(get_option('field_msg_authorizeddevices_slug'));
        }
    }
}
add_action('wp_login', 'set_device_code', 10, 2);

function _create_device_code($_who, $_device_code_count, $_user_id, $cookie_name){
    if(intval($_device_code_count) == intval(get_option('field_authorizeddevices_slug'))){
        return false;
    }
    $_device_code_count = intval($_device_code_count) + 1;
    update_user_meta($_user_id, 'device_code_count', $_device_code_count);

    $_device_code = _generateRandomString();
    add_user_meta($_user_id, 'device_code_'.$_device_code_count, $_device_code);
    setcookie($cookie_name, $_device_code, time() + (86400 * 365), "/");
    return true;
}


function _generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}