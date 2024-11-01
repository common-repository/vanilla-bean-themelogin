<?php
/*
 * Copyright (C) 2014 Velvary Pty Ltd
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
// upgrade plan to provide autocomplete

namespace VanillaBeans\ThemeLogin;

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

function RegisterSettings() {
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_override');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_hideheading');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_logo');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_sitename');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_css');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_cssfiles');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_cssfilesrelative');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_background');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_bglayout');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_background_fixed');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_bg_width');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_bg_width_unit');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_bg_height');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_bg_height_unit');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_maskit');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_mask');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_bg_colour');
    register_setting('vbean-themelogin-settings', 'vbean_themelogin_text_colour');
//    register_setting('vbean-themelogin-settings', 'vbean_themelogin_label_username');
//    register_setting('vbean-themelogin-settings', 'vbean_themelogin_label_password');
//    register_setting('vbean-themelogin-settings', 'vbean_themelogin_label_remember');
//    register_setting('vbean-themelogin-settings', 'vbean_themelogin_label_logintext');
}

function vbean_themelogin_admin_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('jquery');
}

function vbean_themelogin_admin_styles() {
    wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'VanillaBeans\ThemeLogin\vbean_themelogin_admin_scripts');
add_action('admin_print_styles', 'VanillaBeans\ThemeLogin\vbean_themelogin_admin_styles');

function vbean_rendersettings() {

    $logocss = VBEANTHEMELOGIN_LOGO_LOGINTEMPLATE;
    $nologocss = VBEANTHEMELOGIN_NOLOGO_LOGINTEMPLATE;
    ?>

    <style>
        .statuscolour{

        }
        .colourbox{
            position:relative;
            display:inline-block;
            width:100px;
        }
        .colourboxes{
            position:relative;
            display:inline-block;
        }
        .pixelplug{display:none;}

        .theform{width:50%;min-width: 400px;}

    </style>
    <script language="javascript" type="text/javascript" >
        jQuery(document).ready(function () {
            jQuery(".statuscolour").spectrum({
                showInput: true,
                preferredFormat: "hex",
                allowEmpty: true
            });

        });
    </script>

    <div class="wrap">
        <h2>Vanilla Bean Custom Login Settings</h2>

        <table>
            <tr valign="top">
                <td align="center" class="theform">
                    <form method="post" action="options.php">
                        <?php settings_fields('vbean-themelogin-settings'); ?>
                        <?php do_settings_sections('vbean-themelogin-settings'); ?>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">Override</th>
                                <td><input type="checkbox" class="checkbox" name="vbean_themelogin_override"  id="vbean_themelogin_override" value="1" <?php echo checked(1, get_option('vbean_themelogin_override'), false) ?>  onclick="loadFrame();"/>Override the default login page
                                    <div class="description">Check this to implement overrides specified below.</div>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">Site Title</th>
                                <td><input type="text" class="text" name="vbean_themelogin_sitename"  id="vbean_themelogin_sitename" value="<?php echo get_option('vbean_themelogin_sitename') ?>" style="width:300px;"  onkeyup="loadFrame();"/>
                                    <div class="description">Info when hovering over the logo or heading.</div>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">Hide Heading</th>
                                <td><input type="checkbox" class="checkbox" name="vbean_themelogin_hideheading"  id="vbean_themelogin_hideheading" value="1" <?php echo checked(1, get_option('vbean_themelogin_hideheading'), false) ?>  onclick="loadFrame();"/>Hide the login heading
                                    <div class="description">Hides the login heading when there is no logo</div>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th>Logo</th>
                                <td><label for="upload_image">
                                        <input id="vbean_themelogin_logo" type="text" size="36" name="vbean_themelogin_logo" value="<?php echo \VanillaBeans\vbean_setting('vbean_themelogin_logo', ''); ?>" onchange="loadFrame();" />
                                        <input id="upload_image_button" type="button" value="Choose Logo" />
                                        <br />Enter an URL or upload an image for the banner Logo.
                                    </label>
                                </td>
                            </tr>                

                            <tr valign="top">
                                <th>Page Background</th>
                                <td><label for="upload_image">
                                        <input id="vbean_themelogin_background" type="text" size="36" style="width:300px;" name="vbean_themelogin_background" value="<?php echo \VanillaBeans\vbean_setting('vbean_themelogin_background', ''); ?>" onchange="loadFrame();" />
                                        <input id="upload_background_button" type="button" value="Choose Background" /></label>
                                    <select name="vbean_themelogin_bglayout" id="vbean_themelogin_bglayout" onchange="loadFrame();">
                                        <option value="cover" <?php
                                        if (get_option('vbean_themelogin_bglayout') == 'cover') {
                                            echo ' SELECTED';
                                        }
                                        ?>  >Cover entire page</option>
                                        <option value="no-repeat" <?php
                                        if (get_option('vbean_themelogin_bglayout') == 'no-repeat') {
                                            echo ' SELECTED';
                                        }
                                        ?>  >Singular</option>
                                        <option value="repeat" <?php
                                        if (get_option('vbean_themelogin_bglayout') == 'repeat') {
                                            echo ' SELECTED';
                                        }
                                        ?>  >Tiled</option>
                                        <option value="repeat-x" <?php
                                        if (get_option('vbean_themelogin_bglayout') == 'repeat-x') {
                                            echo ' SELECTED';
                                        }
                                        ?>  >Tiled left to right only</option>
                                        <option value="repeat-y" <?php
                                        if (get_option('vbean_themelogin_bglayout') == 'repeat-y') {
                                            echo ' SELECTED';
                                        }
                                        ?>  >Tiled top to bottom only</option>
                                    </select>
                                    <input type="checkbox" class="checkbox" name="vbean_themelogin_background_fixed"  id="vbean_themelogin_background_fixed" value="1" <?php echo checked(1, get_option('vbean_themelogin_background_fixed'), false) ?> onclick="loadFrame();"/>&nbsp;Background should not scroll with page
                                    <br />Width:<input id="vbean_themelogin_bg_width" type="number" class="number" size="36" style="width:50px;" name="vbean_themelogin_bg_width" value="<?php echo \VanillaBeans\vbean_setting('vbean_themelogin_bg_width', ''); ?>" onchange="loadFrame();" /><select name="vbean_themelogin_bg_width_unit" id="vbean_themelogin_bg_width_unit" onchange="loadFrame();">
                                        <option value="percent" <?php
                                        if (get_option('vbean_themelogin_bg_width_unit') == 'percent') {
                                            echo ' SELECTED';
                                        }
                                        ?>  >%</option>
                                        <option value="pixels" <?php
                                        if (get_option('vbean_themelogin_bg_width_unit') == 'pixels') {
                                            echo ' SELECTED';
                                        }
                                        ?>  >pixels</option></select>
                                    Height:<input id="vbean_themelogin_bg_height" type="number" class="number" size="36" style="width:50px;" name="vbean_themelogin_bg_height" value="<?php echo \VanillaBeans\vbean_setting('vbean_themelogin_bg_height', ''); ?>"  onchange="loadFrame();" /><select name="vbean_themelogin_bg_height_unit" id="vbean_themelogin_bg_height_unit"  onchange="loadFrame();">
                                        <option value="percent" <?php
                                        if (get_option('vbean_themelogin_bg_height_unit') == 'percent') {
                                            echo ' SELECTED';
                                        }
                                        ?>  >%</option>
                                        <option value="pixels" <?php
                                        if (get_option('vbean_themelogin_bg_height_unit') == 'pixels') {
                                            echo ' SELECTED';
                                        }
                                        ?>  >pixels</option>
                                    </select>
                                    <br />You may choose an image for the page background, and specify how it looks.

                                    <br />
                                    <div class="colourboxes">
                                        <div class="colourbox" style="width:160px;">
                                            <div class="colourtitle" style="width:140px;">Background Colour: </div>
                                            <input type="text" name="vbean_themelogin_bg_colour" id="vbean_themelogin_bg_colour"  onchange="loadFrame();" value="<?php echo esc_attr(\VanillaBeans\vbean_setting('vbean_themelogin_bg_colour', '')); ?>" class="statuscolour" />
                                        </div>
                                        <!--                                        <div class="colourbox" style="width:160px;">
                                                                                    <div class="colourtitle" style="width:140px;">Label Colour: </div>
                                                                                    <input type="text" name="vbean_themelogin_label_colour" id="vbean_themelogin_label_colour"  onchange="loadFrame();" value="<?php echo esc_attr(\VanillaBeans\vbean_setting('vbean_themelogin_label_colour', '')); ?>" class="statuscolour" />
                                                                                </div>
                                                                                <div class="colourbox" style="width:160px;">
                                                                                    <div class="colourtitle" style="width:140px;">Link Colour: </div>
                                                                                    <input type="text" name="vbean_themelogin_link_colour" id="vbean_themelogin_link_colour"  onchange="loadFrame();" value="<?php echo esc_attr(\VanillaBeans\vbean_setting('vbean_themelogin_link_colour', '')); ?>" class="statuscolour" />
                                                                                </div>-->
                                    </div>

                                </td>
                            </tr>                

                               <tr valign="top">
                                <th>Current Selection</th>
                                <td>
                                    <textarea cols="60" readonly="readonly" rows="1" id="cssselector"></textarea>

                                   

                                </td>
                            </tr>    

                            <tr valign="top">
                                <th>CSS Override</th>
                                <td>
                                    <textarea cols="60" rows="6" name="vbean_themelogin_css" id="vbean_themelogin_css"><?php echo get_option('vbean_themelogin_css') ?></textarea>

                                    <div class="description">Styles to override the login page styles. <button id="showstylesbutton">Show Login Styles</button> </div>


                                </td>
                            </tr>                

                            <tr valign="top">
                                <th>CSS files</th>
                                <td><input type="checkbox" class="checkbox" name="vbean_themelogin_cssfilesrelative"  id="vbean_themelogin_cssfilesrelative" value="1" <?php echo checked(1, get_option('vbean_themelogin_cssfilesrelative'), false) ?>/>Relative to theme<br /> 
                                    <textarea cols="60" rows="6" name="vbean_themelogin_cssfiles" id="vbean_themelogin_cssfiles"><?php echo get_option('vbean_themelogin_cssfiles') ?></textarea>

                                    <div class="description">Path to css files you would like to load for login page.</div>


                                </td>
                            </tr>                

                        </table>

                        <?php submit_button(); ?>
                    </form>

                </td>
                <td align="center">
                    <iframe id="loginpreview" style="width:100%;height:100%;min-width:400px;min-height: 640px;border:1px solid;" src="<?= admin_url('admin-ajax.php') ?>?action=loginformpreview" onload="parent.iframeloaded();">
                    </iframe>
                </td>
            </tr>

        </table>

    </div>
    <span class="pixelplug"><img src="https://stage.velvary.com.au/wpi/img/vanilla-bean-themelogin.png" width="1" height="1"></span>
    <pre>
        <?php
//    echo get_stylesheet_directory_uri();
//    echo PHP_EOL;
//        $theme = get_theme_root_uri();
//        var_dump($theme);
        ?>
                    
    </pre>


    <div style="display:none;" id="loginstyleshiddendiv">
        <pre id="csscodeforlogin">
                /* below are styles specified in wordpress css
                    be sure to use !important */
                    body.login {}
                    body.login div#login {}
                    body.login div#login h1 {}
                    body.login div#login h1 a {}
                    body.login div#login form#loginform {}
                    body.login div#login form#loginform p {}
                    body.login div#login form#loginform p label {}
                    body.login div#login form#loginform input {}
                    body.login div#login form#loginform input#user_login {}
                    body.login div#login form#loginform input#user_pass {}
                    body.login div#login form#loginform p.forgetmenot {}
                    body.login div#login form#loginform p.forgetmenot input#rememberme {}
                    body.login div#login form#loginform p.submit {}
                    body.login div#login form#loginform p.submit input#wp-submit {}
                    body.login div#login p#nav {}
                    body.login div#login p#nav a {}
                    body.login div#login p#backtoblog {}
                    body.login div#login p#backtoblog a {}    
        </pre>
        <div><button id="hidestylesusedforlogin">Hide</button></div>
    </div>
    <div style="display:none;" id="wordpresscss">
        /* used for login header */
        .login h1 a {
        background-image: url('../images/w-logo-blue.png?ver=20131202');
        background-image: none, url('../images/wordpress-logo.svg?ver=20131107');
        background-size: 80px 80px;
        background-position: center top;
        background-repeat: no-repeat;
        color: #999;
        height: 80px;
        font-size: 20px;
        font-weight: normal;
        line-height: 1.3em;
        margin: 0 auto 25px;
        padding: 0;
        text-decoration: none;
        width: 80px;
        text-indent: -9999px;
        outline: none;
        overflow: hidden;
        display: block;
        }
    </div>



    <script language="JavaScript">

        if (!String.prototype.endsWith) {
            String.prototype.endsWith = function (searchString, position) {
                var subjectString = this.toString();
                if (typeof position !== 'number' || !isFinite(position) || Math.floor(position) !== position || position > subjectString.length) {
                    position = subjectString.length;
                }
                position -= searchString.length;
                var lastIndex = subjectString.indexOf(searchString, position);
                return lastIndex !== -1 && lastIndex === position;
            };
        }


        var theformfield;
        var loginpreviewurl = '<?= admin_url('admin-ajax.php') ?>?action=loginformpreview';
        var regopreviewurl = '<?= admin_url('admin-ajax.php') ?>?action=regopreview';

        var vbautocss;
        var vbcustomcss;
        var logocss = '<?php echo $logocss ?>';
        var nologocss = '<?php echo $nologocss ?>';
        var previewframe = document.getElementById('loginpreview');
        var loginform;
        var previewdoc;
        var previewhead;
        var childframe;
        var h1text;
        var thedoc;
        var thecss;
        var thelogocss;
        var backgroundcss;
        var override = false;
        function loadFrame() {
            override = jQuery('#vbean_themelogin_override').attr('checked') == 'checked';
            vbautocss = previewdoc.getElementById('vanilla-bean-themelogin-auto');
            vbcustomcss = previewdoc.getElementById('vanilla-bean-themelogin-custom');

            jQuery(vbautocss).remove();
            jQuery(vbcustomcss).remove();
            renderBackground();
            renderLogo();
            renderCss();
            //renderOther();

        }

        function iframeloaded() {
            console.log('loaded');
            previewdoc = document.getElementById('loginpreview').contentWindow.document;
            vbautocss = previewdoc.getElementById('vanilla-bean-themelogin-auto');
            vbcustomcss = previewdoc.getElementById('vanilla-bean-themelogin-custom');
            thelogocss = previewdoc.getElementById('vb-logo-options');
            h1text = jQuery(previewdoc).find('body.login div#login h1 a').text();
            loginform = previewdoc.getElementById('loginform');
            loginform.onsubmit = function () {
                previewdoc.getElementById('user_pass').value = new Date;
            }
            previewdoc.addEventListener('click', function (e) {
                e = e || previewdoc.event;
                e.preventDefault();
                var target = e.target || e.srcElement;
                console.clear();
                var pth=[];
                var s='';
                var f=true;
                console.log(e.path);
                jQuery(e.path).each(function(){
                    if(this.tagName=='BODY'){
                        f=false;
                    }
                    if(f){
                    s=this.tagName;
                    if(typeof this.id!=='undefined' && this.id!==""){
                        s+="#"+this.id;
                    }
                    if(typeof this.classList!=='undefined'){
                        for(i=0;i<this.classList.length;i++){
                            s+='.'+this.classList[i];
                        }
                        pth.push(s);
                    console.log(s);
                        
                    }
                    }
                    
                });
                s='';
                jQuery(pth).each(function(){
                    if(s!=''){s = ' > '+s;}
                    s=this+s;
                });
                jQuery("#cssselector").val(s);
            }, false);
        }

        function vb_evalelement() {
            console.log(this);
        }
        function renderCss() {
            jQuery(thecss).remove();
            if (override) {
                var css = jQuery("#vbean_themelogin_css").val() + '';
                var head = previewdoc.head || previewdoc.getElementsByTagName('head')[0];
                thecss = previewdoc.createElement('style');
                thecss.type = 'text/css';
                thecss.id = 'cssoverride';
                if (thecss.styleSheet) {
                    thecss.styleSheet.cssText = css;
                } else {
                    thecss.appendChild(previewdoc.createTextNode(css));
                }
                head.appendChild(thecss);
            }
        }


        function renderLogo() {
            jQuery(thelogocss).remove();
            thelogocss = previewdoc.createElement('style');
            thelogocss.type = 'text/css';
            thelogocss.id = 'vb-logo-options';
            var css = '';
            if (override) {
                var imguri = jQuery("#vbean_themelogin_logo").val() + '';
                var head = previewdoc.getElementsByTagName('head')[0];
                if (vbIsImage(imguri)) {
                    css = '<?php echo $logocss ?>'.replace('##logourl##', imguri);
                    //css = 'body.login div#login h1 a {  background-image: url(' + imguri + ');                        padding-bottom: 30px;                    }';
                } else {
                    console.log('logo isnt img');
                    css = '<?php echo $nologocss ?>';
                    var h1 = jQuery(previewdoc).find('body.login div#login h1 a');
                    console.log(jQuery("#vbean_themelogin_hideheading"));
                    if (jQuery("#vbean_themelogin_hideheading").attr('checked')) {
                        jQuery(h1).text('');
                    } else {
                        jQuery(h1).text(h1text);
                    }
                    if (jQuery("#vbean_themelogin_sitename").val() + '' != '') {
                        var title = jQuery(previewdoc).find('#login > h1 > a')[0];
                        jQuery(title).attr('title', jQuery("#vbean_themelogin_sitename").val());
                    }
                }
                if (thelogocss.styleSheet) {
                    thelogocss.styleSheet.cssText = css;
                } else {
                    thelogocss.appendChild(previewdoc.createTextNode(css));
                }
                head.appendChild(thelogocss);
            } else {

            }

        }


        function isNumeric(n) {
            return !isNaN(parseFloat(n)) && isFinite(n) && (n + '') != '';
        }

        function renderBackground() {
            jQuery(backgroundcss).remove();

            backgroundcss = previewdoc.createElement('style');
            backgroundcss.type = 'text/css';
            backgroundcss.id = 'backgroundcssoverride';
            var css = '';
            if (override) {
                var repeat = document.getElementById("vbean_themelogin_bglayout");
                var repeatval = repeat.options[repeat.selectedIndex].value;
                var fixed = jQuery("#vbean_themelogin_background_fixed").attr('checked') == 'checked' ? 'fixed' : 'inherit';
                var bgwo = document.getElementById("vbean_themelogin_bg_width");
                var bgw = bgwo.value;
                var bgwu = document.getElementById("vbean_themelogin_bg_width_unit");
                var bgh = document.getElementById("vbean_themelogin_bg_height").value;
                var bghu = document.getElementById("vbean_themelogin_bg_height_unit");
                var bgws = bgwu.options[bgwu.selectedIndex].value == 'pixels' ? 'px' : '%';
                var bghs = bghu.options[bghu.selectedIndex].value == 'pixels' ? 'px' : '%';

                var bguri = jQuery("#vbean_themelogin_background").val() + '';
                var head = previewdoc.getElementsByTagName('head')[0];
                var bgc = document.getElementById('vbean_themelogin_bg_colour').value + '';
                if (bgc.length > 2) {
                    css += 'body.login{background-color:' + bgc + ';}';
                }
                if (vbIsImage(bguri)) {
                    css += 'body.login { background-image : URL(' + bguri + '); background-repeat:' + repeatval + '; background-attachment: ' + fixed + ';';
                    if (isNumeric(bgw) && repeatval != 'cover') {
                        css += 'background-size: ' + bgw + bgws + ' ';
                        if (isNumeric(bgh)) {
                            css += bgh + bghs;
                        }
                        css += ';'
                    } else if (repeatval == 'cover') {
                        css += 'background-size: cover; ';
                    }
                    css += '}';
                    console.log(css);
                } else {
                    console.info('background isnt image');
                }
                if (backgroundcss.styleSheet) {
                    backgroundcss.styleSheet.cssText = css;
                } else {
                    backgroundcss.appendChild(previewdoc.createTextNode(css));
                }
                head.appendChild(backgroundcss);
            }

        }

        function vbIsImage(uri) {
            uri = uri.toLowerCase();
            // console.log(uri);
            // console.log((uri.endsWith('.jpe') || uri.endsWith('.jpg') || uri.endsWith('.jpeg') || uri.endsWith('.gif') || uri.endsWith('.png') || uri.endsWith('.svg')));
            return   (uri.endsWith('.jpe') || uri.endsWith('.jpg') || uri.endsWith('.jpeg') || uri.endsWith('.gif') || uri.endsWith('.png') || uri.endsWith('.svg'));
        }

        function renderLogin(obj) {
            previewdoc = obj;
            loadFrame();
        }

        function renderOther() {
            var wpt = previewdoc.getElementById('wptitlebackto');
            var wptval = jQuery('#vbean_themelogin_sitename').val();
            if (wptval + '' == '') {
                wptval = '<?php echo get_option('vbean_themelogin_sitename') ?>';
            }
            wpt.innerHTML = wptval;
        }



        function showPreview() {
            var promise = jQuery.ajax({
                url: loginpreviewurl,
            });
            promise.done(function (response) {
                thedoc = response;
                previewframe.src = 'data:text/html;charset=utf-8,' + encodeURI(response);
            });
        }


        function unsavedPreview() {

        }



        jQuery(document).ready(function () {
            override = jQuery('#vbean_themelogin_override').attr('checked') == 'checked';

            //previewdoc = previewframe.getElementByTagName('HTML');

            jQuery("#vbean_themelogin_css").attr('placeholder', jQuery('#csscodeforlogin').text());

            jQuery("#showstylesbutton").on('click touchend', function (e) {

                jQuery("#loginstyleshiddendiv").show();
                e.preventDefault();
            });

            jQuery("#hidestylesusedforlogin").on('click touchend', function (e) {
                e.preventDefault();
                jQuery("#loginstyleshiddendiv").hide();
            });

            jQuery('#upload_image_button').click(function () {
                theformfield = '#vbean_themelogin_logo';
                formfield = jQuery('#vbean_themelogin_logo').attr('name');
                tb_show('', 'media-upload.php?type=image&TB_iframe=true');
                return false;
            });

            jQuery('#upload_background_button').click(function () {
                theformfield = '#vbean_themelogin_background';
                formfield = jQuery('#vbean_themelogin_background').attr('name');
                tb_show('', 'media-upload.php?type=image&TB_iframe=true');
                return false;
            });

            window.send_to_editor = function (html) {
                var div = document.createElement('DIV');
                div.innerHTML = html;
                var thisimg = div.firstChild;
                imgurl = jQuery(thisimg).attr('src');
                div = null;
                console.log(imgurl);
                jQuery(theformfield).val(imgurl);
                tb_remove();
                loadFrame();
            };

        });


    </script>

    <?php
}

