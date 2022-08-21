<?php
/*
Plugin Name: DevOrion Quiz Eklentisi
Plugin URI: http://github.com/demirdoven
Description: DevOrion Quiz Eklentisi
Author: Selman Demirdoven
Version: 1.0.0
Author URI: https://github.com/demirdoven
Text Domain: devorion-quiz
Licence: GLPv2
*/
ob_start();
if (!defined('ABSPATH')){
    exit;
} 
if (!defined('DOQ_PLUGIN_DIR')){
    define('DOQ_PLUGIN_DIR', plugin_dir_path(__FILE__));
}
if (!defined('DOQ_PLUGIN_URL')){
    define('DOQ_PLUGIN_URL', plugin_dir_url(__FILE__));
}

function mps_activation_setup(){
    global $wpdb;
    $table_name_1 = $wpdb->prefix . 'doq_quiz';
    $table_name_2 = $wpdb->prefix . 'doq_question';
    $table_name_3 = $wpdb->prefix . 'doq_answer';
    $table_name_4 = $wpdb->prefix . 'doq_rating';
    $table_name_5 = $wpdb->prefix . 'doq_katilanlar';
    $charset_collate = $wpdb->get_charset_collate();
    $sql_1 = "CREATE TABLE IF NOT EXISTS $table_name_1 ( ID int(11) NOT NULL AUTO_INCREMENT, name varchar(200) NOT NULL, hide_name enum('0', '1') DEFAULT '0' NOT NULL, welcome_desc longtext NOT NULL, hide_welcome_desc enum('0', '1') DEFAULT '1' NOT NULL, final_desc longtext NOT NULL, hide_final_desc enum('0', '1') DEFAULT '1' NOT NULL, show_score enum('0', '1') DEFAULT '0' NOT NULL, show_question_analyze enum('0', '1') DEFAULT '0' NOT NULL, random_questions enum('0', '1') DEFAULT '0' NOT NULL, random_answers enum('0', '1') DEFAULT '0' NOT NULL, answer_mode enum('0', '1') DEFAULT '1' NOT NULL, time_limit mediumint(8)	NOT NULL, time_limit_check enum('0', '1') DEFAULT '0' NOT NULL, creation_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL, PRIMARY KEY  (ID) ) $charset_collate;";
    $sql_2 = "CREATE TABLE IF NOT EXISTS $table_name_2 ( ID int(11) NOT NULL AUTO_INCREMENT, quiz_id int(11) NOT NULL, question_text longtext NOT NULL, question_point int(11) NOT NULL, question_type enum('0', '1', '2', '3') DEFAULT '0' NOT NULL, correct_answer_type enum('0', '1') DEFAULT '0' NOT NULL, PRIMARY KEY  (ID) ) $charset_collate;";
    $sql_3 = "CREATE TABLE IF NOT EXISTS $table_name_3 ( ID int(11) NOT NULL AUTO_INCREMENT, question_id int(11) NOT NULL, answer_key longtext NOT NULL, cvp_aciklama longtext NOT NULL, answer_value int(11) NOT NULL, correct varchar(100) NOT NULL, sorting_order int(11) NOT NULL, PRIMARY KEY  (ID) ) $charset_collate;";
    $sql_4 = "CREATE TABLE IF NOT EXISTS $table_name_4 ( ID int(11) NOT NULL AUTO_INCREMENT, quiz_id int(11) NOT NULL, rating_text varchar(200) NOT NULL, min_point int(3) NOT NULL, PRIMARY KEY  (ID) ) $charset_collate;";
    $sql_5 = "CREATE TABLE IF NOT EXISTS $table_name_5 ( ID int(11) NOT NULL AUTO_INCREMENT, quiz_id int(11) NOT NULL, isim varchar(200) NOT NULL, ig varchar(200) NOT NULL, puan int(11) NOT NULL, PRIMARY KEY  (ID) ) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_1);
    dbDelta($sql_2);
    dbDelta($sql_3);
    dbDelta($sql_4);
    dbDelta($sql_5);
}
register_activation_hook(__FILE__, 'mps_activation_setup');

