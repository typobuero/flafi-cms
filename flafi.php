<?php
/*******************************************************************************

 
  
     .d888 888           .d888 d8b      .d8888b.  888b     d888  .d8888b.  
    d88P"  888          d88P"  Y8P     d88P  Y88b 8888b   d8888 d88P  Y88b 
    888    888          888            888    888 88888b.d88888 Y88b.      
    888888 888  8888b.  888888 888     888        888Y88888P888  "Y888b.   
    888    888     "88b 888    888     888        888 Y888P 888     "Y88b. 
    888    888 .d888888 888    888     888    888 888  Y8P  888       "888 
    888    888 888  888 888    888     Y88b  d88P 888   "   888 Y88b  d88P 
    888    888 "Y888888 888    888      "Y8888P"  888       888  "Y8888P"  

  
    ~ The Intentionally Featureless Flat File Content Management System ~
 

     Software: flafi CMS
      Version: 2.0 build 0009 2021-11-05
      Creator: Christian Münch, Typobüro
     Web Page: https://typobuero.com
      Project: https://flafi.de
       Github: https://github.com/typobuero/flafi-cms/
      Licence: MIT-NA, https://github.com/typobuero/flafi-cms/blob/main/LICENCE.txt

                                                                                
*******************************************************************************/


 
/******************************************************************************
 *                                                                            *
 *                          H O W   T O   U S E                               *
 *                                                                            *
 ******************************************************************************/

 // flafi is a quick and simple flat file cms.
 // it gives you the possibility to turn a web space into a small modular web page.
 // no database is needed, basically just the flafi.php file.
 // adjacent to flafi.php there is an index.php which is your static html5 template.
 // have subdirectories that will compose your menu items.
 // let flafi generate the clickable <nav> items out of the subdirectories names.
 // when naming subdirectories, an underscore (‘_’) is later seen as a space.
 // in these subdirectories have at least an index.php file with your <main> content
 
 // you can read the Setup section below to tweak the flafi-generated menu.
 // you can make edits in the Template section to tweak the <nav> appearence.
 // flafi includes 'normalize.css' (github.com/necolas/normalize.css).
 // flafi comes with a simple visual theme; make your edits in styles.css.
 // or totally write your own stuff and enhance flafi to cater for your needs.  
  
 // flafi is intentionally very basic with no fancy features.
 // because sometimes it’s exactly that what is needed for certain projects.
 

  
/******************************************************************************
 *                                                                            *
 *                              S E T U P                                     *
 *                                                                            *
 ******************************************************************************/
 
// show php errors on web page
// dev: 1, live: 0
ini_set('display_errors', 0);


// where to start with looking for menu items (file system directories)
// default '' means: where this script runs; you can define a subdirectory here
define('MENUROOT', '');
 

// ability to manually sort the menu items
// values must match existing directory names - or will be discarded
// optional; leave array empty or comment out if not needed
$order = array('home', 'page');


// whitelist of directories that should appear in the menu
// but menu items NOT stated here, will still be accessible via url,
// optional; leave array empty or comment out if not needed
$visible = array();


// blacklist of directories that should NOT appear in the menu
// but they will be accessible via url
// optional; leave empty or comment out if not needed 
$hidden = array('hidden');


// blacklist of directories that should not appear in the menu
// and should not be accessible via url, therefore be protected from access
// the content of the first menu item will be displayed instead
// optional; leave empty or comment out if not needed
$protected = array('protected');



/******************************************************************************
 *                                                                            *
 *                           T E M P L A T E S                                *
 *                                                                            *
 ******************************************************************************/

// here are the template strings that will compose the flafi navigation
// they are kept pretty basic and contain a bare minimum of elements
// you can adjust the markup to fit your needs, but you don’t have to
// flafi code will fall back to defaults, should something be wrong here 

// $TPL_nav_wrapper is the html5 element that will be filled with navigation items
// it must contain the keyword 'NAV_ITEM' in the middle of it as a placeholder
// input and label is added for playing out a collapsible mobile menu with the CSS
$TPL_nav_wrapper = '<input id="nav-collapsible" type="checkbox" style="display: none;">
                    <label for="nav-collapsible" style="display: none;">Menu</label>
                    <nav>
                         <ul>
                         NAV_ITEM
                         </ul>
                    </nav>';

// $TPL_nav_item is the item that will be repeated for every menu item
// it must contain certain keywords to operate as intented
// ACTIVE: is where css class="active" will be placed, if item is the requested one 
// LINK: is the url to the index file of the menu item
// NAME: is the visible menu name on the web page - the name of the subdirectory
$TPL_nav_item =    '<li ACTIVE >
                         <a href="LINK" target="_self">NAME</a>
                    </li>';
           



