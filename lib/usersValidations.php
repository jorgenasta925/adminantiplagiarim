 <?php

$functions = [
    'redirect' => 'redirectTo',
    'exception' => 'createException'
];

function checkSession($action, $callbackParams) {
    global $functions;
    $sessionStatus = isloggedin();

    if (!($sessionStatus)) {
        call_user_func($functions[$action], ...$callbackParams);
    }
}

function checkUserRole($action, $callbackParams) {
    global $functions, $USER;

    $context = context_system::instance();

    if (is_siteadmin($USER->id)) {
        // El usuario es un administrador, permitimos el acceso.
        return;
    } elseif (has_capability('local/adminantiplagiarim:manage', $context)) {
        // Si el usuario tiene la capacidad `local/slider_form:manage`, se le permite el acceso.
        return;
    } else {
        // Si el usuario es aprendiz o instructor, se le redirige.
        call_user_func($functions[$action], ...$callbackParams);
    }
}

function redirectTo($url) {
    header("Location: $url");
    exit();
}

function createException($message) {
    throw new \moodle_exception($message);
}

    // $functions = [

    //     'redirect' => 'redirectTo',
    //     'exception' => 'createException'

    // ];

    // function checkSession($action, $callbackParams) {

    //     global $functions;

    //     $sessionStatus = isloggedin();

    //     if(!($sessionStatus)) {
    //         call_user_func($functions[$action], ...$callbackParams);
    //     }

    // }

    // function checkUserRole($action, $callbackParams) {

    //     global $functions;

    //     $context = context_system::instance();

    //     $capability = has_capability('local/adminantiplagiarim:manage', $context);

    //     if (!$capability) {
    //         call_user_func($functions[$action], ...$callbackParams);
    //     }

    // } 



   
    


