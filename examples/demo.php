<?php
require_once __DIR__ . '/../autoload.php';

use redPackets\redPackets;

$redPackets = new redPackets;

$redPacketsData = $redPackets->redPacketsInit(1, 200000, 200);

