

    <?php $album = new Photos('get_all_photos_from_album:'.$_GET['id']);?>
    <h1>Альбом <?php echo $album->name;?></h1><hr>