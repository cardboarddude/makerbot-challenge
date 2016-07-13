<?php

class Feedback {

    const SESSION_NAME = 'FEEDBACK';

    public static function add($category, $feedback) {
        if (!isset($_SESSION[self::SESSION_NAME])) {
            $_SESSION[self::SESSION_NAME] = [];
        }
        if (!isset($_SESSION[self::SESSION_NAME][$category])) {
            $_SESSION[self::SESSION_NAME][$category] = [];
        }
        $_SESSION[self::SESSION_NAME][$category] = array_merge($_SESSION[self::SESSION_NAME][$category], array($feedback));
    }

    public static function getFeedbackList($category) {
        $feedback_array = $_SESSION[self::SESSION_NAME][$category];
        if (empty($feedback_array)) return "";

        $ul_list = "<ul class='feedback-category $category'>";
        foreach ($feedback_array as $feedback_item) {
            $ul_list .= "<li>$feedback_item</li>";
        }
        $ul_list .= "</ul>";
        $_SESSION[self::SESSION_NAME][$category] = [];
        return $ul_list;
    }

    public static function getAllFeedbackList() {
        $ul_list = "";
        foreach ($_SESSION[self::SESSION_NAME] as $category => $array) {
            $ul_list .= self::getFeedbackList($category);
        }
        return $ul_list;
    }

    public static function wrapFeedbackList($list) {
        $list = "<div class='feedback'>".$list;
        $list .= "</div>";
        return $list;
    }
}