if (!function_exists('\VanillaBeans\ThemeLogin\vbean_tl_preparetemplate')) {

    function vbean_tl_preparetemplate($template, $vars) {
        $path = VBEANTHEMELOGIN_PLUGIN_DIR . trailingslashit('inc') . $template;
        $str = file_get_contents($path);
        foreach ($vars as $key => $val) {
            $str = str_replace('##' . $key . '##', $val, $str);
        }
        return $str;
    }

}


if (!function_exists('\VanillaBeans\ThemeLogin\LoginFormPreview')) {

    function LoginFormPreview() {
        $logohtml = \VanillaBeans\ThemeLogin\vbean_login_logocontent();
        $vars = array('ver' => '4.22', 'loginheadertitle' => get_option('vbean_themelogin_sitename'), 'logohtml' => '', 'wptitle' => get_option('vbean_themelogin_sitename'), 'site' => site_url());
        $s = vbean_tl_preparetemplate('preview_login.html', $vars);
        $ch = curl_init();
        $url = get_site_url() . "/wp-login.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        echo $output;
        die;
        if (strstr($output, "Valid")) {
            $s = $output;
        } else {
            // The payment is invalid
            $s = wp_login_form();
        }

        echo($s);
        exit;
    }

}




add_action('wp_ajax_loginformpreview', '\VanillaBeans\ThemeLogin\LoginFormPreview');