/******************************************************************************
 *                                                                            *
 *                                C O D E                                     *
 *                                                                            *
 ******************************************************************************/
 
// collects subdirectories from the file system
// which will later act as our menu items
function collect_menu($subdir = '', $accessible = false) {
global $order, $visible, $hidden, $protected;

    // init resulting array
    $menuitems = array(); $i=0;

    // get current path
    $path = rtrim(getcwd(), '/') . $subdir;

    // check if directory is valid
    if ( is_dir($path) ) {
         // read content of current directory
         $scan = array_diff( scandir($path), array('.', '..') );
         }
    else {
         // if no valid directory is provided
         // return with empty array, to trigger the big error message
         return array();
         }
    # print_r($scan);

    // use really only directories
    $dirs = array();
    foreach ($scan as $dir) { if (is_dir($path.$dir)) $dirs[] = $dir; }
    # echo 'file system: '; print_r($dirs); echo '<br>';

    // sort menu items according to $order array, if present
    if ( isset($order) && count($order) ) {

        // use only directories which are present in the $order array
        $intersect  = array_intersect($order, $dirs);
        # echo 'intersect '; print_r($intersect); echo '<br>';
        
        // filter leftover directories that are present, but have no special order
        $diff = array_diff($dirs, $intersect);
        # echo 'diff: '; print_r($diff); echo '<br>';

        // if no leftovers
        if ( count($diff) == 0 ) {
             // just use $intersect result 
             $dirs = $intersect; }
        else {
             // append leftovers alphabetically
             natsort($diff);
             $dirs = array_merge($intersect, $diff); 
             }
        # echo 'ordered menu items: '; print_r($dirs); echo '<br>'; 
        }
    
     // discern between url-accessible but visually hidden items and protected dirs
     if ( $accessible ) {
          // special case for checking with is_menu()
          // output also 'hidden' items, but no 'protected' ones
          
          // if $protected is used and is not empty, filter out menu items that should not be accessible
          $dirs = ( isset($protected) && count($protected) ) ? array_diff($dirs, $protected) : $dirs;
          # echo 'visible menu items - protected: '; print_r($dirs); echo '<br>';
          }
     else {
          // normal case for collecting menu items
          // output only visually available items
          
          // if $visible is used and is not empty, use only menu items stated as visible
          $dirs = ( isset($visible) && count($visible) ) ? array_intersect($dirs, $visible) : $dirs;
          # echo 'visible menu items: '; print_r($dirs); echo '<br>';

          // if $hidden is used and is not empty, filter out menu items that should be hidden
          $dirs = ( isset($hidden) && count($hidden) ) ? array_diff($dirs, $hidden) : $dirs;
          # echo 'visible menu items - hidden: '; print_r($dirs); echo '<br>';
          
          // if $protected is used and is not empty, filter out menu items that should not be accessible
          $dirs = ( isset($protected) && count($protected) ) ? array_diff($dirs, $protected) : $dirs;
          # echo 'visible menu items - protected: '; print_r($dirs); echo '<br>';
          }
  
return $dirs;
}



