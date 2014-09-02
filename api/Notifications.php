<?php

class Notifications extends Im
{
    function send_notification()
    {
        $this->comet_server->send_to_pipe("user_" . $_POST['to'] . "_notifications", 'a_new_message', [
            'from' => $_POST['title'],
            'to' => 'You',
            'title' => $_POST['title'],
            'message' => $_POST['message']
        ]);
        return [
            'result' => 'message_had_sent'
        ];
    }
}
