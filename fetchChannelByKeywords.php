<?php
/**
 * Created by PhpStorm.
 * User: LJS
 * Date: 2017/5/31
 * Time: 14:05
 */
// 引入youtube类
include 'youtube.class.php';
$youtube = new youtube();
//初始化youtube首页
$keywords = ['unboxing','reviews','gadgets','smart tech'];
foreach($keywords as $word){
    $i = 0;
    $url = 'https://www.youtube.com/results?search_query='.urlencode($word);
    while($i < 20){
        $youtube->init($url);
        $channelList = $youtube->get_search_chennel();
        // 检查是否获取过
        foreach($channelList as $r_k){
            $isExist = $youtube->db->select('ytb_channels','id',['ytb_id'=>$r_k]);
            if(!$isExist){
                $ytbRes = $youtube->db->insert('ytb_channels',['ytb_id'=>$r_k,'keywords'=>$word]);
            }
        }
        $url = 'https://www.youtube.com/'.$youtube->get_next_url();
        echo $url;
        echo '======';
        $i++;
    }
}

