<style> 
    div#selecting_type_check_correct_answer_type { 
        margin: .5em 0 1.5em 0; 
    } 
</style>
<?php  
    $quiz_id = $_GET['quiz_id']; ?>  
    <div class="quiz_intro add_new"> 
        <a href="admin.php?page=devorion-quiz%2Fquizzes.php&action=questions&quiz_id=<?php echo $_GET['quiz_id']; ?>" class="create_new_quiz">Soru Listesine Geri Dön</a> 
        <div> 
            <span class="header_title">YENİ SORU OLUŞTUR</span> 
            <img class="quiz_icon" src="<?php echo DOQ_PLUGIN_URL . '/assets/img/icon.jpg'; ?>"/> 
            </div> 
            </div>  
            <?php 
            if (isset($_POST['create_question'])) {
                global $wpdb;
                $question_text = stripslashes(wp_kses_post($_POST['question_text']));
                $question_table_name = $wpdb->prefix . 'doq_question';
                $wpdb->insert($question_table_name, array(
                    'quiz_id' => $quiz_id,
                    'question_text' => $question_text,
                ));
                $question_id = $wpdb->insert_id;
                if (isset($_POST['selecting_s_answer_data'])) {
                    $selecting_s_answer_data = array();
                    for ($i = 0;$i < count($_POST['selecting_s_answer_data']['key']);$i++) {
                        if ('' != $_POST['selecting_s_answer_data']['key'][$i]) {
                            $selecting_s_answer_data['key'][] = $_POST['selecting_s_answer_data']['key'][$i];
                            $selecting_s_answer_data['order'][] = $_POST['selecting_s_answer_data']['order'][$i];
                            $selecting_s_answer_data['cvp_aciklama'][] = $_POST['selecting_s_answer_data']['cvp_aciklama'][$i];
                        }
                    }
                    for ($k = 0;$k < count($selecting_s_answer_data['key']);$k++) {
                        $key_text = $selecting_s_answer_data['key'][$k];
                        $order = $selecting_s_answer_data['order'][$k];
                        $cvp_aciklama = $selecting_s_answer_data['cvp_aciklama'][$k];
                        $answer_table_name = $wpdb->prefix . 'doq_answer';
                        $wpdb->insert($answer_table_name, array(
                            'question_id' => $question_id,
                            'answer_key' => stripslashes(wp_kses_post($key_text)) ,
                            'cvp_aciklama' => stripslashes(wp_kses_post($cvp_aciklama)) ,
                            'answer_value' => '',
                            'correct' => 0,
                            'sorting_order' => $order,
                        ));
                    }
                }
                $correct_number = $_POST['single_answer_correct'];
                $tablee = $wpdb->prefix . 'doq_answer';
                $wpdb->update($tablee, array(
                    'correct' => 1
                ) , array(
                    'sorting_order' => $correct_number
                ) , array(
                    '%s'
                ));
                wp_redirect('admin.php?page=devorion-quiz%2Fquizzes.php&action=questions&quiz_id=' . $quiz_id);
                die;
            }
?>   
<div class="quiz_wrapper">  
    <form action="" name="create_question" id="" method="post">  
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
                wp_editor('', 'question_text', $settings); ?> 
                </div>  
        </fieldset>  
        <fieldset style="display: block!important;" class="display_on_selecting_type display_by_qtype"> 
            <legend>Seçenekler</legend> 
            <div class="answers_wrapper">   
                <div id="selecting_type_check_correct_answer_type" style="display: none"> 
                    <input type="radio" name="check_correct_answer_type" id="check_correct_answer_type_single" value="0" data-type="single"> 
                    <label for="check_correct_answer_type_single" class="check_correct_answer_type">Tek doğru cevap</label>  
                    <input type="radio" name="check_correct_answer_type" id="check_correct_answer_type_multi" value="1" data-type="multi" style="margin-left: 2em;"> 
                    <label for="check_correct_answer_type_multi" class="check_correct_answer_type">Birden fazla doğru cevap</label> 
                </div>   
            </div>  
            <span class="add_option add_new_selecting add_new_selecting_opt_single">Yeni Seçenek Ekle</span>  
            <div id="hidden_selecting_opt_single_correct" style="display: none;"> 
                <div class="option_row" style="cursor: default;"> 
                    <span>SEÇENEK</span> 
                <div> 
                <textarea name="selecting_s_answer_data[key][]"></textarea> 
                <textarea name="selecting_s_answer_data[cvp_aciklama][]"></textarea> 
                <div style="margin-top: 10px;"> 
                <label style="background: #ababab; padding: 8px; border-radius: 6px; color: #fff; line-height: 1; text-transform: uppercase; font-size: 1em; font-weight: bold;"> 
                    Doğru&nbsp; 
                    <input type="radio" class="correct_answer_single" name="single_answer_correct" value="1"/> 
                    <input type="hidden" class="answer_order" name="selecting_s_answer_data[order][]" value="1"/> 
                </label> 
            </div> 
            </div>
            <button class="remove_opt">Sil</button>  
            </div> 
            </div>  
        </fieldset>  
        <input class="save_question" type="submit" name="create_question" value="SORUYU KAYDET"/> 
    </form> 
