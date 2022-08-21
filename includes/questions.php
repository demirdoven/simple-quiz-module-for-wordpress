<?php 
$quiz_id = $_GET['quiz_id'];
if (isset($_GET['do']) && $_GET['do'] == 'delete_question' && isset($_GET['question_id']) && $_GET['question_id'] != '') {
    echo $_GET['question_id'];
    global $wpdb;
    $table_name1 = $wpdb->prefix . 'doq_question';
    $wpdb->delete($table_name1, array(
        'ID' => $_GET['question_id']
    )); 
    $table_name2 = $wpdb->prefix . 'doq_answers';
    $wpdb->delete($table_name2, array(
        'question_id' => $_GET['question_id']
    ));
    wp_redirect('admin.php?page=devorion-quiz%2Fquizzes.php&action=questions&quiz_id=' . $quiz_id);
    die;
} 
?>  
<div class="quiz_intro"> 
    <a href="admin.php?page=devorion-quiz%2Fquizzes.php&action=new_question&quiz_id=<?php echo $quiz_id; ?>" class="create_new_quiz">Yeni Soru Oluştur</a> 
    <div> 
        <span class="header_title">SINAVA AİT SORULAR</span> 
        <img class="quiz_icon" src="<?php echo DOQ_PLUGIN_URL . '/assets/img/icon.jpg'; ?>"/> 
    </div> 
</div>   
<div class="quiz_wrapper"> 
    <div style="display: flex; margin: 27px 0 0 0;"> 
        <table class="widefat" id="sinavlar"> 
            <thead> 
                <tr> 
                    <th scope="col"> <div style="text-align: center;"> # </div> 
                </th>  
                <th scope="col"> 
                    <div style="text-align: center;"> Soru ID </div> 
                </th> <th scope="col">Soru</th> 
                <th scope="col"> 
                    <div style="text-align: center;"> Yanıt Sayısı </div> 
                </th> 
                <th scope="col"> 
                    <div style="text-align: center;"> İşlemler </div> 
                </th> 
                </tr> 
            </thead> 
            <tbody> 
                <?php 
                global $wpdb;
                $table_name = $wpdb->prefix . 'doq_question';
                $questions = $wpdb->get_results('SELECT * FROM ' . $table_name . ' WHERE quiz_id=' . $quiz_id . ' ORDER BY ID', ARRAY_A);
                $i = 1;
                if (!empty($questions)) {
                    foreach ($questions as $question) {
                        $answerz = $wpdb->get_results('SELECT * FROM wp_doq_answer WHERE question_id=' . $question['ID'], ARRAY_A); 
                        ?>  
                        <tr class="alternate"> 
                            <td scope="row" style="text-align: center;"><?php echo $i; ?></td> 
                            <td scope="row" style="text-align: center;"><?php echo $question['ID']; ?></td> 
                            <td>
                                <a href="admin.php?page=devorion-quiz%2Fquizzes.php&action=edit_question&quiz_id=<?php echo $quiz_id; ?>&question_id=<?php echo $question['ID']; ?>"> 
                                    <?php 
                                    $question_text = wp_strip_all_tags($question['question_text']); 
                                    echo (strlen($question_text) > 85) ? mb_substr($question_text, 0, 85) . '...' : $question_text; 
                                    ?> 
                                </a> 
                            </td> 
                            <td style="text-align: center;"><?php echo count($answerz); ?></td> 
                            <td>
                                <a href="admin.php?page=devorion-quiz%2Fquizzes.php&action=edit_question&quiz_id=<?php echo $quiz_id; ?>&question_id=<?php echo $question['ID']; ?>" class="manage_questions edit"> Soruyu Düzenle </a> <a href="admin.php?page=devorion-quiz%2Fquizzes.php&action=questions&quiz_id=<?php echo $quiz_id; ?>&do=delete_question&question_id=<?php echo $question['ID']; ?>" onclick="return confirm('Soru, tüm cevaplarıyla birlikte silinecek. Emin misiniz?');" class="delete_question delete">Soruyu Sil</a> 
                            </td>  
                        </tr> 
                        <?php $i++;
                    }
                }else { 
                    ?> 
                    <tr>
                        <td colspan="6" style="text-align: center;">BU SINAVA AİT KAYITLI SORU YOK!</td>
                    </tr> 
                    <?php
                }
                ?> 
            </tbody> 
        </table> 
    </div> 
</div>  
<div class="orion_sidebar"> 
    <img style="border-radius: 1em;" src="<?php echo DOQ_PLUGIN_URL . '/assets/img/orion_sidebar.png'; ?>"/> 
</div>
