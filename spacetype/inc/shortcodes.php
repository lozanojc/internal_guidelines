<?php

/*-----------------------------------------------------------------------------------
/*  Shortcodes
/*---------------------------------------------------------------------------------*/

global $shortcodes_array;

/* Shortcode: Btns
 * Usage: [btns align="center"]
 *        [button text="Read more..." url="http://www.superkoderi.cz" size="m"]
 *        [/btns]
 */
function sn_shortcode_btns( $atts, $content = null ) {

    $output = '<p class="buttons">';
    $output .= do_shortcode($content); // execute the '[one_half]' shortcode first to get the title and content
    $output .= '</p>';

    return $output;
}
add_shortcode('btns', 'sn_shortcode_btns');
$shortcodes_array['Buttons'] = '[btns]Button shortcode here[/btns]';

/* Shortcode: Button
 * Usage: [button text="Read more..." url="http://www.superkoderi.cz" size="m" width="200"]
 * Size: s, m, l
 */
function sn_shortcode_button( $atts ) {
    extract(shortcode_atts(array(
        'text' => esc_html__('Read more...', 'sn'),
        'url' => '#',
        'size' => 'm',
        'width' => ''
    ), $atts));

    $class = '';
    $class .= ' btn-'.$size;

    $css_width = '';
    if ( !empty( $width ) ){
        if ( $width == 'full' ){
            $class .= ' btn-block';
        }
        else
        {
            $css_width = ' style="min-width:'.$width.'px" ';
        }
    }

    $html = '<a '.$css_width.'class="btn'.$class.'" href="'.esc_url($url).'" title="'.$text.'"><span>'.do_shortcode($text).'</span></a>';
    return $html;
}
add_shortcode('button', 'sn_shortcode_button');
$shortcodes_array['Button'] = '[button text="Read more..." url="http://www.superkoderi.cz" size="m"]';

/* Shortcode: Grid
 * Usage: [grid align="center" valign="top"]
 *        [col width="1/3"]Content[/col]
 *        [/grid]
 */
function sn_shortcode_grid( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'align' => 'left',
        'valign' => 'top',
    ), $atts));

    $valign = ' grid-' . $valign;
    $align = ' grid-' . $align;
    $grid = 'grid' . $valign . $align;

    $output = '<div class="' . $grid . '">';
    $output .= do_shortcode($content); // execute the '[one_half]' shortcode first to get the title and content
    $output .= '</div>';

    return $output;
}
add_shortcode('grid', 'sn_shortcode_grid');
$shortcodes_array['Grid'] = '<p>[grid align="left" valign="top"]</p><p>Add [col] here</p><p>[/grid]</p>';

/* Shortcode: Grid: Col
 * Usage: [col width="1/3" fixed="false"]Content[/col]
 */
function sn_shortcode_col( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'width' => '1/1',
        'fixed' => 'false',
    ), $atts));

    $width_arr = explode('/', $width);

    $fix = '';
    if ($fixed === 'true')
        $fix = ' col-fixed';

    $output = '<div class="col col-'.$width_arr[0].'-'.$width_arr[1].$fix.'">';
    $output .= do_shortcode($content);
    $output .= '</div>';

    return $output;
}
add_shortcode('col', 'sn_shortcode_col');
$shortcodes_array['Grid column'] = '<p>[col width="1/3" fixed="false/true"]</p><p>Content</p><p>[/col]</p>';

/* Shortcode: Separator
 * Usage: [separator height="2" small="true"]
 */
function sn_shortcode_separator( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'height' => '1',
        'small' => 'false'
    ), $atts));

    $small_class = '';
    if ($small === 'true')
        $small_class = ' separator-small';

    $style = '';
    if ($height > 1)
        $style = ' style="height:'.$height.'px;"';

    $output = '<div class="separator'.$small_class.'"'.$style.'></div>';

    return $output;
}
add_shortcode('separator', 'sn_shortcode_separator');
$shortcodes_array['Separator'] = '[separator height="1" small="false"]';


