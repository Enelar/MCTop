
    <h1><span class="<?php echo Core::get_settings()->modules['chat']->icon?>"></span> Chat@MCTop</h1><hr>

    <script>
        function send_message()
        {
            CometServer().web_pipe_send("mctop_chat", "event_name", "message");
        }
    </script>

    <form role="form" action="javascript:void(null);" onsubmit="send_message()">
        <div class="form-group">
            <label for="message_input_box">Сообщение</label>
            <textarea id="message_input_box" class="form-control" rows="3"></textarea>
        </div>
        <input type="submit" class="btn btn-default" value="send">
    </form>