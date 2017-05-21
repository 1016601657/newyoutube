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
//初始化youtube首页
$youtube->init('https://www.youtube.com');
//在youtube首页随机获取一个channel
while(1){
    $ytb_id = $youtube->get_rand_channel();
    var_dump($ytb_id);
    $ytbRes = $youtube->db->insert('ytb_channels',['ytb_id'=>$ytb_id]);
    var_dump($ytbRes);
}
