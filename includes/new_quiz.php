<div class="quiz_intro add_new"> 
    <div> 
        <span class="header_title">YENİ SINAV OLUŞTUR</span> 
        <img class="quiz_icon" src="<?php echo DOQ_PLUGIN_URL . '/assets/img/icon.jpg'; ?>"/> 
    </div> 
</div>   
<?php  
$doq_editor_settings = array(
    'media_buttons' => true,
    'textarea_rows' => 6,
    'teeny' => true,
);
if (isset($_POST['create_quiz'])) {
    global $wpdb;
    $quiz_name = $_POST['quiz_name'];
    $welcome_desc = $_POST['welcome_desc'];
    $time_limit_check = (isset($_POST['time_limit_check'])) ? 1 : 0;
    $time;
    if (isset($_POST['min'])) {
        $time = (int)$_POST['min'] * 60 + $time;
    }
    $time_limit = $time;
    $table_name = $wpdb->prefix . 'doq_quiz';
    $wpdb->insert($table_name, array(
        'name' => $quiz_name,
        'welcome_desc' => $welcome_desc,
        'time_limit_check' => $time_limit_check,
        'time_limit' => $time_limit,
    ));
    $added_id = $wpdb->insert_id;
    wp_redirect('admin.php?page=devorion-quiz%2Fquizzes.php&action=edit_quiz&quiz_id=' . $added_id);
    die;
}
?> 
<style> 
    .quiz_wrapper input[type=checkbox]:checked:before { 
        margin: -6px 0 0 0px; font: 400 29px/1 dashicons; 
    } 
</style> 

<div class="quiz_wrapper">  
    <form action="" name="create_quiz" id="" method="post"> 
        <fieldset> 
            <legend>Sınav Adı</legend> 
            <div class="option_row"> 
                <label class="sm_label">Sınav adı:</label> 
                <input type="text" name="quiz_name" class="" id="" value="" /> 
            </div> 
        </fieldset>  
        <fieldset> 
            <legend>Başlangıç Ekranı</legend> 
            <div class="option_row"> 
                <label class="sm_label">Açıklama:</label> 
                <?php wp_editor('', 'welcome_desc', $doq_editor_settings); ?> 
            </div> 
        </fieldset>  
        <fieldset class="time_limit"> 
            <legend>Süre Limiti</legend>  
            <div class="option_row"> 
                <label class="lg_label">Süre limiti aktif</label> 
                <input type="checkbox" name="time_limit_check" class="" id="" value=""/> 
            </div>  
            <div class="option_row"> 
                <label class="lg_label">Limit</label>  
                <input type="number" name="min" class="sm_input" min="0" max="59" id="" value="" style="vertical-align: middle;" /> 
                <span style="margin-right: 15px;vertical-align: middle;">dakika</span>  
            </div>  
        </fieldset>  
        <input class="save_quiz" type="submit" name="create_quiz" value="SINAVI KAYDET"/>  
    </form> 
    </div> 
    <div class="orion_sidebar"> 
        <img style="border-radius: 1em;" src="<?php echo DOQ_PLUGIN_URL . '/assets/img/orion_sidebar.png'; ?>"/> 
    </div>