</div>  
<div class="orion_sidebar"> 
    <img style="border-radius: 1em;" src="<?php echo DOQ_PLUGIN_URL . '/assets/img/orion_sidebar.png'; ?>"/> 
    </div>      
    <script> 
    jQuery(function ($){  
        $('fieldset').eq(0).fadeIn();   
        var content = $('#selecting_type_check_correct_answer_type').html(); 
        $('.display_on_selecting_type .answers_wrapper').html(content); 
        $('.display_on_selecting_type .add_new_selecting').hide(); 
        var elementsSingle = $('#hidden_selecting_opt_single_correct').html(); 
        $('.display_on_selecting_type .answers_wrapper').append(elementsSingle); 
        $('.add_new_selecting_opt_single').show(); 
        $('input[name="check_correct_answer_type"], .check_correct_answer_type').hide();   
        $('.add_new_matris_opt').on('click', function(){  
            var blankOpt = $('#hidden_matris_opt').html(); 
            $(this).parent().find('.answers_wrapper').append(blankOpt);  
            var count = $(this).parent().find('.answers_wrapper').find('.option_row').length; 
            $(this).parent().find('.answers_wrapper').find('.option_row').eq(count-1).find('input.answer_order').val(count);  
        });
        $('.add_new_ordering_opt').on('click', function(){
            var blankOpt = $('#hidden_ordering_opt').html(); 
            $(this).parent().find('.answers_wrapper').append(blankOpt);  
            var count = $(this).parent().find('.answers_wrapper').find('.option_row').length; 
            $(this).parent().find('.answers_wrapper').find('.option_row').eq(count-1).find('input.answer_order').val(count); 
        });
        $(document).on('click', '.add_new_selecting_opt_single', function () { 
            var blankOpt = $('#hidden_selecting_opt_single_correct').html(); 
            $(this).parent().find('.answers_wrapper').append(blankOpt);  
            var count = $(this).parent().find('.answers_wrapper').find('.option_row').length; 
            $(this).parent().find('.answers_wrapper').find('.option_row').eq(count-1).find('input.answer_order').val(count); 
            $(this).parent().find('.answers_wrapper').find('.option_row').eq(count-1).find('input.correct_answer_single').val(count);  
        });    
        $(document).on('click', '.remove_opt', function () {
            $(this).parent().remove();  
            $('.display_on_ordering_type .answers_wrapper .option_row').each(function(i){
                $('.answers_wrapper .option_row').eq(i).find('.answer_order').val((i)); 
            }); 
            $('.display_on_selecting_type .answers_wrapper .option_row').each(function(i){ 
                $('.answers_wrapper .option_row').eq(i).find('.answer_order').val((i+1)); 
                $('.answers_wrapper .option_row').eq(i).find('.correct_answer_single, .correct_answer_multi').val((i+1)); 
            }); 
            $('.display_on_matris_type .answers_wrapper .option_row').each(function(i){
                $('.answers_wrapper .option_row').eq(i).find('.answer_order').val((i+1)); 
            }); 
        }); 
        /* $(".answers_wrapper").sortable({ placeholder: 'ui-sortable-placeholder', update: function(event, ui) { $('.display_on_ordering_type .answers_wrapper .option_row').each(function(i){ $('.answers_wrapper .option_row').eq(i).find('.answer_order').val((i)); }); $('.display_on_selecting_type .answers_wrapper .option_row').each(function(i){ $('.answers_wrapper .option_row').eq(i).find('.answer_order').val((i+1)); $('.answers_wrapper .option_row').eq(i).find('.correct_answer_single, .correct_answer_multi').val((i+1)); }); $('.display_on_matris_type .answers_wrapper .option_row').each(function(i){ $('.answers_wrapper .option_row').eq(i).find('.answer_order').val((i+1)); }); }, }); */         
    }); 
    </script>
