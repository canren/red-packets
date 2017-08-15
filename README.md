使用方法

红包预先生成

redPacketsInit (参数1, 参数2, 参数3)

参数1 设置兜底的红包金额

参数2 设置红包的钱数

参数3 设置红包的个数

```
    $redPackets = new redPackets;
    $redPackets->redPacketsInit(1, 10, 5);

```

单个红包生成

setBasicsMoney 设置兜底的红包金额

setRemainMoney 设置红包的钱数

setRemainSize 设置红包的个数

```
    $redPackets = new redPackets;
    $redPackets->setBasicsMoney(1)
        ->setRemainMoney(1)
        ->setRemainSize(1)
        ->run();
```

代码测试

```

    $redPackets = new redPackets;
    while(true){
        $redPacketsData = $redPackets->redPacketsInit(1, 20000, 200);
        if (!isset($redPacketsData[199])) {
            var_dump($redPacketsData);
            die();
        }
    }

```

