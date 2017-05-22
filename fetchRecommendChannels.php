<?php
/**
 * Created by PhpStorm.
 * User: LJS
 * Date: 2017/5/21
 * Time: 20:59
 */
// 引入youtube类
include 'youtube.class.php';
$youtube = new youtube();
//初始化youtube首页
//查询出所有的channel
$ytbRes = $youtube->db->select('ytb_channels',['id','user_url'], ['id'=>[119,120,121]]);
foreach($ytbRes as $k => $v){
    $youtube->init($v['user_url']);
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

    $id = $youtube->db->update("ytb_channels", $youtubeInfo, ['id'=>$v['id']]);
}