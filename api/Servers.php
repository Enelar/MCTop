<?php

class Servers extends API
{

  protected function reserve($page = 0)
  {
    $page = (int)$page;
    if($page < 0)
      return ['error' => 'Хакер, уровень: mctop v.1'];

    $res = Core::get_db()->Query('select * from main.servers where active = 1 order by votes desc limit 10 offset $1', [$page*10]);
    $servers_count = Core::get_db()->Query('select count (*) from main.servers where active = 1', [], true);
 
    return [
        "design" => "rating/servers_list",
        "data"   => [
            "servers" => $res,
            'projects_count' => $servers_count['count'],
            'current_page' => $page
        ],
    ];
  }

  protected function subscribe_page($id)
  {
    $server_info = $this->info($id);
 
    return
    [
      'design' => 'rating/server/subscribe_page',
      'data' => 
      [
        'info' => $server_info['data']['info']
      ]
    ];
  }

  protected function subscribe_page_change($id)
  {
    $server_info = $this->info($id);
 
    return
    [
      'design' => 'rating/server/subscribe_page_change',
      'data' => 
      [
        'info' => $server_info['data']['info']
      ]
    ];
  }

  protected function subscribe($nickname, $server_id)
  {
    $this->addons['design'] = 'main/utils/goback';
    if (!strlen($nickname))
      return $this->unsubscribe(); // не знаю зачем здесь но ок

    $uid = LoadModule('api', 'Users')->uid();
    $trans = Core::get_db()->Begin();
    // Дерьмово, но я не хочу морочить тебе голову с условной блокировкой
    if ($subscr = $this->is_server_subscriber($server_id))
    {
      // Хотя здесь напрашивается конечно блин
      if ($subscr == $nickname)
        return $trans->Rollback() || true; // подписка успешна ранее
      $query = "UPDATE main.servers_subscribers SET nickname=$3 WHERE server_id = $1 AND user_id=$2";
    }
    else
      $query = "INSERT INTO main.servers_subscribers(server_id, user_id, nickname) VALUES ($1, $2, $3)";

    $res = Core::get_db()->Query("{$query} RETURNING *",
          [ $server_id, $uid, $nickname], true);

    return $trans->Finish(count($res));
  }

  protected function is_server_subscriber($server, $uid = null)
  {
    if (!$uid)
      $uid = LoadModule('api', 'Users')->uid();
    $check = 
      Core::get_db()->Query("
        select *
          from main.servers_subscribers
          where user_id = $1
            and server_id = $2",
      [$uid, $server], true);
    if ($check())
      return $check->nickname;
    return false;
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
    $server_info = Core::get_db()->Query("select * from main.servers WHERE id=$1", [$server_id], true);
 
    return
    [
        "design" => "rating/server/info",
        "data" => [
          "info" => $server_info,
          "project" => LoadModule('api', 'Projects')->info($server_info->project),
        ],
    ];
  }

  protected function vote($server_id)
  {
    $votes = LoadModule('api', 'Votes');
    return $votes->Vote($server_id);
  }

  protected function vote_page($id)
  {
    $server_info = LoadModule('api', 'Servers')->info($id);
    return 
    [
        'design' => 'rating/server/vote',
        'data' => [
            'info' => $server_info,
        ]
    ];    
  }

  protected function version($id)
  {
        $server_version = Core::get_db()->Query('select * from main.servers_versions where id = $1', [$id], true);
        return
        [
            "design" => "rating/server/version",
            "data" => ["version" => $server_version],
        ];
  }

    protected function update($id)
    {
        global $_POST;

        $tags = explode(',', $_POST['tags']);
        $tags_in_string = '';
        foreach ($tags as $tag)
        {
            $tags_in_string .= ':'.$tag.': ';
        }

        Core::get_db()->Query("
            update main.servers set
            port = $2,
            address =$3,
            version_id = $4,
            name = $5,
            description = $6,
            features = $7,
            map_url = $8,
            video_trailer_url = $9,
            whitelist = $10,
            license_type = $11,
            client_type = $12,
            tags = $13
            where id = $1
        ", [
            $id,
            $_POST['port'],
            $_POST['address'],
            $_POST['version_id'],
            $_POST['name'],
            $_POST['description'],
            $_POST['features'],
            $_POST['map_url'],
            $_POST['video_trailer_url'],
            $_POST['whitelist'],
            $_POST['license'],
            $_POST['client_type'],
            $tags_in_string
        ]);
    }


}