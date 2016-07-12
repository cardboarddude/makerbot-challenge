$(document).ready(function () {
    $main_menu_items = $('#main-menu li');

    $main_menu_items.on('click', function ($event) {
        $menu_item_action = $event.target.id.substring(('main-menu-').length);
        $('<form action="?page=' + $menu_item_action + '" method="POST"/>').submit();
    });
});