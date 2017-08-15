<?php
require_once __DIR__ . '/../autoload.php';

use redPackets\redPackets;

testDemo(100, 100);

function testDemo($money, $size){
    $redPackets = new redPackets();

    $info = $redPackets->setBasicsMoney(1)
        ->setRemainMoney($money)
        ->setRemainSize($size)
        ->run();
    $info = json_decode($info, true);

    if(!isset($info['info']['remainMoney'])){
        return;
    } else {
        var_dump('钱数：' . $info['info']['remainMoney'] . ' | 剩余个数' . $info['info']['remainSize']);
        testDemo($info['info']['remainMoney'], $info['info']['remainSize']);
    }

}
