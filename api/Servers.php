<?php

class Servers extends API
{
  protected function subscribe($nickname, $server_id)
  {
    if (!strlen($nickname))
      return $this->unsubscribe(); // не знаю зачем здесь но ок

    $uid = LoadModule('api', 'Users')->uid();
    $trans = db::Begin();
    // Дерьмово, но я не хочу морочить тебе голову с условной блокировкой
    if ($subscr = $this->is_server_subscriber($server_id))
    {
      // Хотя здесь напрашивается конечно блин
      if ($subscr['nickname'] == $nickname)
        return $trans->Rollback() || true; // подписка успешна ранее
      $query = "UPDATE main.servers_subscribers SET nickname=$3 WHERE server_id = $1 AND user_id=$2";
    }
    else
      $query = "INSERT INTO main.servers_subscribers(server_id, user_id, nickname) VALUES ($1, $2, $3)"

    $res = Core::$db->Query("{$query} RETURNING *",
          [ $server_id, $uid, $nickname], true);

    return $trans->Finish(count($res));
  }

  private function is_server_subscriber($server, $uid = null)
  {
    if (!$uid)
      $uid = LoadModule('api', 'Users')->uid();
    $check = 
      Core::$db->Query("
        select *
          from main.servers_subscribers
          where user_id = $1
            and server_id = $2",
      [$uid, $server]);
    return $check;
  }

  protected function unsubscribe($server_id)
  {
    $trans = db::Begin();
    phoxy_protected_assert($this->is_server_subscriber($server), ["error" => "You should be subscribed to unsubscribe"]);
    $res = Core::$db->Query("DELETE FROM main.servers_subscribers WHERE user_id=$1 AND server_id=$2 RETURNING *", 
      [LoadModule('api', 'Users')->uid(), $server_id]);
    return $trans->Finish($res);
  }

  public function get_user_nickname_on_server($server_id, $user = null)
  {
    if (!$user)
      $user = LoadModule('api', 'Users')->uid();

    return Core::$db->Query("select nickname from main.servers_subscribers where user_id = $1 and server_id = $2", [$user, $server_id]);
  }

  protected function info($server_id)
  {
    return Core::$db->Query("select * from main.servers WHERE id=$1", [$server_id], true);
  }

  protected function vote($server_id)
  {
    $votes = LoadModule('api', 'Votes');
    return $votes->Vote($server_id);
  }
}