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
    $i = 2;
    $url = 'https://www.youtube.com/results?search_query='.urlencode($word);
    while($i < 35){
        $youtube->init($url);
        $channelList = $youtube->get_search_channel();
//         检查是否获取过
        foreach($channelList as $r_k => $r_v){
            $isExist = $youtube->db->select('ytb_search_channels','id',['ytb_id'=>$r_v['ytb_id']]);
            if(!$isExist){
                $ytbRes = $youtube->db->insert('ytb_search_channels',['ytb_id'=>$r_v['ytb_id'],'keywords'=>$word,'search_video_url'=>$r_v['url']]);
            }
        }
        $url = 'https://www.youtube.com/results?q=unboxing&page='.$i;
        echo $url;
        echo chr(10);
        $i++;
    }
}

