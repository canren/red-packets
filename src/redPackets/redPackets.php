<?php

namespace redPackets;

use Exception;

/**
 * Created by PhpStorm.
 * User: canren
 * Date: 17-8-14
 * Time: 下午3:56
 */
class redPackets
{
    //兜底钱数，起码为1,单位是分
    public $basicsMoney = 1;

    //剩余红包个数
    public $remainSize;

    //剩余红包钱数,单位是分
    public $remainMoney;

    /**
     * 红包代码
     * redPackets constructor.
     */
    function run()
    {
        try {

            //红包总个数
            if (0 >= $this->remainSize) {
                throw new Exception('{"isError":1, "message":"红包个数应该大于0个"}');
            }

            //判断红包金额是否比红包个数大
            if ($this->remainSize > $this->remainMoney || $this->remainMoney < $this->basicsMoney * $this->remainSize) {
                throw new Exception('{"isError":1, "message":"红包金额应该比红包个数多"}');
            }

            //红包个数
            $remainSize = $this->remainSize - 1;
            //封顶红包
            $max = ($this->remainMoney - $this->basicsMoney) / $this->remainSize * 2;
            //随机取红包钱数
            $money = intval(rand(0, 100) * $max / 100);
            //随机取红包钱数+加上保底红包
            $money += $this->basicsMoney;
            $money = 0 == $remainSize ? $this->remainMoney : $money;
            //剩余钱数 （红包个数为0时 剩余钱数直接分配）
            $remainMoney = 0 == $remainSize ? 0 : $this->remainMoney - $money;

            //红包
            $result = [
                'isError' => 0,
                'info' => [
                    'remainSize' => $remainSize, //红包剩余个数
                    'remainMoney' => $remainMoney, //红包剩余钱数
                    'redPacketsMoney' => $money //当前红包个数
                ]
            ];

            return json_encode($result);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * 初始化红包
     * @param $basicsMoney
     * @param $money
     * @param $size
     * @param array $redPacketsMoney
     * @return array
     */
    public function redPacketsInit($basicsMoney, $money, $size, &$redPacketsMoney = [])
    {
        $redPackets = new redPackets();

        $info = $redPackets->setBasicsMoney($basicsMoney)
            ->setRemainMoney($money)
            ->setRemainSize($size)
            ->run();

        $info = json_decode($info, true);

        $redPacketsMoney[] = $info['info']['redPacketsMoney'];

        if (0 != $info['info']['remainSize']) {

            $this->redPacketsInit($basicsMoney, $info['info']['remainMoney'], $info['info']['remainSize'], $redPacketsMoney);

        }

        return $redPacketsMoney;
    }

    /**
     * 设置红包最少钱数 单位是分
     * @param $basicsMoneyMoney 最少钱数 默认为1分 大于0
     * @return $this
     */
    public function setBasicsMoney($basicsMoney)
    {
        $this->basicsMoney = $basicsMoney ? intval($basicsMoney) : $this->basicsMoney;
        return $this;
    }

    /**
     * 剩余红包个数
     * @param $remainSize 剩余红包个数
     * @return $this
     */
    public function setRemainSize($remainSize)
    {
        $this->remainSize = intval($remainSize);
        return $this;
    }

    /**
     * 剩余红包钱数
     * @param $remainSize 剩余红包钱数
     * @return $this
     */
    public function setRemainMoney($remainMoney)
    {
        $this->remainMoney = intval($remainMoney);
        return $this;
    }
}