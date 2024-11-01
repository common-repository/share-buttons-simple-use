<?php
/*
Plugin Name: Share Buttons Simple Use
Plugin URI: http://rubensargsyan.com/wordpress-plugin-share-buttons-simple-use/
Description: This is a simple use plugin which displays the share buttons (Facebook Like, Tweet and Google plus buttons) on the bottom or on the top of the posts and pages. <a href="options-general.php?page=share-buttons-simple-use.php">Settings</a>
Version: 1.3
Author: Ruben Sargsyan
Author URI: http://rubensargsyan.com/
*/

/*  Copyright 2012 Ruben Sargsyan (email: info@rubensargsyan.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$share_buttons_simple_use_plugin_url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
$share_buttons_simple_use_plugin_title = "Share Buttons Simple Use";
$share_buttons_simple_use_plugin_prefix = "share_buttons_simple_use_";
$share_buttons_simple_use_version = "1.3";

function load_share_buttons_simple_use(){
    $plugin_prefix = "share_buttons_simple_use_";
    $version = "1.3";

    if(get_share_buttons_simple_use_settings()===false){
        set_default_share_buttons_simple_use_settings();
    }

    if(get_option("share_buttons_simple_use_version")===false){
        add_option("share_buttons_simple_use_version",$version);
    }elseif(get_option("share_buttons_simple_use_version")<$version){
        $current_settings = get_share_buttons_simple_use_settings();

        unset($current_settings["buzz_style"]);

        $settings = array_merge($current_settings,array("gplus_size"=>"standard","gplus_annotation"=>"inline","gplus_width"=>450));

        update_option($plugin_prefix."settings",$settings);
        update_option("share_buttons_simple_use_version",$version);
    }
}

function set_share_buttons_simple_use_settings($settings){
    $plugin_prefix = "share_buttons_simple_use_";

    add_option($plugin_prefix."settings",$settings);
}

function set_default_share_buttons_simple_use_settings(){
    $plugin_prefix = "share_buttons_simple_use_";

    $settings = array("tweet_data_count"=>"none","fblike_layout"=>"standard","fblike_show_faces"=>"true","fblike_width"=>450,"fblike_action"=>"like","fblike_font"=>"none","fblike_colorscheme"=>"light","fblike_height"=>80,"gplus_size"=>"standard","gplus_annotation"=>"inline","gplus_width"=>450,"display_tweet"=>"yes","display_fblike"=>"yes","display_gplus"=>"yes","single_pages"=>"only_single_pages","pages"=>"false","placement"=>"at_the_bottom");

    set_share_buttons_simple_use_settings($settings);
}

function update_share_buttons_simple_use_settings($settings){
    global $share_buttons_simple_use_plugin_prefix;

    $current_settings = get_share_buttons_simple_use_settings();

    $settings = array_merge($current_settings,$settings);

    update_option($share_buttons_simple_use_plugin_prefix."settings",$settings);
}

function get_share_buttons_simple_use_settings(){
    global $share_buttons_simple_use_plugin_prefix;

    $settings = get_option($share_buttons_simple_use_plugin_prefix."settings");

    return $settings;
}

function share_buttons_simple_use_menu(){
    if(function_exists('add_options_page')){
        add_options_page('Share Buttons Simple Use','Share Buttons Simple Use', 'manage_options', basename(__FILE__), 'share_buttons_simple_use_admin') ;
    }
}

function share_buttons_simple_use_admin(){
    global $share_buttons_simple_use_plugin_url, $share_buttons_simple_use_plugin_title, $share_buttons_simple_use_plugin_prefix;

    if($_GET["page"]==basename(__FILE__)){
        if($_POST["action"]=="save"){
            switch($_POST[$share_buttons_simple_use_plugin_prefix."tweet_data_count"]){
                case "vertical":
                $tweet_data_count = "vertical";
                break;
                case "horizontal":
                $tweet_data_count = "horizontal";
                break;
                case "none":
                $tweet_data_count = "none";
                break;
                default:
                $tweet_data_count = "vertical";
            }
            switch($_POST[$share_buttons_simple_use_plugin_prefix."fblike_layout"]){
                case "standard":
                $fblike_layout = "standard";
                break;
                case "button_count":
                $fblike_layout = "button_count";
                break;
                case "box_count":
                $fblike_layout = "box_count";
                break;
                default:
                $fblike_layout = "standard";
            }
            if(isset($_POST[$share_buttons_simple_use_plugin_prefix."fblike_show_faces"])){
                $fblike_show_faces = "true";
            }else{
                $fblike_show_faces = "false";
            }
            if(is_numeric($_POST[$share_buttons_simple_use_plugin_prefix."fblike_width"])){
                $fblike_width = intval($_POST[$share_buttons_simple_use_plugin_prefix."fblike_width"]);
            }else{
                $fblike_width = 450;
            }
            switch($_POST[$share_buttons_simple_use_plugin_prefix."fblike_action"]){
                case "like":
                $fblike_action = "like";
                break;
                case "recommend":
                $fblike_action = "recommend";
                break;
                default:
                $fblike_action = "like";
            }
            switch($_POST[$share_buttons_simple_use_plugin_prefix."fblike_font"]){
                case "none":
                $fblike_font = "none";
                break;
                case "arial":
                $fblike_font = "arial";
                break;
                case "lucida+grande":
                $fblike_font = "lucida+grande";
                break;
                case "segoe+ui":
                $fblike_font = "segoe+ui";
                break;
                case "tahoma":
                $fblike_font = "tahoma";
                break;
                case "trebuchet+ms":
                $fblike_font = "trebuchet+ms";
                break;
                case "verdana":
                $fblike_font = "verdana";
                break;
                default:
                $fblike_font = "none";
            }
            switch($_POST[$share_buttons_simple_use_plugin_prefix."fblike_colorscheme"]){
                case "light":
                $fblike_colorscheme = "light";
                break;
                case "dark":
                $fblike_colorscheme = "dark";
                break;
                default:
                $fblike_colorscheme = "light";
            }
            if(is_numeric($_POST[$share_buttons_simple_use_plugin_prefix."fblike_height"])){
                $fblike_height = intval($_POST[$share_buttons_simple_use_plugin_prefix."fblike_height"]);
            }else{
                $fblike_height = 80;
            }
            switch($_POST[$share_buttons_simple_use_plugin_prefix."gplus_size"]){
                case "small":
                $gplus_size = "small";
                break;
                case "medium":
                $gplus_size = "medium";
                break;
                case "tall":
                $gplus_size = "tall";
                break;
                default:
                $gplus_size = "standard";
            }
            switch($_POST[$share_buttons_simple_use_plugin_prefix."gplus_annotation"]){
                case "inline":
                $gplus_annotation = "inline";
                break;
                case "none":
                $gplus_annotation = "none";
                break;
                default:
                $gplus_annotation = "bubble";
            }
            if(is_numeric($_POST[$share_buttons_simple_use_plugin_prefix."gplus_width"])){
                $gplus_width = intval($_POST[$share_buttons_simple_use_plugin_prefix."gplus_width"]);
            }else{
                $gplus_width = 450;
            }
            if(isset($_POST[$share_buttons_simple_use_plugin_prefix."display_tweet"])){
                $display_tweet = "yes";
            }else{
                $display_tweet = "no";
            }
            if(isset($_POST[$share_buttons_simple_use_plugin_prefix."display_fblike"])){
                $display_fblike = "yes";
            }else{
                $display_fblike = "no";
            }
            if(isset($_POST[$share_buttons_simple_use_plugin_prefix."display_gplus"])){
                $display_gplus = "yes";
            }else{
                $display_gplus = "no";
            }
            if(isset($_POST[$share_buttons_simple_use_plugin_prefix."single_pages"])){
                $single_pages = "only_single_pages";
            }else{
                $single_pages = "not_only_single_pages";
            }
            if(isset($_POST[$share_buttons_simple_use_plugin_prefix."pages"])){
                $pages = "true";
            }else{
                $pages = "false";
            }
            switch($_POST[$share_buttons_simple_use_plugin_prefix."placement"]){
                case "at_the_bottom":
                $placement = "at_the_bottom";
                break;
                case "at_the_top":
                $placement = "at_the_top";
                break;
                default:
                $placement = "at_the_bottom";
            }

            $new_settings = array("tweet_data_count"=>$tweet_data_count,"fblike_layout"=>$fblike_layout,"fblike_show_faces"=>$fblike_show_faces,"fblike_width"=>$fblike_width,"fblike_action"=>$fblike_action,"fblike_font"=>$fblike_font,"fblike_colorscheme"=>$fblike_colorscheme,"fblike_height"=>$fblike_height,"gplus_size"=>$gplus_size,"gplus_annotation"=>$gplus_annotation,"gplus_width"=>$gplus_width,"display_tweet"=>$display_tweet,"display_fblike"=>$display_fblike,"display_gplus"=>$display_gplus,"single_pages"=>$single_pages,"pages"=>$pages,"placement"=>$placement);

            update_share_buttons_simple_use_settings($new_settings);

            echo('<div id="message" class="updated fade"><p><strong>'.$share_buttons_simple_use_plugin_title.' Settings Saved.</strong></p></div>');
        }elseif($_POST["action"]=="reset"){
            delete_option($share_buttons_simple_use_plugin_prefix."settings");

            echo('<div id="message" class="updated fade"><p><strong>'.$share_buttons_simple_use_plugin_title.' Settings Reset.</strong></p></div>');
        }
    }

    if(get_share_buttons_simple_use_settings()===false){
        set_default_share_buttons_simple_use_settings();
    }

    $settings = get_share_buttons_simple_use_settings();
    ?>
    <div class="wrap">
      <div style="margin: 20px 0; text-align: center; display: inline-block"><div style="float: left"><div><a href="http://blorner.com?utm_source=share-buttons-simple-use&utm_medium=banner&utm_campaign=admin" target="_blank"><img src="http://banners.blorner.com/blorner.com-468x60.jpg" alt="Blorner" style="border: none" /></a></div><div style="margin-top: 30px"><a href="http://ref.webhostinghub.com/scripts/click.php?ref_id=rubensargsyan&amp;ad_id=f860f28e" target="_top"><img src="http://ref.webhostinghub.com/accounts/default1/banners/hub_468_60_easy-1.gif" style="border: 0;" alt="" width="468" height="60" /></a><img style="border:0" src="http://ref.webhostinghub.com/scripts/imp.php?ref_id=rubensargsyan&amp;ad_id=f860f28e" width="1" height="1" alt="" /></div></div><div style="float: right; margin-left: 50px; text-align: justify; width: 400px; border: 1px solid #DFDFDF; padding: 10px;"><div style="float: left; margin-right: 10px;"><a href="http://rubensargsyan.com/wordpress-plugin-ubm-premium/" target="_blank"><img src="http://rubensargsyan.com/images/ubm-premium.png" alt="UBM Premium" style="border: none" /></a></div><div style="font-size: 11px">UBM Premium is the ultimate banner manager WordPress plugin for the serious bloggers. Rotate banners based on performance, track outgoing clicks, control nofollow/dofollow and much more. The perfect solution for all affiliate marketers and webmasters.</div></div></div>

      <h1><?php echo $share_buttons_simple_use_plugin_title; ?></h1>
      <h2>Settings</h2>

      <form method="post">
        <table width="100%" border="0" id="share_buttons_simple_use_settings_table">
          <tr>
            <td colspan="2"><h3>Tweet Button Settings</h3></td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Data Count</strong></td>
            <td width="85%">
                <label for="<?php echo($share_buttons_simple_use_plugin_prefix); ?>vertical">Vertical:</label> <input name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>tweet_data_count" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>vertical" value="vertical" type="radio" <?php if($settings["tweet_data_count"]=="vertical"){ echo('checked="checked"'); } ?> />&nbsp;&nbsp;<label for="<?php echo($share_buttons_simple_use_plugin_prefix); ?>horizontal">Horizontal:</label> <input name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>tweet_data_count" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>horizontal" value="horizontal" type="radio" <?php if($settings["tweet_data_count"]=="horizontal"){ echo('checked="checked"'); } ?> />&nbsp;&nbsp;<label for="<?php echo($share_buttons_simple_use_plugin_prefix); ?>none">None:</label> <input name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>tweet_data_count" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>none" value="none" type="radio" <?php if($settings["tweet_data_count"]=="none"){ echo('checked="checked"'); } ?> />
            </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><h3>Facebook Like Button Settings</h3></td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Layout Style</strong></td>
            <td width="85%">
                <select name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_layout" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_layout" style="width: 110px">
                    <option value="standard" <?php if($settings["fblike_layout"]=="standard"){ echo('selected="selected"'); } ?>>standard</option>
                    <option value="button_count" <?php if($settings["fblike_layout"]=="button_count"){ echo('selected="selected"'); } ?>>button_count</option>
                    <option value="box_count" <?php if($settings["fblike_layout"]=="box_count"){ echo('selected="selected"'); } ?>>box_count</option>
                </select>
            </td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Show Faces</strong></td>
            <td width="85%">
                <label for="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_show_faces">Show faces</label>: <input type="checkbox" name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_show_faces" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_show_faces" value="true" <?php if($settings["fblike_show_faces"]=="true"){ echo('checked="checked"'); } ?> />
            </td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Width</strong></td>
            <td width="85%">
                <input type="text" name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_width" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_width" value="<?php echo($settings["fblike_width"]); ?>" style="width: 60px" />
            </td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Verb To Display</strong></td>
            <td width="85%">
                <select name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_action" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_action" style="width: 110px">
                    <option value="like" <?php if($settings["fblike_action"]=="like"){ echo('selected="selected"'); } ?>>like</option>
                    <option value="recommend" <?php if($settings["fblike_action"]=="recommend"){ echo('selected="selected"'); } ?>>recommend</option>
                </select>
            </td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Font</strong></td>
            <td width="85%">
                <select name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_font" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_font" style="width: 110px">
                    <option value="none" <?php if($settings["fblike_font"]=="none"){ echo('selected="selected"'); } ?>></option>
                    <option value="arial" <?php if($settings["fblike_font"]=="arial"){ echo('selected="selected"'); } ?>>arial</option>
                    <option value="lucida+grande" <?php if($settings["fblike_font"]=="lucida+grande"){ echo('selected="selected"'); } ?>>lucida grande</option>
                    <option value="segoe+ui" <?php if($settings["fblike_font"]=="segoe+ui"){ echo('selected="selected"'); } ?>>segoe ui</option>
                    <option value="tahoma" <?php if($settings["fblike_font"]=="tahoma"){ echo('selected="selected"'); } ?>>tahoma</option>
                    <option value="trebuchet+ms" <?php if($settings["fblike_font"]=="trebuchet+ms"){ echo('selected="selected"'); } ?>>trebuchet ms</option>
                    <option value="verdana" <?php if($settings["fblike_font"]=="verdana"){ echo('selected="selected"'); } ?>>verdana</option>
                </select>
            </td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Color Scheme</strong></td>
            <td width="85%">
                <select name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_colorscheme" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_colorscheme" style="width: 60px">
                    <option value="light" <?php if($settings["fblike_colorscheme"]=="light"){ echo('selected="selected"'); } ?>>light</option>
                    <option value="dark" <?php if($settings["fblike_colorscheme"]=="dark"){ echo('selected="selected"'); } ?>>dark</option>
                </select>
            </td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Height</strong></td>
            <td width="85%">
                <input type="text" name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_height" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>fblike_height" value="<?php echo($settings["fblike_height"]); ?>" style="width: 60px" />
            </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><h3>Google Plus Button Settings</h3></td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Size</strong></td>
            <td width="85%">
                <select name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>gplus_size" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>gplus_size" style="width: 110px">
                    <option value="standard" <?php if($settings["gplus_size"]=="standard"){ echo('selected="selected"'); } ?>>standard</option>
                    <option value="small" <?php if($settings["gplus_size"]=="small"){ echo('selected="selected"'); } ?>>small</option>
                    <option value="medium" <?php if($settings["gplus_size"]=="medium"){ echo('selected="selected"'); } ?>>medium</option>
                    <option value="tall" <?php if($settings["gplus_size"]=="tall"){ echo('selected="selected"'); } ?>>tall</option>
                </select>
            </td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Annotation</strong></td>
            <td width="85%">
                <select name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>gplus_annotation" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>gplus_annotation" style="width: 110px">
                    <option value="bubble" <?php if($settings["gplus_annotation"]=="bubble"){ echo('selected="selected"'); } ?>>bubble</option>
                    <option value="inline" <?php if($settings["gplus_annotation"]=="inline"){ echo('selected="selected"'); } ?>>inline</option>
                    <option value="none" <?php if($settings["gplus_annotation"]=="none"){ echo('selected="selected"'); } ?>>none</option>
                </select>
            </td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Width</strong></td>
            <td width="85%">
                <input type="text" name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>gplus_width" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>gplus_width" value="<?php echo($settings["gplus_width"]); ?>" style="width: 60px" />
            </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><h3>Display Settings</h3></td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Buttons</strong></td>
            <td width="85%">
                <label for="<?php echo($share_buttons_simple_use_plugin_prefix); ?>display_tweet">Display tweet button</label>: <input type="checkbox" name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>display_tweet" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>display_tweet" value="yes" <?php if($settings["display_tweet"]=="yes"){ echo('checked="checked"'); } ?> />&nbsp;&nbsp;<label for="<?php echo($share_buttons_simple_use_plugin_prefix); ?>display_fblike">Display facebook like button</label>: <input type="checkbox" name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>display_fblike" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>display_fblike" value="yes" <?php if($settings["display_fblike"]=="yes"){ echo('checked="checked"'); } ?> />&nbsp;&nbsp;<label for="<?php echo($share_buttons_simple_use_plugin_prefix); ?>display_gplus">Display google plus button</label>: <input type="checkbox" name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>display_gplus" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>display_gplus" value="yes" <?php if($settings["display_gplus"]=="yes"){ echo('checked="checked"'); } ?> />
            </td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Pages:</strong></td>
            <td width="85%">
                <label for="<?php echo($share_buttons_simple_use_plugin_prefix); ?>single_pages">Display buttons only on the single pages</label>: <input type="checkbox" name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>single_pages" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>single_pages" value="only_single_pages" <?php if($settings["single_pages"]=="only_single_pages"){ echo('checked="checked"'); } ?> />&nbsp;&nbsp;<label for="<?php echo($share_buttons_simple_use_plugin_prefix); ?>pages">Display buttons on the pages</label>: <input type="checkbox" name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>pages" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>pages" value="true" <?php if($settings["pages"]=="true"){ echo('checked="checked"'); } ?> />
            </td>
          </tr>
          <tr>
            <td width="15%" valign="middle"><strong>Placement</strong></td>
            <td width="85%">
                <label for="<?php echo($share_buttons_simple_use_plugin_prefix); ?>at_the_bottom">At the bottom:</label> <input name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>placement" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>at_the_bottom" value="vertical" type="radio" <?php if($settings["placement"]=="at_the_bottom"){ echo('checked="checked"'); } ?> />&nbsp;&nbsp;<label for="<?php echo($share_buttons_simple_use_plugin_prefix); ?>at_the_top">At the top:</label> <input name="<?php echo($share_buttons_simple_use_plugin_prefix); ?>placement" id="<?php echo($share_buttons_simple_use_plugin_prefix); ?>at_the_top" value="at_the_top" type="radio" <?php if($settings["placement"]=="at_the_top"){ echo('checked="checked"'); } ?> />
            </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
        <p class="submit">
          <input name="save" type="submit" value="Save changes" />
          <input type="hidden" name="action" value="save" />
        </p>
      </form>
      <form method="post">
        <p class="submit">
          <input name="reset" type="submit" value="Reset" />
          <input type="hidden" name="action" value="reset" />
        </p>
      </form>
      <p>
        <div>If you find this plugin useful to you, please consider making a small donation to help contribute to further development. Thanks for your kind support!</div>
        <a href="http://rubensargsyan.com/donate/" target="_blank"><img src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" alt="Donate" /></a>
      </p>
    </div>
    <?php
}

function add_share_buttons_simple_use($content){
    global $share_buttons_simple_use_plugin_prefix;

    $settings = get_share_buttons_simple_use_settings();
    $post_id = get_the_ID();

    $post = get_post($post_id);

    $share_buttons = '<div class="share_buttons_simple_use_buttons" style="padding: 10px 0; display: inline-block">';

    if($settings["display_tweet"]=="yes"){
        $share_buttons .= '<div class="tweet_button" style="float: left; vertical-align: top"><a href="http://twitter.com/share" class="twitter-share-button" data-url="'.get_permalink($post->ID).'" data-text="'.$post->post_title.'" data-count="'.$settings["tweet_data_count"].'">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>';
    }

    if($settings["display_gplus"]=="yes"){
        $gplus_size = "";
        $gplus_annotation = "";

        if($settings["gplus_size"]!="standard"){
            $gplus_size = 'size="'.$settings["gplus_size"].'"';
        }

        if($settings["gplus_annotation"]!="bubble"){
            $gplus_annotation = 'annotation="'.$settings["gplus_annotation"].'"';
        }

        $share_buttons .= '<div class="google_plus_button" style="float: left; vertical-align: top; margin-left: 10px; max-width: 175px"><g:plusone '.$gplus_size.' '.$gplus_annotation.' width="'.$settings["gplus_width"].'"></g:plusone></div>';
    }

    if($settings["display_fblike"]=="yes"){
        $share_buttons .= '<div class="facebook_like_button" style="float: left; vertical-align: top; margin-left: 10px; max-width: 255px"><iframe src="http://www.facebook.com/plugins/like.php?href='.urlencode(get_permalink($post->ID)).'&amp;layout='.$settings["fblike_layout"].'&amp;show_faces='.$settings["fblike_show_faces"].'&amp;width='.$settings["fblike_width"].'&amp;action='.$settings["fblike_action"];
        if($settings["fblike_font"]!="none"){
            $share_buttons .= "&amp;font=".$settings["fblike_font"];
        }
        $share_buttons .= '&amp;colorscheme='.$settings["fblike_colorscheme"].'&amp;height='.$settings["fblike_height"].'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$settings["fblike_width"].'px; height:'.$settings["fblike_height"].'px;" allowTransparency="true"></iframe></div>';
    }

    $share_buttons .= '</div>';

    if($settings["single_pages"]=="only_single_pages" && $settings["pages"]=="false"){
        if(is_single() && !is_page($post_id)){
            if($settings["placement"]=="at_the_top"){
                $content = $share_buttons.$content;
            }else{
                $content .= $share_buttons;
            }
        }
    }elseif($settings["single_pages"]=="only_single_pages" && $settings["pages"]=="true"){
        if(is_singular()){
            if($settings["placement"]=="at_the_top"){
                $content = $share_buttons.$content;
            }else{
                $content .= $share_buttons;
            }
        }
    }elseif($settings["single_pages"]=="not_only_single_pages" && $settings["pages"]=="false"){
        if(!is_page($post_id)){
            if($settings["placement"]=="at_the_top"){
                $content = $share_buttons.$content;
            }else{
                $content .= $share_buttons;
            }
        }
    }else{
        if($settings["placement"]=="at_the_top"){
            $content = $share_buttons.$content;
        }else{
            $content .= $share_buttons;
        }
    }

    return str_replace("[share_buttons_simple_use]",$share_buttons,$content);
}

function share_buttons_simple_use_footer(){
    ?>
    <script type="text/javascript">
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
    <?php
}

add_action('plugins_loaded','load_share_buttons_simple_use');
add_action('admin_menu', 'share_buttons_simple_use_menu');
add_action('wp_footer', 'share_buttons_simple_use_footer');
add_filter('the_content', 'add_share_buttons_simple_use');
add_filter('the_excerpt', 'add_share_buttons_simple_use');
?>