/* Shortcode: Alert messages
 * Usage: [alert type="notice"]Content[/alert]
 * Types: success, error, notice
 */
function sn_shortcode_alert( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'type' => 'notice',
    ), $atts));

    $output = '<div class="message message-' . esc_attr($type) . '">';
    $output .= do_shortcode($content);
    $output .= '<a href="#" class="close icon icon-close"><span class="vhide">Close</span></a>';
    $output .= '</div>';

    return $output;
}
add_shortcode('alert', 'sn_shortcode_alert');
$shortcodes_array['Message'] = '[alert type="notice/success/error"]Content[/alert]';

/* Shortcode: Testimonial
 * Usage: [testimonial author="John Doe" company="Manager" logo="src to image" avatar="src to image"]Content[/testimonial]
 * Name: author name
 * Company: author company
 * Logo: url of company logo
 * Avatar: url of author image
 */
function sn_shortcode_testimonial( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'name' => '',
        'company' => '',
        'logo' => '',
        'avatar' => '',
        'bg' => '',
        'color' => ''
    ), $atts));

    $style = '';
    $author_style = '';
    $after_style = '';
    if ( !empty( $bg ) || !empty( $color ) ) {

        if ( !empty( $bg ) ) {
            $style .= ' background-color:'.$bg.';';
            $after_style .= ' border-top-color:'.$bg.';';
        }

        if ( !empty( $color ) ) {
            $style .= ' color:'.$color.';';
            $author_style = ' color:'.$color.';';
        }

    }

    $box_class = 'box-testimonial';
    if ( empty( $avatar ) )
        $box_class .= ' no-image';

    $output = '<div class="'.$box_class.'" style="'.$style.'">';
    if ( $logo ) {
        $logo_id = sn_get_attachment_id_from_src( $logo );
        $logo_testimonial = wp_get_attachment_image_src( $logo_id, 'full' );
        // use image testimonial exist
        if ( $logo_testimonial ) {
            $output .= '<p class="img"><img src="'.$logo_testimonial[0].'" width="'.$logo_testimonial[1].'" height="'.$logo_testimonial[2].'" alt="' .esc_attr( $name ). '" /></p>';
        }
        // use image src from parameter
        else {
            $output .= '<p class="img"><img src="'.esc_attr( $logo ).'" alt="' .esc_attr( $name ). '" /></p>';
        }
    }
    $output .= '<p class="text">' . esc_html( $content ) . '</p>';
    $output .= '<p class="author">';
    if ( $name ) {
        $output .= '<strong class="h4" style="'.$author_style.'">' .esc_html( $name ). '</strong>';
    }
    if ( $company ) {
        $output .= '<span class="h6" style="'.$author_style.'">' .esc_html( $company ). '</span>';
    }
    if ( $avatar ) {
        $avatar_id = sn_get_attachment_id_from_src( $avatar );
        $avatar_testimonial = wp_get_attachment_image_src( $avatar_id, 'testimonial' );
        // use image testimonial exist
        if ( $avatar_testimonial ) {
            $output .= '<span class="avatar"><img src="'.$avatar_testimonial[0].'" width="'.$avatar_testimonial[1].'" height="'.$avatar_testimonial[2].'" alt="' .esc_attr( $name ). '" /></span>';
        }
        // use image src from parameter
        else {
            $output .= '<span class="avatar"><img src="'.esc_attr( $avatar ).'" width="85" height="85" alt="' .esc_attr( $name ). '" /></span>';
        }
    }
    $output .= '</p>';
    $output .= '<span class="after" style="'.$after_style.'"></span>';
    $output .= '</div>';

    return $output;
}
add_shortcode('testimonial', 'sn_shortcode_testimonial');
$shortcodes_array['Testimonial'] = '[testimonial name="John Doe" company="Apple" logo="src_to_image" avatar="src_to_image"]Content[/testimonial]';

