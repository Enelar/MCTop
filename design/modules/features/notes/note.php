

    <div class="note" onclick="display_page_with_id('features','notes/note_edit', '<?php echo $redis_key;?>')">

        <div class="name">
            <?php echo substr($note['name'],0,38);?>..
        </div>

        <div class="time">
            <?php echo date('H:i:s (d/m)',$note['time']);?>
        </div>

        <div class="text">
            <?php echo nl2br(substr(htmlspecialchars($note['content'],ENT_QUOTES), 0, 370));?>...
        </div>

    </div>

