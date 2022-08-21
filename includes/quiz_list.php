<?php 
if (isset($_GET['action']) && $_GET['action'] === 'delete_quiz' && isset($_GET['quiz_id'])) {
    global $wpdb;
    $table_name1 = $wpdb->prefix . 'doq_quiz';
    $table_name2 = $wpdb->prefix . 'doq_katilanlar';
    $quiz_id = $_GET['quiz_id'];
    $wpdb->delete($table_name1, array(
        'ID' => $quiz_id
    ));
    $wpdb->delete($table_name2, array(
        'quiz_id' => $quiz_id
    ));
} ?>   
<div class="quiz_intro"> 
    <a href="admin.php?page=devorion-quiz%2Fquizzes.php&action=new_quiz" class="create_new_quiz">Yeni Sınav</a> 
    <div> 
        <span class="header_title">KAYITLI SINAVLAR</span> 
        <img class="quiz_icon" src="<?php echo DOQ_PLUGIN_URL . '/assets/img/icon.jpg'; ?>"/> 
        </div> 
    </div>   
    <div class="quiz_wrapper"> 
        <div style="display: flex; margin: 27px 0 0 0;"> 
        <table class="widefat" id="sinavlar"> 
            <thead> 
                <tr> 
                    <th scope="col"> <div style="text-align: center;"> Sıra </div> </th> 
                    <th scope="col"> <div style="text-align: center;"> Sınav ID </div> </th> 
                    <th scope="col">Başlık</th> 
                    <th scope="col"> <div style="text-align: center;"> Sorular </div> </th> 
                    <th scope="col"> <div style="text-align: center;"> Kısa Kod </div> </th>  
                    <th scope="col"> <div style="text-align: center;"> İşlemler </div> </th> 
                </tr> 
            </thead> 
            <tbody id="doq_quiz_list">  
                <?php 
                global $wpdb;
                $table_name = $wpdb->prefix . 'doq_quiz';
                $quizzez = $wpdb->get_results('SELECT * FROM ' . $table_name, ARRAY_A);
                $i = 1;
                if (!empty($quizzez)) {
                    foreach ($quizzez as $quiz) {
                        $questionz = $wpdb->get_results('SELECT * FROM wp_doq_question WHERE quiz_id=' . $quiz['ID'], ARRAY_A); 
                        ?> 
                        <tr class="alternate"> 
                            <td scope="row" style="text-align: center;"><?php echo $i; ?></td> 
                            <td scope="row" style="text-align: center;"><?php echo $quiz['ID']; ?></td> 
                            <td> <a href="admin.php?page=devorion-quiz%2Fquizzes.php&action=edit_quiz&quiz_id=<?php echo $quiz['ID']; ?>"> <?php echo (strlen($quiz['name']) > 35) ? mb_substr($quiz['name'], 0, 35) . '...' : $quiz['name']; ?> </a> </td> 
                            <td style="text-align: center;">  <a href="admin.php?page=devorion-quiz%2Fquizzes.php&action=questions&quiz_id=<?php echo $quiz['ID']; ?>" class="manage_questions edit"> Soruları Yönet </a> <a href="admin.php?page=devorion-quiz%2Fquizzes.php&action=questions&quiz_id=<?php echo $quiz['ID']; ?>" class="count_questions edit"> <?php echo count($questionz); ?> </a> </td> 
                            <td style="text-align: center;"><?php echo '[sinav id=' . $quiz['ID'] . ']'; ?></td>  
                            <td style="text-align: center;">  <a href="admin.php?page=devorion-quiz%2Fquizzes.php&action=edit_quiz&quiz_id=<?php echo $quiz['ID']; ?>" class="edit_quiz edit"> Düzenle </a> <a href="admin.php?page=devorion-quiz%2Fquizzes.php&action=delete_quiz&quiz_id=<?php echo $quiz['ID']; ?>" onclick="return confirm('Sınav tüm sorularıyla birlikte silinecek. Emin misiniz?');" class="delete_quiz delete">Sil</a> </td> 
                        </tr> 
                        <?php 
                        $i++;
                    }
                }else {
                    ?> 
                    <tr>
                        <td colspan="6" style="text-align: center;">ŞU AN HİÇ KAYITLI SINAV YOK!</td>
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
