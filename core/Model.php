<?php
global $settings, $users;

$settings = $_SERVER['DOCUMENT_ROOT']."/core/settings.json";
$users = $_SERVER['DOCUMENT_ROOT']."/core/users.json";

function cfgRead() {
    global $settings;
    return json_decode(file_get_contents($settings), true);
}
function cfgWrite($data) {
    global $settings;
    $cfg = cfgRead();
    foreach ($data as $key => $oneParam){
        $cfg[$key] = $oneParam;
    }
    file_put_contents($settings, json_encode($cfg));
}
function getUidByHash($user_hash){
    global $users;
    $arUsers = $users = json_decode(file_get_contents($users), true);

    foreach ($arUsers as $key=>$oneUser){
        if ($oneUser['hash'] == $user_hash){
            $uid = $key;
            break;
        }
    }
    if (isset($uid) || $uid === 0){
        $result = $uid;
    }
    else{
        $result = false;
    }
    return $result;
}
function pickRandomPrize($user_hash){
    $uid = getUidByHash($user_hash);

    if ($uid != false || $uid==0){
        $cfg = cfgRead();
        // Выбираем случайную сумму денег:
        if ($cfg['moneylimit']>$cfg['lowmoney']){
            $min = $cfg['lowmoney'];
            $max = $cfg['maxmoney']>$cfg['moneylimit'] ? $cfg['moneylimit'] : $cfg['maxmoney']; // проверка если максимальный лимит менее оставшейся суммы тогда максимальным лимитом считать всю сумму
            $prizes['money'] = random_int($min, $max);
        }
        // Выбираем виртулаьные баллы
        $prizes['bonus'] = random_int($cfg['lowbonus'], $cfg['maxbonus']);
        //Выбираем физический приз
        foreach ($cfg['prizes'] as $key=>$onePrize){
            if ($onePrize['quantity']>0){ // проверяем на наличие
                $fiz[]=$onePrize;
            }
        }

        $fizsumm = count($fiz);
        if ($fizsumm>0){
            $prizes['prize'] = $fiz[array_rand($fiz)]['name'];
            /*if ($fizsumm == 1){
                $prizes['prize'] = $fiz[0]['name'];
            }
            else{
                $fiznum=random_int(1, count($fiz)); //число завышено на 1
                $prizes['prize'] = $fiz[$fiznum-1]['name'];
            }*/
        }

        // выберем из имеющегося списка
        $key = array_rand($prizes);
        $result = 'Вы выиграли '.$key.':'.$prizes[$key];
    }
    else{
        $result = ['error'=>'no user found by hash'];
    }
    return $result;
}