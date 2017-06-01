<?php
/**
 * Created by PhpStorm.
 * User: LJS
 * Date: 2017/5/19
 * Time: 23:24
 */
// 引入youtube类
include 'youtube.class.php';
$youtube = new youtube();
while (1) {
// 从数据库获取is_get_detail为0的数据
//$ytbRes = $youtube->db->select('ytb_channels', 'ytb_id', ['is_get_detail'=>0]);
    $ytbRes = $youtube->db->select('ytb_channels', 'ytb_id', ['AND' => ['is_get_detail' => 0, 'keywords' => ['unboxing', 'reviews', 'gadgets', 'smart tech']]]);
    if (count($ytbRes) == 0) {
        exit;
    }
    foreach ($ytbRes as $k => $v) {
        if (strlen($v) == 24) {
            $url = 'https://www.youtube.com/channel/' . $v . '/about';
            $ytb_type = 'channel';
        } else {
            $url = 'https://www.youtube.com/user/' . $v . '/about';
            $ytb_type = 'user';
        }
        $youtube->init($url);
        $youtubeInfo['ytb_type'] = $ytb_type;
        $youtubeInfo['username'] = $youtube->get_channel_name();
        $youtubeInfo['subscribers'] = $youtube->get_subscribers();
        $youtubeInfo['views'] = $youtube->get_views();
        $youtubeInfo['country'] = $youtube->get_country();
        $youtubeInfo['user_created'] = $youtube->get_join_time();
        $youtubeInfo['user_url'] = $youtube->url;
        $friendLink = $youtube->get_links();
        $youtubeInfo['user_twitter'] = $friendLink['twitter'];
        $youtubeInfo['user_instagram'] = $friendLink['instagram'];
        $youtubeInfo['user_facebook'] = $friendLink['facebook'];
        $youtubeInfo['created'] = time();
        $youtubeInfo['is_get_detail'] = 1;
        $id = $youtube->db->update("ytb_search_channels", $youtubeInfo, ['ytb_id' => $v]);

        $recommendLinks = $youtube->get_recommend_links();
        // 检查是否获取过
        foreach ($recommendLinks as $r_k) {
            $isExist = $youtube->db->select('ytb_channels', 'id', ['ytb_id' => $r_k]);
            if (!$isExist) {
                $ytbRes = $youtube->db->insert('ytb_channels', ['ytb_id' => $r_k]);
            }
        }
    }
}
