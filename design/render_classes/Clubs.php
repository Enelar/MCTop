<?php

class Clubs_render_class
{
    static function render_invitations_notifier()
    {
        $count = Clubs::get_current_user_invitations_count();
        if ($count > 0)
            echo '<div class="notifications_section" onclick="display_page(\'social\',\'clubs/index\')">Клубы: <span onclick="display_page(\'social\',\'clubs/invites\')" class="badge">+<div id="clubs_invites_count">' . $count . '</div></span></div>';
    }
}