function doq_admin_scripts(){
    wp_register_style('custom_wp_admin_css2', DOQ_PLUGIN_URL . 'admin/css/admin.css', '1.0.0', true);
    wp_enqueue_style('custom_wp_admin_css2');
    wp_enqueue_script('jquery-ui-js', DOQ_PLUGIN_URL . 'assets/js/jquery-ui.min.js', array(
        'jquery'
    ) , '1.0.0', 'all');
    wp_enqueue_script('jquery-ui-touch-punch', DOQ_PLUGIN_URL . 'assets/js/jquery.ui.touch-punch.min.js', array(
        'jquery'
    ) , '1.0.0', 'all');
    wp_enqueue_script('custom_admin', DOQ_PLUGIN_URL . 'admin/js/custom.js', array(
        'jquery'
    ) , '1.0.0', true);
    wp_enqueue_script('uploader', DOQ_PLUGIN_URL . 'admin/js/uploader.js', array(
        'jquery'
    ) , '1.0.0', true);
    wp_enqueue_style('jquery-ui-css', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css', '1.0.0', true);
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'doq_admin_scripts');

function doq_frontend_scripts(){
    wp_register_style('custom_frontend_css', DOQ_PLUGIN_URL . 'assets/css/custom.css', '1.0.0', true);
    wp_enqueue_style('custom_frontend_css');
    wp_enqueue_script('jquery-ui-js', DOQ_PLUGIN_URL . 'assets/js/jquery-ui.min.js', array(
        'jquery'
    ) , '1.0.0', 'all');
    wp_enqueue_script('jquery-ui-touch-punch-front', DOQ_PLUGIN_URL . 'assets/js/jquery.ui.touch-punch.min.js', array(
        'jquery'
    ) , '1.0.0', 'all');
    wp_enqueue_script('custom_frontend_js', DOQ_PLUGIN_URL . 'assets/js/custom.js', array(
        'jquery'
    ) , '1.0.0', true);
    wp_enqueue_style('jquery-ui-css', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css', '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'doq_frontend_scripts');

function doq_shortcode($atts, $content = null){
    ob_start();
    extract(shortcode_atts(array(
        "id" => ''
    ) , $atts));
    $quiz_id = $id;
    include DOQ_PLUGIN_DIR . 'template/template1.php';
    return ob_get_clean();
}
add_shortcode("sinav", "doq_shortcode");

function quizler_links(){
    global $wp_version, $_registered_pages;
    add_menu_page('Quizler', 'Quizler', 'edit_pages', 'quizler', 'doq_plugin_quizzez_cb', plugins_url('devorion-quiz/assets/img/doq_menu_icon.png'));
    add_submenu_page('quizler', 'Katılımcılar', 'Katılımcılar', 'edit_pages', 'katilimcilar', 'katilimcilar_cb');
    $code_pages = array(
        'quizzes.php.php',
        'edit_quiz.php'
    );
    foreach ($code_pages as $code_page){
        $hookname = get_plugin_page_hookname("devorion-quiz/$code_page", '');
        $_registered_pages[$hookname] = true;
    }
}
add_action('admin_menu', 'quizler_links');

function doq_plugin_quizzez_cb(){
    include DOQ_PLUGIN_DIR . '/quizzes.php';
}

function katilimcilar_cb(){
    include DOQ_PLUGIN_DIR . '/includes/katilimcilar.php';
}

function doq_description_filter($content){
    $content = str_replace('%%baslik%%', '<span class="doq_filter_quiz_name"></span>', $content);
    $content = str_replace('%%ssayisi%%', '<span class="doq_filter_count_all_questions"></span>', $content);
    $content = str_replace('%%dsayisi%%', '<span class="doq_filter_count_corrects"></span>', $content);
    $content = str_replace('%%ysayisi%%', '<span class="doq_filter_count_wrongs"></span>', $content);
    $content = str_replace('%%tsure%%', '<span class="doq_filter_total_time_limit"></span>', $content);
    $content = str_replace('%%ksure%%', '<span class="doq_filter_user_time"></span>', $content);
    $content = str_replace('%%rating%%', '<span class="doq_filter_rating"></span>', $content);
    return $content;
}
function sinav_siralama_kaydet_ve_goster(){
    $isim = @$_REQUEST['isim'];
    $ig = @$_REQUEST['ig'];
    $quiz_id = @$_REQUEST['quiz_id'];
    $puan = @$_REQUEST['puan']; ?> <style> a.hepsini_goster { display: block!important; text-align: center; background: #dedede; color: #333; text-decoration: none!important; } a.hepsini_goster:hover { background: #b1b1b1; text-decoration: none!important; } .satirr { display: none; } .acik { display: table-row;; } </style> <?php global $wpdb;
    $table_name = $wpdb->prefix . 'doq_katilanlar';
    $ok = $wpdb->insert($table_name, array(
        'quiz_id' => $quiz_id,
        'isim' => $isim,
        'ig' => $ig,
        'puan' => $puan,
    )); ?> <h2 style="text-align: center; color: #fff; font-weight: bold;margin: 0 0 15px;">KATILANLAR</h2> <?php $katilanlar = $wpdb->get_results('SELECT * FROM ' . $table_name . ' WHERE quiz_id=' . $quiz_id . ' ORDER BY puan desc', ARRAY_A);
    if (!empty($katilanlar)){ 
        ?> 
        <table> 
            <thead> 
                <th>Sıra</th> 
                <th>İsim</th> 
                <th>Instagram</th> 
                <th>Puan</th> 
            </thead> 
            <tbody> 
                <?php 
                for ($i = 0; $i < count($katilanlar); $i++){ 
                    ?> 
                    <tr class="satirr <?php if ($i < 5){ echo esc_attr('acik'); } ?>"> 	
                        <td><?php echo $i + 1; ?></td> 	
                        <td><?php echo $katilanlar[$i]['isim']; ?></td> 	
                        <td><?php echo $katilanlar[$i]['ig']; ?></td> 	
                        <td><?php echo $katilanlar[$i]['puan']; ?></td> 
                    </tr> 
                    <?php
                } 
                ?> 
            </tbody> 
        </table>
        <a href="" class="hepsini_goster" style="display: inline-block; margin-top: 10px; ">Tamamını Göster</a> 
        <script> 
        jQuery(function ($){ 
            $('.hepsini_goster').on('click', function(){ 
                $('.satirr:not(.acik)').addClass('acik'); 
                $(this).remove(); 
                return false; 
            }); 
        }); 
        </script> 
        <?php
    }
    wp_die();
}
add_action('wp_ajax_sinav_siralama_kaydet_ve_goster', "sinav_siralama_kaydet_ve_goster");
add_action('wp_ajax_nopriv_sinav_siralama_kaydet_ve_goster', "sinav_siralama_kaydet_ve_goster");

function katilanlari_cek(){
    $sid = @$_REQUEST['sid'];
    global $wpdb;
    $katilanlar = $wpdb->get_results('SELECT * FROM wp_doq_katilanlar WHERE quiz_id=' . $sid . ' ORDER BY puan desc', ARRAY_A);
    if (!empty($katilanlar)){ 
        ?> 
        <table> 
            <thead> 
                <th>Sıra</th> 
                <th>İsim</th> 
                <th>Instagram</th> 
                <th>Puan</th> 
            </thead> 
            <tbody> 
                <?php for ($i = 0;$i < count($katilanlar);$i++){ ?> 
                    <tr class="satirr <?php if ($i < 5){ echo esc_attr('acik'); } ?>"> 
                        <td><?php echo $i + 1; ?></td> 
                        <td><?php echo $katilanlar[$i]['isim']; ?></td> 
                        <td><?php echo $katilanlar[$i]['ig']; ?></td> 
                        <td><?php echo $katilanlar[$i]['puan']; ?></td> 
                    </tr> 
                <?php } ?> 
            </tbody> 
        </table> 
        <a href="" class="hepsini_goster" style="display: inline-block; margin-top: 10px; ">Tamamını Göster</a> 
        <script> 
        jQuery(function ($){ 
            $('.hepsini_goster').on('click', function(){ 
                $('.satirr:not(.acik)').addClass('acik'); 
                $(this).remove(); 
                return false; 
            }); 
        }); 
        </script> 
        <?php
    }
    wp_die();
}
add_action('wp_ajax_katilanlari_cek', "katilanlari_cek");
add_action('wp_ajax_nopriv_katilanlari_cek', "katilanlari_cek");
?>