/* Shortcode: Tabs
 * Usage: [tabs]
 *        [tab title="title 1"]Your content goes here...[/tab]
 *        [tab title="title 2"]Your content goes here...[/tab]
 *        [/tabs]
 */
function sn_shortcode_tabs( $atts, $content = null ) {
    global $tab_array;
    $tab_array = array(); // clear the array

    $tabs_output = '<div class="tabs">';
    $tabs_nav = '<ul class="reset tabs-line">';
    $tabs_content = '<div class="tabs-wrap">';
    do_shortcode($content); // execute the '[tab]' shortcode first to get the title and content

    foreach ($tab_array as $tab => $tab_attr_array) {
        $random_id = rand(1000,2000);
        $active = ( $tab == 0 ) ? ' active' : '';
        $tabs_nav .= '<li><a href="#tab-'.$random_id.'" class="noscroll'.$active.'">'.$tab_attr_array['title'].'</a></li>';
        $tabs_content .= '<div class="tabs-fragment" id="tab-'.$random_id.'">'.$tab_attr_array['content'].'</div>';
    }

    $tabs_nav .= '</ul>';
    $tabs_content .= '</div>';
    $tabs_output .= $tabs_nav . $tabs_content;
    $tabs_output .= '</div>';

    return $tabs_output;
}
add_shortcode('tabs', 'sn_shortcode_tabs');
$shortcodes_array['Tab'] = '<p>[tabs]</p><p>Add [tab] here</p><p>[/tabs]</p>';

/* Shortcode: Tab
 * Usage: [tab title="Tab title"]Your content goes here...[/tab]
 */
function sn_shortcode_tab( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
	), $atts));

	global $tab_array;

	$tab_array[] = array('title' => $title, 'content' => trim(do_shortcode($content)));
	return $tab_array;
}
add_shortcode('tab', 'sn_shortcode_tab');
$shortcodes_array['Tab item'] = '<p>[tab title="Tab title"]</p><p>Your content goes here...</p><p>[/tab]</p>';

/* Shortcode: Toggle
 * Usage: [toggle title="Toggle content" open="true"]Content[/toggle]
 */
function sn_shortcode_toggle( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'title' => '',
        'open' => 'false'
    ), $atts));

    $random_id = rand(1,200);
    $id = 'toggle' . $random_id;

    $open_class = '';
    if ($open === 'true') {
        $open_class = ' open';
        $toggle_text = 'toggle-text';
    } else {
        $toggle_text = 'toggle-text jsHide';
    }

    $output = '<div class="toggle">';
    $output .= '<h3 class="toggle-title'.$open_class.'"><a href="#'.$id.'" class="noscroll"><span class="icon"></span> '.$title.'</a></h3>';
    $output .= '<div class="'.$toggle_text.'" id="'.$id.'">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('toggle', 'sn_shortcode_toggle');
$shortcodes_array['Toggle'] = '<p>[toggle title="Toggle title" open="true"]</p><p>Toggle content</p><p>[/toggle]</p>';

/* Shortcode: Skill
 * Usage: [skill title="Photoshop..." percentage="65" bg1="#E0E0E0" bg2="#CCCCCC" color="#000000"]
 */
function sn_shortcode_skill( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'title' => '',
        'percentage' => '',
        'bg1' => '#E0E0E0',
        'bg2' => '#CCCCCC',
        'color' => '#000000'
    ), $atts));

    $output = '<p class="progress-bar" style="background-color:' . $bg1 . ';">';
    $output .= '<strong class="progress-text h6" style="color:' . $color . ';">' . $title . '</strong>';
    $output .= '<span class="progress-in" style="width:' . $percentage . '%; background-color:' . $bg2 . ';"></span>';
    $output .= '</p>';

    return $output;
}
add_shortcode('skill', 'sn_shortcode_skill');
$shortcodes_array['Progress (skill)'] = '[skill title="Photoshop..." percentage="65" bg1="#000" bg2="#ccc" color="#fff"]';

