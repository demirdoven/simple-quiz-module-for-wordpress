<?php 
$quiz_id = $_GET['quiz_id'];
global $wpdb;
$table_name = $wpdb->prefix . 'doq_quiz';
$the_quiz = $wpdb->get_row('SELECT * FROM ' . $table_name . ' WHERE ID = ' . $quiz_id);
if (empty($the_quiz)) {
    echo '</br><b>Hata: Böyle bir sınav bulunamadı. Lütfen geri dönüp tekrar deneyin.</b>';
    return false;
} ?>  
<style> 
.quiz_wrapper input[type=checkbox]:checked:before { 
    margin: -6px 0 0 0px; font: 400 29px/1 dashicons; 
} 
</style> 
<div class="quiz_intro"> 
    <input type="text" readonly class="shortcode" value="[sinav id=<?php echo $the_quiz->ID; ?>]"/> 
    <div> 
        <span class="header_title">SINAV DÜZENLE</span> 
        <img class="quiz_icon" src="<?php echo DOQ_PLUGIN_URL . '/assets/img/icon.jpg'; ?>"/> 
    </div> 
</div> 
<?php 
$doq_editor_settings = array(
    'media_buttons' => true,
    'teeny' => true,
    'dfw' => true,
    'quicktags' => true,
    'drag_drop_upload' => true,
    'wpautop' => false,
    'textarea_rows' => 8
);
if (isset($_POST['editt_quiz'])) {
    global $wpdb;
    $quiz_name = $_POST['quiz_name'];
    $welcome_desc = stripslashes(wp_kses_post($_POST['welcome_desc']));
    $time_limit_check = (isset($_POST['time_limit_check'])) ? 1 : 0;
    $time = '';
    if (isset($_POST['min'])) {
        $time = (int)$_POST['min'] * 60 + (int)$time;
    }
    $time_limit = $time;
    $table_name = $wpdb->prefix . 'doq_quiz';
    $wpdb->update($table_name, array(
        'name' => $quiz_name,
        'welcome_desc' => $welcome_desc,
        'time_limit_check' => $time_limit_check,
        'time_limit' => $time_limit,
    ) , array(
        'ID' => $quiz_id
    ) , array(
        '%s'
    ));
    wp_redirect('admin.php?page=devorion-quiz%2Fquizzes.php&action=edit_quiz&quiz_id=' . $quiz_id);
    die;
} ?> 
<div class="quiz_wrapper"> 
    <form action="" name="editt_quiz" id="" method="post"> 
        <fieldset> 
            <legend>Sınav Adı</legend> 
            <div class="option_row"> 
                <label class="sm_label">Sınav adı:</label> 
                <input type="text" name="quiz_name" class="" id="" value="<?php echo $the_quiz->name; ?>" /> 
            </div> 
        </fieldset> 
        <fieldset> 
            <legend>Başlangıç Ekranı</legend> 
            <div class="option_row"> 
                <label class="sm_label">Açıklama:</label> 
                <?php wp_editor(wp_kses_post($the_quiz->welcome_desc) , 'welcome_desc', $doq_editor_settings); ?> 
            </div> 
        </fieldset> 
        <fieldset class="time_limit"> 
            <legend>Süre Limiti</legend> 
            <div class="option_row"> 
                <label class="lg_label">Süre limiti aktif</label> 
                <input type="checkbox" name="time_limit_check" class="" id="" value="" <?php checked($the_quiz->time_limit_check, 1) ?>/> 
            </div> 
            <?php 
            $stored_time_limit = (int)$the_quiz->time_limit;
            $stored_time_limit = gmdate("H:i:s", $stored_time_limit);
            $time_limit_array = explode(":", $stored_time_limit); 
            ?> 
            <div class="option_row"> 
                <label class="lg_label">Limit</label> 
                <input type="number" name="min" class="sm_input" min="0" max="59" id="" value="<?php echo (int)$time_limit_array[1]; ?>" style="vertical-align: middle;" /> 
                <span style="margin-right: 15px;vertical-align: middle;">dakika</span> 
            </div> 
        </fieldset> 
        <input class="save_quiz" type="submit" name="editt_quiz" value="SINAVI KAYDET"/> 
    </form> 
</div> 
<div class="orion_sidebar"> 
    <img style="border-radius: 1em;" src="<?php echo DOQ_PLUGIN_URL . '/assets/img/orion_sidebar.png'; ?>"/> 
</div> 
<script> 
jQuery(function ($){ 
    $('.final_result_desc .option_row').eq(0).find('option').each(function(i){
        var val = $(this).val();
        if( val != 0 ){
            $(this).attr('disabled','disabled');
        }
    } 
}); 
</script>
