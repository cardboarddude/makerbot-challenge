<?php
return array(
"PROJECT_NAME"=>"Makerbot Challenge",
"URI"=>'http://'.$_SERVER['HTTP_HOST'].'/projects/makerbot-challenge/',
"PATH_PROJECT"=>'/projects/makerbot-challenge/',
"PATH_VIEW" => "app/view/",
"PATH_CONTROLLER" => "app/controller/",
"PATH_MODEL" => "app/model/",
"PATH_TEMPLATE" => "_template/",
// TODO: PATH_CLASS is temporary until Config::getPath($file_name) is built
"PATH_CLASS" => array("LoginView"=>"app/view/",
                      "IndexView"=>"app/view/",
                      "RegistrationView"=>"app/view/",
                      "View"=>"app/view/",

                      "LoginModel"=>"app/model/",
                      "IndexModel"=>"app/model/",
                      "RegistrationModel"=>"app/model/",

                      "RequestController"=>"app/controller/",
                      "LoginController"=>"app/controller/",
                      "RegistrationController"=>"app/controller/",

                      "Feedback"=>"app/core/",
                      "Query"=>"app/core/",
                      "QueryFactory"=>"app/core/",
                      "SQLiteDB"=>"app/core/",
                      "User"=>"app/core/"
                      ),

"DB_NAME"=>"makerbot-challenge",
"PATH_DB"=>"",

"USER_CONST"=>array("username"=>array("regex_validation"=>'#^[[:alnum:]\x2e\x2d\x5f]{4,72}$#',
                                      "syntax_rules"=>array("Alphanumeric characters",
                                                            "Symbols: period (.), underscore (_), or dash (-)",
                                                            "Between 4 and 72 characters")
                                      ),
                    "email"=>array("regex_validation"=>
/* Source: http://emailregex.com/ General Email Regex (RFC 5322 Official Standard) */
'#(?:[a-z0-9!\#$%&\'*+/=?^_`{|}~-]+(?:\\.[a-z0-9!\#$%&\'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\\])#'
                            )
                   )


);