/* Shortcode: Google map
 * Usage: [map address="Brno" height="100"]
 */
function sn_shortcode_google_map( $atts ) {
    extract(shortcode_atts(array(
        'address' => '',
        'zoom' => 15,
        'styles' => '',
        'height' => 100
    ), $atts));

    $output = '<div style="height:'.$height.'px;" class="box-map" data-map-address="'.$address.'" data-map-zoom="'.$zoom.'" data-map-styles=\''.$styles.'\' >';
    $output .= '<div class="map"></div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('map', 'sn_shortcode_google_map');
$shortcodes_array['Google map'] = '[map address="Brno" zoom="15" height="100"]';

/* Shortcode: Like
 * Usage: [like]
 */
function sn_shortcode_like( $atts, $content = null ) {

    $url = getUrl();

    $output = '<div class="box-likes">';
    $output .= '<div class="item item-fb"><div class="fb-like" data-href="' . $url . '" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div></div>';
    $output .= '<div class="item item-gp"><div class="g-plusone" data-size="medium" data-href="' . $url . '"></div></div>';
    $output .= '<div class="item item-tw"><a href="https://twitter.com/share" class="twitter-share-button" data-url="' . $url . '">Tweet</a></div>';
    $output .= '</div>';

    return $output;

}
add_shortcode('like', 'sn_shortcode_like');
$shortcodes_array['Like'] = '[like]';

/* Shortcode: Youtube video
 * Usage: [youtube id="video id" width="video width" align="left|center|right"]
 */
function sn_shortcode_youtube( $atts ) {
    extract(shortcode_atts(array(
        'id' => '',
        'width' => 'none',
        'align' => 'left'
    ), $atts));

    $style_align = '';
    if ( $align != '' || $align != 'left' ) {
        switch ($align) {
            case 'center':
                $style_align = ' margin-left:auto; margin-right:auto;';
                break;

            case 'right':
                $style_align = ' margin-left:auto;';
                break;
        }
    }

    $output = '<div class="box-video" style="max-width:' . $width . ';' . $style_align . '"><div class="video">';
    $output .= '<iframe width="560" height="315" src="//www.youtube.com/embed/' . $id . '" frameborder="0" allowfullscreen></iframe>';
    $output .= '</div></div>';

    return $output;
}
add_shortcode('youtube', 'sn_shortcode_youtube');
$shortcodes_array['YouTube video'] = '[youtube id="video id" width="video width" align="left|center|right"]';

/* Shortcode: Vimeo video
 * Usage: [vimeo id="video id" width="video width"]
 */
function sn_shortcode_vimeo( $atts ) {
    extract(shortcode_atts(array(
        'id' => '',
        'width' => 'none',
        'align' => 'left'
    ), $atts));

    $style_align = '';
    if ( $align != '' || $align != 'left' ) {
        switch ($align) {
            case 'center':
                $style_align = ' margin-left:auto; margin-right:auto;';
                break;

            case 'right':
                $style_align = ' margin-left:auto;';
                break;
        }
    }

    $output = '<div class="box-video" style="max-width:' . $width . ';' . $style_align . '"><div class="video">';
    $output .= '<iframe src="//player.vimeo.com/video/' . $id . '" width="560" height="315" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
    $output .= '</div></div>';

    return $output;
}
add_shortcode('vimeo', 'sn_shortcode_vimeo');
$shortcodes_array['Vimeo video'] = '[vimeo id="video id" width="video width" align="left|center|right"]';


/* Shortcode: Form
 * Usage: [form id="video id" width="video width"]
 */
function sn_shortcode_contact( $atts ) {

    global $response;

    //user posted variables
    if ( isset( $_POST['submitted'] ) ) {
        $name = $_POST['sn_name'];
        $email = $_POST['sn_email'];
        $message = $_POST['sn_message'];
        $human = $_POST['sn_title'];
    }

    //php mailer variables
    $to = of_get_option('sn_contact_email');
    if (!isset($to) || ($to == '') ){
        $to = get_option('admin_email');
    }


    if (isset( $_POST['submitted'] ) ) {

        //response messages
        $not_human       = of_get_option('sn_contact_message_verification');
        $missing_content = of_get_option('sn_contact_message_content');
        $email_invalid   = of_get_option('sn_contact_message_email');
        $message_unsent  = of_get_option('sn_contact_message_notsent');
        $message_sent    = of_get_option('sn_contact_message_sent');

        $message_body = of_get_option('sn_contact_email_body');
        // replace variables
        if ( !empty( $message_body ) ) {
            $message_body = str_replace('{name}', $name, $message_body);
            $message_body = str_replace('{email}', $email, $message_body);
            $message_body = str_replace('{message}', $message, $message_body);
            $message_body = str_replace('{site_name}', get_bloginfo('name'), $message_body);
        }

        // EMAIL LOGO
        $email_logo_url = of_get_option('sn_contact_email_logo');
        $email_logo = '';
        if ( $email_logo_url ) {
            $img_id = sn_get_attachment_id_from_src( $email_logo_url );
            $img_logo = wp_get_attachment_image_src( $img_id, 'full' );
            // use image testimonial exist
            if ( $img_logo ) {
                $email_logo = '<img src="'.$img_logo[0].'" width="'.$img_logo[1].'" height="'.$img_logo[2].'" alt="' .get_bloginfo( 'name' ). '" />';
            }
            // use image src from parameter
            else {
                $email_logo = '<img src="'.esc_attr( $email_logo_url ).'" alt="' .get_bloginfo( 'name' ). '" />';
            }
        }

        $message_content = '
        <!DOCTYPE html>
        <html lang="cs">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta name="Copyright" content="" />
                <meta name="Author" content="The Seniores, www.theseniores.com" />
                <meta name="Keywords" content="" />
                <meta name="Description" content="" />
                <title>Spacetype email</title>
            </head>
            <body style="padding:0; margin:0">
                <div style="margin:0; padding:25px 0; font-size:16px; font-family: Arial, sans-serif; color:#333333; line-height:24px; width:100%; text-align:center; background:#ededed;">
                    <table cellspacing="0" cellpadding="0" border="0" style="text-align:left; margin:0 auto; width:480px; border:1px solid #ddd; padding:0; font-size:12px; background:#fff;">
                        <tbody>
                            <tr>
                                <td style="margin:0; padding:15px 0;">
                                    <table cellspacing="0" cellpadding="0" border="0" style="width:100%; font-size:16px; font-family: Arial, sans-serif; padding:0; margin:0; line-height:24px;">
                                        <tbody>
                                            <tr>
                                                <td style="margin:0; padding:20px 0 20px; vertical-align:middle;text-align:center;">
                                                   '.$email_logo.'
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table cellspacing="0" cellpadding="0" border="0" style="width:100%; font-size:16px; font-family: Arial, sans-serif; line-height:24px; padding:0 0 0 0; margin:0; color:#333333;">
                                        <tbody>
                                            <tr>
                                                <td style="margin:0; padding:15px 30px 0; vertical-align:top;">
                                                   '.apply_filters('the_content', $message_body).'
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </body>
        </html>
        ';

        $subject = sprintf( __('%1$s sent a message from %2$s website', 'sn'), $name, get_bloginfo('name') );
        $headers = 'MIME-Version: 1.0' . "\r\n";
        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'Content-type: text/html' . "\r\n";
        $headers .= 'From: '. $name . ' <' . $to . '>' . "\r\n" . 'Reply-To: ' . $email;

        if( !empty( $human) ) {
            sn_generate_response("error", $not_human); //not human!
        } else {

            //validate presence of name, email and message
            if( empty($name) || empty($email) || empty($message) ) {
                sn_generate_response("error", $missing_content);
            } else {

                //validate email
                if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
                    sn_generate_response("error", $email_invalid);
                } else {

                    //ready to go!
                    $sent = wp_mail($to, $subject, $message_content, $headers);
                    if( $sent ) {
                        sn_generate_response("success", $message_sent); //message sent!
                    } else {
                        sn_generate_response("error", $message_unsent); //message wasn't sent
                    }

                }
            }

        }

    }

    $form_name = (isset($_POST['sn_name'])) ? esc_attr($_POST['sn_name']) : '';
    $form_email = (isset($_POST['sn_email'])) ? esc_attr($_POST['sn_email']) : '';
    $form_message = (isset($_POST['sn_message'])) ? esc_attr($_POST['sn_message']) : '';
    $actual_url = getUrl();

    // form labels
    $label_name    = of_get_option('sn_contact_info_name');
    $label_email   = of_get_option('sn_contact_info_email');
    $label_message = of_get_option('sn_contact_info_message');
    $label_button  = of_get_option('sn_contact_info_button');

    $output = '
        <div id="form-contact">
            '.$response.'
            <form action="'.$actual_url.'#form-contact" method="post">
                <div class="grid">
                    <p class="col col-1-2">
                        <label for="sn_name" class="h6">'.$label_name.'</label>
                        <span class="inp-fix">
                            <input type="text" class="inp-text" id="sn_name" name="sn_name" value="'.$form_name.'" />
                        </span>
                    </p>
                    <p class="col col-1-2">
                        <label for="sn_email" class="h6">'.$label_email.'</label>
                        <span class="inp-fix">
                            <input type="text" class="inp-text" id="sn_email" name="sn_email" value="'.$form_email.'" />
                        </span>
                    </p>
                    <p class="col col-1-1">
                        <label for="sn_message" class="h6">'.$label_message.'</label>
                        <span class="inp-fix">
                            <textarea name="sn_message" id="sn_message" cols="30" rows="5" class="inp-text">'.$form_message.'</textarea>
                        </span>
                    </p>
                </div>
                <p style="display:none;">
                    <input type="hidden" name="submitted" value="1" />
                    <label for="sn_title" class="h6">'.__( 'Leave this field empty', 'sn' ).'</label>
                    <span class="inp-fix">
                        <input type="text" class="inp-text" id="sn_title" name="sn_title" />
                    </span>
                </p>
                <p class="reset">
                    <button class="btn btn-s" type="submit"><span>'.$label_button.'</span></button>
                </p>
            </form>
        </div>
    ';

    return $output;
}
add_shortcode('form', 'sn_shortcode_contact');
$shortcodes_array['Contact form'] = '[form]';

