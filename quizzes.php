<style>
    body {
        background: #fff;
    }

    .manage_questions {
        background: #4CAF50;
        padding: 2px 4px 2px 7px;
        color: #fff;
        border-radius: 3px 0 0 3px;
    }
  
    .count_questions {
        background: #49844b;
        padding: 2px 6px 2px 7px;
        color: #fff;
        border-radius: 0 3px 3px 0;
    }

    .edit_quiz {
        background: #636363;
        padding: 2px 6px;
        color: #fff;
        border-radius: 3px;
        margin-left: .5em;
    }

    .create_new_quiz {
        display: inline-block;
        background: #F44336;
        color: #fff;
        padding: .4em .4em;
        border-radius: 4px;
        text-decoration: none;
        font-size: 1.6em;
        vertical-align: middle;
        position: absolute;
        top: 50%;
        left: 2em;
        transform: translateY(-50%);
    }

    .manage_questions:hover,
    .manage_questions:focus,
    .manage_questions:active,
    .edit_quiz:hover,
    .edit_quiz:focus,
    .edit_quiz:active,
    .delete_quiz:hover,
    .delete_quiz:focus,
    .delete_quiz:active,
    .delete_question:hover,
    .delete_question:focus,
    .delete_question:active,
    .create_new_quiz:hover,
    .create_new_quiz:focus,
    .create_new_quiz:active,
    .count_questions:hover,
    .count_questions:focus,
    .count_questions:active {
        color: #fff;
    }

    #sinavlar {
        margin: 0 1.5em 0 0;
    }

    #sinavlar th {
        background: linear-gradient(#3c3c3c, #525252);
        color: #fff;
    }

    #sinavlar thead th:first-child {
        border-radius: 10px 0 0 0;
    }

    #sinavlar thead th:last-child {
        border-radius: 0 10px 0 0;
    }

    .alternate:nth-child(even) {
        background: #e2e2e2;
    }

    .quiz_intro {
        position: relative;
        width: 92%;
        height: 100px;
        background: linear-gradient(#484848, #252525);
        border-radius: 10px;
        margin-top: 4em;
    }

    .quiz_intro.add_new {
        background: linear-gradient(#076d0a, #54a957);
    }

    .quiz_icon {
        display: none;
    }

    .quiz_intro:hover .quiz_icon {
        transform: rotate(45deg);
        transform-origin: center center;
    }

    .quiz_intro>div {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .quiz_intro .header_title {
        color: #fff;
        font-size: 2.5em;
        font-style: italic;
        vertical-align: middle;
        cursor: default;
    }

    .quiz_intro .quiz_version {
        position: absolute;
        bottom: .6em;
        color: #ffffff;
        right: 1.1em;
        cursor: default;
    }

    .quiz_wrapper {
        display: inline-block;
        width: 70%;
    }

    .orion_sidebar {
        display: inline-block;
        width: 25%;
        vertical-align: top;
        margin-top: 2em;
    }

    .edit_quiz_sidebar {
        display: inline-block;
        vertical-align: top;
        background: #e8e8e7;
        padding: 1em 2em;
        width: 17.4%;
        border-radius: 10px;
        border: 4px dotted #b4b1b1;
        margin-top: 2.4em;
    }

    .edit_quiz_sidebar>span {
        text-align: center;
        display: inline-block;
        font-size: 1.4em;
        line-height: 1.25em;
        font-weight: bold;
        color: #828282;
    }

    .edit_quiz_sidebar ul li span {
        font-weight: bold;
        margin-right: 1em;
        display: inline-block;
        width: 7.5em;
        color: #696969;
    }

    .quiz_wrapper input,
    .quiz_wrapper select {
        height: 28px;
        vertical-align: middle;
    }

    .quiz_wrapper input[type="checkbox"] {
        height: 24px;
        width: 24px;
    }

    .quiz_wrapper input[type=checkbox]:checked:before {
        margin: -2px 0 0 -4px;
        font: 400 29px/1 dashicons;
    }

    fieldset {
        border: thin solid #b4b1b1;
        margin: 20px 20px 30px 0;
        border-radius: 5px;
        background: #E8E8E7;
        padding: 1em 2em;
    }

    legend {
        font-size: 16px;
        /* margin-left: 25px; */
        padding: 5px 10px;
        background: #787777;
        color: #fff;
        border-radius: 5px;
    }

    fieldset label.sm_label {
        display: inline-block;
        width: 10em;
        font-weight: bold;
        margin-bottom: 3px;
        line-height: .8em;
        font-size: 1.2em;
        color: #616060;
    }

    fieldset label.lg_label {
        display: inline-block;
        width: 18em;
        font-weight: bold;
        margin-bottom: 3px;
        line-height: .8em;
        font-size: 1.2em;
        color: #616060;
    }

    fieldset .wp-editor-wrap {
        width: calc(100% - 13em);
        display: inline-block;
        vertical-align: top;
    }

    fieldset input[type="text"] {
        width: calc(100% - 14em);
    }

    .option_row {
        margin-bottom: .6em;
    }

    .final_result_desc input[type="text"] {
        width: calc(100% - 20em);
    }

    .final_result_desc span {
        vertical-align: middle;
    }

    .save_quiz {
        background: #5a5a5a;
        color: #fff;
        border: 0;
        box-shadow: none;
        padding: 6px 12px;
        font-size: 1.4em;
        border-radius: 6px;
        cursor: pointer;
        height: auto !important;
    }

    .shortcode {
        position: absolute;
        top: 50%;
        left: 2em;
        transform: translateY(-50%);
        background-color: #F44336 !important;
        border: 0 !important;
        box-shadow: none;
        color: #fff !important;
        border-radius: 5px;
        text-align: center;
        font-size: 1.3em;
        height: 2em;
        width: 7em;
        vertical-align: middle;
        line-height: 1;
        padding: 1em 0;
    }

    .save_question {
        background: #5a5a5a;
        color: #fff;
        border: 0;
        box-shadow: none;
        padding: 6px 12px;
        font-size: 1.4em;
        border-radius: 6px;
        cursor: pointer;
        height: auto !important;
    }

    .quiz_wrapper input[type="radio"] {
        width: 24px;
        height: 24px;
    }

    .quiz_wrapper input[type="radio"]:before,
    .quiz_wrapper input[type="radio"]:checked:before {
        margin: 6.2px !important;
        width: 10px;
        height: 10px;
    }

    .display_on_selecting_type .option_row,
    .display_on_matris_type .option_row,
    .display_on_ordering_type .option_row {
        background: #dadada;
        padding: 2em 0 2em 4em;
        border-radius: 8px;
        cursor: move;
    }

    .display_on_selecting_type .option_row>span,
    .display_on_matris_type .option_row>span,
    .display_on_ordering_type .option_row>span {
        writing-mode: tb-rl;
        transform: rotate(-180deg);
        vertical-align: top;
        font-size: 1.36em;
        font-weight: bold;
        margin-right: 5px;
        color: #e8e8e7;
        letter-spacing: 4px;
        background: #ababab;
        padding: 6px 4px 3px 5px;
        border-radius: 6px;
    }

    .display_on_selecting_type .option_row>div,
    .display_on_matris_type .option_row>div,
    .display_on_ordering_type .option_row>div {
        display: inline-block;
    }

    .display_on_matris_type .option_row>div textarea {
        width: 19em;
        height: 6em;
        display: block;
        vertical-align: middle;
    }

    .display_on_selecting_type .option_row>div textarea,
    .display_on_ordering_type .option_row>div textarea {
        width: 36em;
        height: 6em;
        display: block;
        vertical-align: middle;
    }

    .display_on_selecting_type .option_row>div button,
    .display_on_matris_type .option_row>div button,
    .display_on_ordering_type .option_row>div button {
        display: block;
        vertical-align: middle;
    }

    .display_on_selecting_type button.remove_opt,
    .display_on_matris_type button.remove_opt,
    .display_on_ordering_type button.remove_opt {
        background: #f44336d1;
        color: #fff;
        border: 0;
        font-size: 1.2em;
        padding: 2px 8px;
        vertical-align: top;
        border-radius: 4px;
        cursor: pointer;
    }

    .display_on_selecting_type button.move_opt,
    .display_on_matris_type button.move_opt,
    .display_on_ordering_type button.move_opt {
        background: #009688;
        color: #fff;
        border: 0;
        font-size: 1.2em;
        padding: 2px 8px;
        vertical-align: top;
        border-radius: 4px;
        cursor: pointer;
    }

    .display_by_qtype {
        display: none;
    }

    pre {
        margin: 0;
        display: inline-block;
        word-break: break-word;
        background: white;
        padding: 0 5px;
        border-radius: 3px;
    }

    .ui-sortable-placeholder {
        border: 3px dashed #aaa;
        height: 12em;
        width: 100%;
        background: #eee;
        border-radius: 10px;
        margin-bottom: .6em;
    }

    .add_option {
        background: #1896a7;
        color: #fff;
        border: 0;
        box-shadow: none;
        padding: 6px 10px;
        font-size: 1.2em;
        border-radius: 5px;
        cursor: pointer;
        margin-top: .5em;
        display: inline-block;
    }

    .not-allowed,
    .not-allowed * {
        cursor: not-allowed;
    }

    .delete_quiz,
    .delete_question {
        background: #f44336;
        padding: 2px 6px;
        color: #fff;
        border-radius: 3px;
        margin-left: .5em;
    }

    .sm_input {
        width: 4em;
    }
</style> 

<?php
if (isset($_GET['action']) && $_GET['action'] === 'new_quiz') {
    include(plugin_dir_path(__FILE__).
        'includes/new_quiz.php');
} elseif (isset($_GET['action']) && isset($_GET['quiz_id']) && $_GET['action'] === 'edit_quiz') {
    include(plugin_dir_path(__FILE__).
        'includes/edit_quiz.php');
} elseif (isset($_GET['action']) && isset($_GET['quiz_id']) && $_GET['action'] === 'questions') {
    include(plugin_dir_path(__FILE__).
        'includes/questions.php');
} elseif (isset($_GET['action']) && isset($_GET['quiz_id']) && isset($_GET['question_id']) && $_GET['action'] === 'edit_question') {
    include(plugin_dir_path(__FILE__).
        'includes/edit_question.php');
} elseif (isset($_GET['action']) && isset($_GET['quiz_id']) && $_GET['action'] === 'new_question') {
    include(plugin_dir_path(__FILE__).
        'includes/new_question.php');
} else {
    include(plugin_dir_path(__FILE__).
        'includes/quiz_list.php');
}