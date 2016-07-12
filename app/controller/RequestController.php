<?php

class RequestController {
    public static function getEscapedHTMLPost($post_key) {
        return self::escapeHTML($_POST[$post_key]);
    }
    public static function getCleanPost($post_key) {
        return self::clean($_POST[$post_key]);
    }

    private static function escapeHTML($string) {
        $escaped_string = htmlspecialchars($string, ENT_HTML5);
        return $escaped_string;
    }
    private static function clean($string) {
        $taggless = strip_tags($string);
        $trimmed = trim($taggless);
        return $trimmed;
    }
}