/* Shortcode: Portfolio
 * Usage: [portfolio count="4" ids="1,2,..."]
 */
function sn_shortcode_portfolio( $atts ) {
    extract(shortcode_atts(array(
        'count' => '4',
        'ids' => ''
    ), $atts));

    if ( empty( $ids ) ) {

        $args = array(
            'post_type' => 'sn_portfolio',
            'posts_per_page' => $count
        );

    } else {

        $ids_a = explode(',', $ids);

        $args = array(
            'post_type' => 'sn_portfolio',
            'orderby' => 'post__in',
            'posts_per_page' => $count,
            'post__in' => $ids_a
        );

    }

    $portfolio_query = new WP_Query($args);

    ob_start();

    echo '<div class="grid crossroad-portfolio">';

    while( $portfolio_query->have_posts() ) : $portfolio_query->the_post();

        get_template_part( 'inc/portfolio', 'item' );

    endwhile;
    wp_reset_postdata();

    echo '</div>';

    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}
add_shortcode('portfolio', 'sn_shortcode_portfolio');
$shortcodes_array['Portfolio'] = '[portfolio count="4" ids="1,2,..."]';

/* Shortcode: Tweet
 * Usage: [tweet username="envato" wrap="ul" wrapitem="li" count="1" replies="false" hyperlinks="true" users="true" update="true"]
 */
