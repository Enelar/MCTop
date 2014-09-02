
   Просмотров страниц: <?php echo Core::$redis_db->incr('page_views'.date('d/m/y',time())). ' <br> [за '.date('d/m/y',time()).']';?> <hr>
   <?php echo Core::get_settings()->engine['name'];?>