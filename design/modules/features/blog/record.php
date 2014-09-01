

<div class="record" id="post_<?php echo $post->id?>">

    <div class="time">
        <?php echo date('H:i:s (d/m)',$post->time);?>
    </div>

    <?php if(Core::get_current_user_profile()->id == $blog_user_profile->id):?>
        <div class="btn_delete" onclick="blog_post_delete('<?php echo $post->id;?>', '<?php echo Core::get_current_user_profile()->id?>')">
            <a class="btn-sm btn-danger">Удалить</a>
        </div>
    <?php endif;?>

    <div class="text">
        <?php echo nl2br(($post->content));?>
    </div>

</div>