function sn_shortcode_tweet( $atts ) {
    extract(shortcode_atts(array(
        'username' => 'envato',
        'wrap' => 'ul',
        'wrapitem' => 'li',
        'count' => 1,
        'hidereplies' => false,
        'hyperlinks' => 'true',
        'users' => 'true',
        'update' => 'true'
    ), $atts));

    if ($hidereplies === 'true') {
        $hidereplies = true;
    }

    require_once FRAMEWORK_DIRECTORY . 'twitteroauth/twitteroauth.php';
    $twitterConnection = new TwitterOAuth(
        'tc2iNQtyrZzxTmSmEDsmCQ', // Consumer Key
        'Yyz2DXrHX9Iu1fpnjHOvzPFOZGduGoybodEoDm0jQ', // Consumer secret
        '104864700-ICb7swORTkLJEWbjT3kssrWlfGK3gtg4wnqPKj7c', // Access token
        'pc870Aw5jGBcyIBSpHmGjEO90BuqpVTgPsLaCE1QpqVuM' // Access token secret
    );

    $twitterData = $twitterConnection->get(
        'statuses/user_timeline',
        array(
            'screen_name'     => $username,
            'count'           => $count,
            'exclude_replies' => $hidereplies
        )
    );

    /* Display Latest Tweets */
    if(!empty($twitterData) || !isset($twitterData['error'])){

        $i = 0;
        $encode_utf8 = false;
        $twitter_users = $users;

        ob_start();

        echo '<'.$wrap.' class="box-twitter">';

        foreach($twitterData as $item) {
            $msg = $item->text;
            $permalink = 'http://twitter.com/#!/'. $username .'/status/'. $item->id_str;
            if($encode_utf8) {
                $msg = utf8_encode($msg);
            }
            $link = $permalink;

            echo '<'.$wrapitem.' class="twitter-item">';

            if ($hyperlinks === 'true') {
                $msg = hyperlinks($msg);
            }
            if ($twitter_users === 'true') {
                $msg = twitter_users($msg);
            }

            echo $msg;

            if($update === 'true') {

                $time = strtotime($item->created_at);

                if ( ( abs( time() - $time) ) < 86400 )
                    $h_time = sprintf( __('%s ago', 'sn'), human_time_diff( $time ) );
                else
                    $h_time = date(__('Y/m/d', 'sn'), $time);

                echo sprintf( __('%s', 'sn'),' <span class="twitter-timestamp"><abbr title="' . date(__('Y/m/d H:i:s', 'sn'), $time) . '">' . $h_time . '</abbr></span>' );
            }

            echo '</'.$wrapitem.'>';

            $i++;
            if ( $i >= $count ) break;
        }

        echo '</'.$wrap.'>';

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

}
add_shortcode('tweet', 'sn_shortcode_tweet');
$shortcodes_array['Tweet'] = '[tweet username="envato" wrap="ul" wrapitem="li" count="1" hidereplies="false" hyperlinks="true" users="true" update="true"]';

/* Shortcode: Social
 * Usage: [social icon="twitter" url="http://www.twitter.com" title="Twitter"]
 */
function sn_shortcode_social( $atts ) {
    extract(shortcode_atts(array(
        'icon' => '',
        'url' => '',
        'title' => ''
    ), $atts));

    $output = '<a href="'.esc_url($url).'" target="_blank" title="'.$title.'" class="social-icon"><span class="icon icon-social-'.$icon.'"></span><span class="vhide">'.$title.'</span></a>';

    return $output;
}
add_shortcode('social', 'sn_shortcode_social');
$shortcodes_array['Social icon'] = '[social icon="twitter" url="http://www.twitter.com" title="Twitter"]';