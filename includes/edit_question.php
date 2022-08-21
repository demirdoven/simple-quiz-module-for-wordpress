<style>
    .doq_hidden {
        display: none;
    }
    div#selecting_type_check_correct_answer_type {
        margin: .5em 0 1.5em 0;
    } 
</style>
<?php 
$quiz_id = $_GET['quiz_id'];
$question_id = $_GET['question_id'];
global $wpdb;
$table_name = $wpdb->prefix . 'doq_question';
$the_question = $wpdb->get_row('SELECT * FROM ' . $table_name . ' WHERE ID = ' . $question_id);
if (empty($the_question)) {
    echo '</br><b>Hata: Böyle bir soru bulunamadı. Lütfen geri dönüp tekrar deneyin.</b>';
    return false;
} ?> 
<div class="quiz_intro">
    <div> 
        <span class="header_title">SORUYU DÜZENLE</span> 
        <img class="quiz_icon" src="<?php echo DOQ_PLUGIN_URL . '/assets/img/icon.jpg'; ?>" /> 
    </div>
</div> 
<?php 
if (isset($_POST['edit_questionn'])) {
    global $wpdb;
    $question_text = $_POST['question_text'];
    $table_name = $wpdb->prefix . 'doq_question';
    $wpdb->update($table_name, array(
        'question_text' => $question_text,
    ) , array(
        'ID' => $question_id
    ) , array(
        '%s'
    ));
    $answers_table_name = $wpdb->prefix . 'doq_answer';
    $wpdb->delete($answers_table_name, array(
        'question_id' => $question_id
    ));
    if (isset($_POST['cevaplar'])) {
        for ($i = 0;$i < count($_POST['cevaplar']['cevap_metni']);$i++) {
            $cevap_metni = $_POST['cevaplar']['cevap_metni'][$i];
            $cvp_aciklama = $_POST['cevaplar']['cvp_aciklama'][$i];
            if ('' != $_POST['cevaplar']['cevap_metni'][$i]) {
                if ($_POST['cevaplar']['dogru'][0] == ($i + 1)) {
                    $wpdb->insert($answers_table_name, array(
                        'question_id' => $question_id,
                        'answer_key' => $cevap_metni,
                        'cvp_aciklama' => $cvp_aciklama,
                        'correct' => 1,
                    ));
                }
                else {
                    $wpdb->insert($answers_table_name, array(
                        'question_id' => $question_id,
                        'answer_key' => $cevap_metni,
                        'cvp_aciklama' => $cvp_aciklama,
                        'correct' => 0,
                    ));
                }
            }
        }
    }
    wp_redirect('admin.php?page=devorion-quiz%2Fquizzes.php&action=edit_question&quiz_id=' . $quiz_id . '&question_id=' . $question_id);
    die;
}
?> 
<div class="quiz_wrapper">
    <form action="" name="edit_questionn" id="" method="post"> 
        <?php 
        global $wpdb;
        $answers_table_name = $wpdb->prefix . 'doq_answer';
        $answers = $wpdb->get_results('SELECT * FROM ' . $answers_table_name . ' WHERE question_id=' . $question_id . ' ORDER BY ID', ARRAY_A); ?> 
        <fieldset class="question_text">
            <legend>Soru</legend>
            <div class="option_row"> 
                <label class="sm_label">Soru Metni:</label> 
                <?php 
                $settings = array(
                    'media_buttons' => true,
                    'textarea_rows' => 6,
                    'teeny' => true,
                );
                wp_editor($the_question->question_text, 'question_text', $settings); ?>
            </div>
        </fieldset>
        <fieldset style="display: block!important;" class="display_on_selecting_type display_by_qtype">
            <legend>Seçenekler</legend>
            <div class="answers_wrapper"> 
                <?php 
                $i = 1;
                foreach ($answers as $answer) { ?> 
                    <div class="option_row" style="cursor: default;"> 
                        <span>SEÇENEK</span>
                        <div> 
                            <textarea name="cevaplar[cevap_metni][]">
                                <?php echo $answer['answer_key']; ?>
                            </textarea> 
                            <textarea name="cevaplar[cvp_aciklama][]">
                                <?php echo $answer['cvp_aciklama']; ?>
                            </textarea>
                            <div style="margin-top: 10px;"> 
                            <label style="background: #ababab; padding: 8px; border-radius: 6px; color: #fff; line-height: 1; text-transform: uppercase; font-size: 1em; font-weight: bold;"> 
                            Doğru&nbsp; 
                            <input type="radio" name="cevaplar[dogru][]" value="<?php echo $i; ?>" <?php checked($answer['correct'], 1); ?> /> 
                        </label> </div>
                        </div> 
                        <button class="remove_opt">Sil</button>
                    </div> 
                    <?php 
                    $i++;
                } 
                ?> 
            </div> 
            <span class="add_option add_new_selecting add_new_selecting_opt_single">Yeni Seçenek Ekle</span>
            <div id="hidden_selecting_opt_single_correct" style="display: none;">
                <div class="option_row" style="cursor: default;"> <span>SEÇENEK</span>
                    <div> 
                        <textarea name="cevaplar[cevap_metni][]"></textarea> <textarea name="cevaplar[cvp_aciklama][]"></textarea>
                        <div style="margin-top: 10px;"> <label style="background: #ababab; padding: 8px; border-radius: 6px; color: #fff; line-height: 1; text-transform: uppercase; font-size: 1em; font-weight: bold;"> 
                        Doğru&nbsp; 
                        <input type="radio" name="cevaplar[dogru][]" value="1" /> 
                    </label> 
                </div>
                    </div> 
                    <button class="remove_opt">Sil</button>
                </div>
            </div>
        </fieldset> 
        <input class="save_question" type="submit" name="edit_questionn" value="SORUYU KAYDET" />
    </form>
</div>
<div class="orion_sidebar"> 
    <img style="border-radius: 1em;" src="<?php echo DOQ_PLUGIN_URL . '/assets/img/orion_sidebar.png'; ?>" /> 
</div>
<script>
    jQuery(function($) {
        $(document).on('click', '.add_new_selecting_opt_single', function() {
            var blankOpt = $('#hidden_selecting_opt_single_correct').html();
            $(this).parent().find('.answers_wrapper').append(blankOpt);
            var count = $(this).parent().find('.answers_wrapper').find('.option_row').length;
            $(this).parent().find('.answers_wrapper').find('.option_row').eq(count - 1).find('input[type="radio"]').val(count);
        });
        $(document).on('click', '.remove_opt', function() {
            $(this).parent().remove();
            $('.display_on_selecting_type .answers_wrapper .option_row').each(function(i) {
                $('.answers_wrapper .option_row').eq(i).find('input[type="radio"]').val((i + 1));
            });
        });
    });
</script>
