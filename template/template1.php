<?php 
global $wpdb;
$table_of_quizzes = $wpdb->prefix . 'doq_quiz';
$quiz_data = $wpdb->get_row("SELECT * FROM $table_of_quizzes WHERE ID = $quiz_id");
$quiz_name = $quiz_data->name;
$welcome_text = $quiz_data->welcome_desc;
$creation_date = $quiz_data->creation_date;
$time_limit = $quiz_data->time_limit;
$time_limit_check = $quiz_data->time_limit_check; 
?>  

<style> .doq_answers_container { padding-left: 1.3em!important; margin: 2em 0 0 1em!important; display: inline-block; } .doq_answers_container > ul { list-style: none!important; } li.doq_answer { list-style: none!important; margin: 0 0 5px 0!important; } li.doq_answer label { cursor: pointer; } ul[data-question-type="3"] li.doq_answer { cursor: move; padding: 0 0 .5em 0; } ul[data-question-type="3"] li.doq_answer label { background: #F44336; color: #fff; border-radius: 4px; vertical-align: middle; cursor: move; border: 2px dotted #000000; } ul[data-question-type="3"] li.doq_answer label { padding: .5em; } .question_type_3_placeholder { border: 3px dashed #aaa; background: #eee; border-radius: 10px; list-style: none!important; } .matris_key, .matris_value { display: inline-block; vertical-align: middle; margin: .1em; } .matris_key li { background: #908c8c; color: #fff; border-radius: 4px; padding: 5px 10px; display: block; vertical-align: middle; cursor: not-allowed; user-select: none; } .matris_value li { background: #F44336; color: #fff; border-radius: 4px; padding: 3px 9px; vertical-align: middle; cursor: move; border: 2px dotted #000000; } .doq_question_number { display: block; font-weight: bold; margin-bottom: 1em; border-bottom: 1px solid #4e4e4e; } span.doq_question_title { display: inline-block; width: 90%; vertical-align: top; } .filling_type_input { display: inline-block!important; width: 135px!important; text-align: center!important; font-size: inherit!important; line-height: 0!important; color: inherit!important; max-width: 100%!important; height: 24px!important; padding: 0!important; border-bottom: 2px dotted #000!important; vertical-align: text-bottom!important; background: none!important; border-top: 0!important; border-right: 0!important; border-left: 0!important; } .filling_type_input:active, .filling_type_input:focus { border-bottom: 2px dotted #000!important; border-top: 0!important; border-right: 0!important; border-left: 0!important; } .doq_hidden { display: none; } 

.start_quiz {
    background: #2a9e2e;
    border: 0;
    box-shadow: none;
    color: #fff;
    padding: 12px 20px;
    border-radius: 4px;
    margin: 2em auto 0;
    display: block;
    font-size: 30px;
}
 
.finish_quiz, .prev_question, .next_question {
    background: #2a9e2e;
    border: 0;
    box-shadow: none;
    color: #fff;
    padding: 12px 20px;
    border-radius: 4px;
    font-size: 20px;
}
.doq_timer { text-align: right; margin: 0 0 7px; } .doq_timer span { font-size: 2em; font-weight: bold; background: #3a3939; color: #fff; padding: 4px 10px; border-radius: 4px; } .doq_analysis { margin-bottom: 2em; } .doq_analysis_header, 
.doq_analysis_footer { 
    display: flex; 
    justify-content: center; 
} 
.doq_analysis_header > div, 
.doq_analysis_footer > div { 
    flex-grow: 1; 
    text-align: center; 
    background: #eee; 
    margin: 3px; 
    padding: 20px 13px 20px; 
} 
.doq_analysis_footer > div span, 
.doq_analysis_header > div span { 
    display: block; 
} 
.doq_analysis_header > div span:last-child, 
.doq_analysis_footer > div span:last-child { 
    font-weight: bold; 
    font-size: 2em; 
    line-height: 1; margin-top: 5px; 
} 
.doq_analysis_footer > table thead {
    background: #f44336;
    border-radius: 4px 4px 0 0;
}
.doq_analysis_footer > table th {
    text-align: left;
    font-size: 22px;
    padding-left: 20px;
}
.doq_analysis_footer > table tr.satirr:nth-child(odd) {
    background: #2f2f2f;
}
.doq_analysis_footer > table tr.satirr td {
    text-align: left;
    padding-left: 20px;
}
.doq_total_point span:last-child { font-size: 5.5em!important; } .doq_final_text { background: blanchedalmond; padding: 2em; } .doq_final_text p { margin: 0; } .doq_final_text span { vertical-align: middle; } .doq_live_answer { display: block; text-align: right; margin-bottom: 5px; } .doq_check_answer { background: #3F51B5; border: 0; box-shadow: none; color: #fff; padding: 4px 10px; border-radius: 4px; } .doq_question_pager { display: inline-block; margin-bottom: 2em; } .doq_question_pager ul { list-style: none; margin: 0; padding: 0; } .doq_pager_element { display: inline-block; margin: 0 2px!important; padding: .7em; background: #969393; color: #fff; line-height: 1; vertical-align: middle; border-radius: 3px; cursor: pointer; } .doq_pager_element.active { background: #4e4e4e; } .doq_buttons { text-align: center; margin: 2em 0; } .next_question, .prev_question { background: #656565; } .start_quiz:focus, .finish_quiz:focus, .next_question:focus, .prev_question:focus { outline: 0!important; } .prev_question.disable, .next_question.disable { background: #d2d2d2; cursor: default; } .doq_question { position: relative; display: block; padding: 3em; background: #f5f4f4; border-radius: 6px; margin: 1em; } .greenbg { color: green; font-weight: bold; transition: all 1s ease; } label { transition: all 1s ease; } .doq_final_answers span { font-size: 1.24em; font-weight: bold; } .doq_final_check_correctivity { position: absolute; top: 0; right: 0; padding: 3px 14px; border-radius: 4px 4px 0 0; width: 100%; text-align: center; } .doq_final_check_correctivity span { color: #fff; } .dogru_yaptiniz { background: #22a929; } .yanlis_yaptiniz { background: #f44336; } .bos_biraktiniz { background: #8a8787; } .shik_img { float: left; margin: 0 8px 0 0; padding-top: 2px; } button.prev_question { float: left; } button.next_question { float: right; } .sorulari_kapat { display: none!important; } .yeni_sorulist { display: none; }  .new_box { display: inline-block; min-width: 20%; border-bottom: 2px solid #3f51b5; border-right: 2px solid #3f51b5; text-align: center; line-height: 4em; font-size: 20px; cursor: pointer; } .new_box:nth-child(-n + 5){ border-top: 2px solid #3f51b5; } .new_box:first-child, .new_box:nth-child(6n){ border-left: 2px solid #3f51b5; }  .cevaplandi { background: #3f51b5; color: #fff; border-bottom: 2px solid #d0cbcb; border-right: 2px solid #d0cbcb; } .cevaplandi:first-child, .cevaplandi:nth-child(6n){ border-left: 2px solid #d0cbcb; }  button.questionss { background: #3F51B5; border: 0; box-shadow: none; color: #fff; padding: 4px 10px; border-radius: 4px; } .dolu { display: none; } .input_bosluk_doldurma_yanlis { text-decoration: line-through; color: red!important; } .input_bosluk_doldurma_dogru { color: green!important; font-weight: bold; } input.dogru_input_yerlestir { display: inline-block!important; width: 100px!important; text-align: center!important; font-size: inherit!important; line-height: 0!important; color: #4CAF50!important; max-width: 100%!important; height: 24px!important; padding: 0!important; border-bottom: 2px dotted #000!important; vertical-align: text-bottom!important; background: none!important; border-top: 0!important; border-right: 0!important; border-left: 0!important; font-weight: bold; margin-left: 1px; } span.dogru-yanlis-text.dogru { background: #4CAF50; color: #fff; padding: 1px 5px; border-radius: 3px; } span.dogru-yanlis-text.yanlis { background: #f44336; color: #fff; padding: 1px 5px; border-radius: 3px; } span.dogru-yanlis-text.bos { background: #9a9a9a; color: #fff; padding: 1px 5px; border-radius: 3px; } .doq_question_pager { height: 0; width: 0; opacity: 0; margin: 0!important; padding: 0!important; display: block; } .doq_question_pager.kapalii { height: 0; width: 0; opacity: 0; margin: 0!important; padding: 0!important; display: block; } .doq_question_pager.kapalii * { width: 0; height: 0; padding: 0!important; margin: 0!important; }  /* YANLIŞ SORU -SIRALAMA */ .yenii { display: inline-block; margin-left: 2em; } .yenii li { padding: 0 0 .5em 0; } .yenii label.doq_answer_text { color: #fff; border-radius: 4px; vertical-align: middle; cursor: move; border: 2px dotted #000000; padding: .5em; } /* YANLIŞ SORU -SIRALAMA */  .doq_answer_text img { margin-bottom: 0!important; }  .concon_yeni { display: inline-block; margin-left: 2em; } .concon_yeni .matris_value li { background: #4caf50; }
.doq_welcome_screen ul {
    list-style: none;
    margin: auto;
    padding: 0;
    max-width: 400px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.doq_welcome_screen ul li { 
    margin-bottom: 10px; 
} 
.doq_welcome_screen ul li label {
    display: block;
}
.doq_analysis_footer { display: block; background: linear-gradient(#525252, #292929); margin: 3px; color: #fff; padding: 20px; } .doq_container { position: relative; padding: 20px; } .loaderr { display: none; position: absolute; top: 0; left: 0; z-index: 9999; width: 100%; height: 100%; background: #00000085; } .loaderr img { max-width: 100px; margin: 0 auto; top: 22%; position: absolute; left: 50%; transform: translate(-50%,-50%); } .doq_empty { background: linear-gradient(#FFD700,#FFA500)!important; } .cvp_aciklama { display: none; background: #009688; color: #fff; padding: 16px 16px; border-radius: 6px; line-height: 1; margin-top: 20px; } </style>  

<div class="doq_container" 
    data-quiz-id="<?php echo $quiz_id; ?>" 
    data-quiz-name="<?php echo $quiz_name; ?>"
    data-time-limit="<?php echo ($time_limit_check == 1) ? 1 : 0; ?>" 
    data-time="<?php echo $time_limit; ?>" 
    data-adminajax="<?php echo admin_url('admin-ajax.php'); ?>" 
    data-true-icon="<?php echo DOQ_PLUGIN_URL . 'assets/img/true_icon.png'; ?>" 
    data-wrong-icon="<?php echo DOQ_PLUGIN_URL . 'assets/img/wrong_icon.png'; ?>" >  
        <div class="loaderr"> 
            <img src="<?php echo DOQ_PLUGIN_URL . 'assets/img/loader.gif'; ?>"/> 
        </div>  
        <div class="doq_welcome_screen <?php if ($hide_welcome_desc == 1) { echo 'doq_hidden'; } ?>">
            <div style=""> <?php echo doq_description_filter($welcome_text); ?> 
                <div style=""> 
                    <ul> 
                        <li> 
                            <label>Adınız Soyadınız</label> 
                            <input type="text" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" name="katilimci_isim" value=""/> 
                        </li> 
                        <li>
                            <label>Instagram Kullanıcı Adınız</label> 
                            <input type="text" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" name="katilimci_ig" value=""/> 
                        </li> 
                        <li> 
                            <button class="start_quiz">SINAVA BAŞLA</button> 
                        </li> 
                    </ul>  
                </div> 
            </div> 
        </div>  

        <?php 
        if ($time_limit_check == 1){
            ?> 
            <div class="doq_timer doq_hidden" id="container"> 
                <span id="doq_timer" data-time-limit="<?php echo $time_limit; ?>">00:00</span> 
            </div> 
            <?php
        }
        ?> 

        <div class="doq_analysis doq_hidden">   
            <div class="doq_analysis_header"> 
                <div class="doq_all_questions"> 
                    <span>SORU SAYISI</span> 
                    <span>0</span> 
                </div> 
                <div class="doq_corrects"> 
                    <span>DOĞRU SAYISI</span> 
                    <span>0</span> 
                </div> 
                <div class="doq_wrongs"> 
                    <span>YANLIŞ SAYISI</span> 
                    <span>0</span> 
                </div> 
                <div class="doq_empty"> 
                    <span>PUANINIZ</span> 
                    <span>0</span> 
                </div> 
            </div>  

            <div class="doq_analysis_footer">  </div> 
        </div> 

        <div class="doq_final_answers doq_hidden"> 
            <span>YANITLAR</span> 
        </div>  

        <div class="doq_questions_container doq_hidden">  
            <?php 
                $table_of_questions = $wpdb->prefix . 'doq_question';
                $questions = $wpdb->get_results('SELECT * FROM ' . $table_of_questions . ' WHERE quiz_id=' . $quiz_id . ' ORDER BY ID', ARRAY_A);
                $i = 1;
            if (!empty($questions)){
                foreach ($questions as $question){ 
                    ?> 
                    <div class="doq_question" data-question-type="<?php echo $question['question_type']; ?>" data-question-point="<?php echo (isset($question['question_point'])) ? $question['question_point'] : 0; ?>">  
                        <div class="doq_question_number">Soru <?php echo $i; ?> 
                        <span class="dogru-yanlis-text"></span>
                    </div> 
                    <span class="doq_question_title"><?php echo $question['question_text']; ?></span>  
                    <?php 
                    $table_of_answers = $wpdb->prefix . 'doq_answer';
                    $answers = $wpdb->get_results('SELECT * FROM ' . $table_of_answers . ' WHERE question_id=' . $question['ID'] . ' ORDER BY ID', ARRAY_A); 
                    ?> 

                    <ul class="doq_answers_container" data-question-type="<?php echo $question['question_type']; ?>" data-count-correct="<?php echo $question['correct_answer_type']; ?>" data-question-point="<?php /*echo $question['question_point'];*/ ?>"> 
                        <?php 
                        $a = 0;
                        if (!empty($answers)){
                            foreach ($answers as $answer){
                                if ($a == 0){
                                    $unchecked_img = DOQ_PLUGIN_URL . 'assets/img/a_letter.png';
                                    $checked_img = DOQ_PLUGIN_URL . 'assets/img/a_letter_checked.png';
                                }
                                if ($a == 1){
                                    $unchecked_img = DOQ_PLUGIN_URL . 'assets/img/b_letter.png';
                                    $checked_img = DOQ_PLUGIN_URL . 'assets/img/b_letter_checked.png';
                                }
                                if ($a == 2){
                                    $unchecked_img = DOQ_PLUGIN_URL . 'assets/img/c_letter.png';
                                    $checked_img = DOQ_PLUGIN_URL . 'assets/img/c_letter_checked.png';
                                }
                                if ($a == 3){
                                    $unchecked_img = DOQ_PLUGIN_URL . 'assets/img/d_letter.png';
                                    $checked_img = DOQ_PLUGIN_URL . 'assets/img/d_letter_checked.png';
                                }
                                if ($a == 4){
                                    $unchecked_img = DOQ_PLUGIN_URL . 'assets/img/e_letter.png';
                                    $checked_img = DOQ_PLUGIN_URL . 'assets/img/e_letter_checked.png';
                                } 
                                ?> 
                                <li class="doq_answer" data-unchecked-img="<?php echo $unchecked_img; ?>" data-checked-img="<?php echo $checked_img; ?>"> <label class="doq_answer_text answer_type_0_label"> <img style="" class="bos shik_img" src="<?php echo $unchecked_img; ?>"/> <img style="" class="dolu shik_img" src="<?php echo $checked_img; ?>"/>  <input style="display: none;" type="radio" name="question_radio_<?php echo $i; ?>" class="answer_type_0" value="" data-correct="<?php echo $answer['correct']; ?>"/> <span style="margin-top: 4px;display: inline-block;"><?php echo $answer['answer_key']; ?></span> </label> <div style="clear: both;"></div> </li>   <?php $a++;
                            }
                        } 
                        ?> 
                    </ul>  

                    <?php 
                    $dogru_cevap = $wpdb->get_row('SELECT * FROM ' . $table_of_answers . ' WHERE question_id = ' . $question['ID'] . ' AND correct = "1"');
                    $cvp_aciklamaaa = $dogru_cevap->cvp_aciklama;
                    if ($cvp_aciklamaaa && $cvp_aciklamaaa != ''){ 
                        ?> 
                        <div class="cvp_aciklama"> <?php echo $dogru_cevap->cvp_aciklama; ?> </div> 
                        <?php
                    } 
                    ?>   
                    <div class="doq_final_check_correctivity"> 
                        <span></span> 
                    </div> 
                    </div> 
                    <?php 
                    $i++;
                }
            }
            ?>  
            <div class="doq_question last_slide" style="text-align: center;"> 
                <button class="finish_quiz">SINAVI BİTİR</button> 
            </div>  
            <div class="yeni_sorulist">  </div> 
            <!-- <div class="doq_buttons"> <button class="prev_question">GERİ</button> <button class="questionss">SORULAR</button> <button class="next_question">İLERİ</button> </div> --> 
        </div>  
</div>