// creates html menu items from the subdirectories 
// using the predefined templates
function create_menu($subdir = '') {
global $TPL_nav_wrapper, $TPL_nav_item;

    // collect future menu items from directory names
    $menuitems = collect_menu($subdir);
    
    // plausibility check: should no menu item be present, catch this bad oopsy error
    if ( count($menuitems) == 0 ) {
         // output a friendly error message
         echo '<main>
                    <h1>Big Error Message from flafi</h1>
                    <p>
                         I’m sorry I have to display the biggest error message
                         flafi CMS can produce – but here’s the thing:
                         I can’t find a menu item or an index file in <b>'.$subdir.'</b> to work with.
                         <br>
                         To use flafi CMS and have a clickable menu,
                         please create some subdirectories and
                         fill them with an index.php file.
                         <br>
                         This file should output or contain at least a
                         <span><</span>main<span>></span> HTML element
                         where your desired content will be living.
                         <br>
                         Please refert to the How To Use section in flafi.php
                         to read about how to set up flafi CMS. 
                    </p>
                    <p>
                         Should you be sure to have these things and expected flafi to work,
                         please have a look at the Setup section in flafi.php.
                         Check, whether you stated directories in the
                         $visible and $hidden arrays in such a way, that they
                         exclude each other completely, rendering the amount
                         of usable directories/items practically zero.
                         As a fix, empty the $hidden array – that should make it work again.
                    </p>
                    <p>
                         If that’s not a remedy, I have no other clue what
                         could be wrong. You’re on your own now …
                    </p>
              </main>';
          // signal to leave here
          return false;
          }

    // calculate current url
    $url = rtrim(dirname($_SERVER['SCRIPT_NAME']),'/') . $subdir;
     
    // check exactly what url was requested
    // the root directory of the script: use first menu item, calculated by default_menu(),
    // or an actual subdirectory (menu item): use that subdirectory
    $default_menu = default_menu($subdir);
    $req = strncmp($_SERVER['REQUEST_URI'], $url, strlen($url));
    if ($req == 0) { $req = str_replace($url, '', $_SERVER['REQUEST_URI']); } else { $req = $default_menu; }
    $req = rtrim($req, '/');
    if ($req == '') $req = $default_menu;

    // check if we have an accurate 'nav_wrapper' template present – or prepare to use defaults
    // this means, the NAV_ITEM keyword is present somewhere in the middle of the template
    if ( isset($TPL_nav_wrapper) and count($TPL_nav_wrapper = explode('NAV_ITEM', $TPL_nav_wrapper)) == 2 )
       { $wrp = true; } else { $wrp = false; }

    // output 'nav_wrapper' template (first half) – or default
    if ($wrp) { echo $TPL_nav_wrapper[0]; } else { echo "<ul>"; }

            // check if we have an accurate 'nav_item' template present – or default
            // this means, there is a bare minimum of certain keywords present in the template
            if ( isset($TPL_nav_item) and is_int(strpos($TPL_nav_item, 'LINK'))
                                      and is_int(strpos($TPL_nav_item, 'NAME'))
                                      and is_int(strpos($TPL_nav_item, 'ACTIVE')) ) {
                 foreach ($menuitems as $item) {
                     // core action: replace certain keywords from the template
                     $output = str_replace('LINK', $url.$item, $TPL_nav_item);
                     $output = str_replace('NAME', ucwords(str_replace('_', ' ', $item)), $output);
                     $output = ($item == $req) ? str_replace(' ACTIVE ', ' class="active"', $output) : str_replace(' ACTIVE ', '', $output);
                     echo $output;
                     }
                 }
            else {
                // default 'nav_item' output, should no accurate template be found
                foreach ($menuitems as $item) { echo '<li><a href="'.$url.$item.'" target="_self">'.$item.'</a></li>'; }
                }

    // output 'nav_wrapper' template (second half) – or default
    if ($wrp) { echo $TPL_nav_wrapper[1]; } else { echo "</ul>"; }

// successfully passed through menu creation routine
return true;
}



// adds a little bit of security/plausibility
// checks whether a requested url is a valid menu item
function is_menu($subdir = '', $url = '', $accessible = false) {

    // fetch menu items from file system
    $safe_menu_items = collect_menu($subdir, $accessible);
    
    // we don’t need leading slashes here
    $subdir = ltrim($subdir,'/');
    
    // add subdir-string to the known safe menu items
    $i=0;
    foreach ( $safe_menu_items as $item ) {
              $safe_menu_items[$i++] = $subdir.$item.'/';
              }

    // perform the validation and return
    if ( in_array($url, $safe_menu_items) ) return true; else return false;
}



// if menu item has no index, show menu item no. 1 as default
function default_menu($subdir = '', $index = false) {

    // fetch menu items from file system
    $menu_items = collect_menu($subdir);

    // we don’t need the leading slash now
    $subdir = ltrim($subdir, '/');

    // return index.php of first menu in array as default – or just the item name
    if ($index) { return $subdir.$menu_items[0].'/index.php'; } else { return $menu_items[0]; }
    
return false;    
}



// take care of funky garbage slashes in directory strings
function normalize_subdir($subdir) {
     
     $subdir = trim($subdir);
     $subdir = trim($subdir, '/');
     $subdir = ($subdir == '' ) ? '/' : '/'.$subdir.'/';

return $subdir;     
}

  
 
 /*****************************************************************************
 *                                                                            *
 *                            R U N T I M E                                   *
 *                                                                            *
 ******************************************************************************/
 
# echo "starting flafi<br>";

// normalize stated directory for menu items     
$subdir = normalize_subdir(MENUROOT);
     
// if flafi can successfully create a menu from present subdirectories ...
if ( create_menu($subdir) ) {
     
     // ... calculate index file for requested url     
     $url = str_replace(dirname($_SERVER['SCRIPT_NAME']).'/', "", $_SERVER['REQUEST_URI']);
     $index = $url.'index.php';  // file to include
     
     // double check if requested menu item is really valid and safe to include
     if ( is_menu($subdir, $url, true) and is_file($index) ) { include $index; }
     else {
          // make an effort to serve first menu item as a default  
          $default_menu = default_menu($subdir, true);
          if ($default_menu) include $default_menu;
          }
     }

?>