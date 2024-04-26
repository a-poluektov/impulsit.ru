<?php
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader; 

Loader::includeModule("highloadblock"); 

use Bitrix\Highloadblock as HL; 
use Bitrix\Main\Entity;

$token = "013a7f66e8ab2ce18687d7869dff9f84a2752128";
$dadata = new \Dadata\DadataClient($token, null);

//проверяем на наличие IP адреса в POST
if(!empty($_POST['ip'])){
    $ip = trim($_POST['ip']); //удаляем пробелы
    $response = array();

    //проверка IP адреса на валидность
    if(!filter_var($ip, FILTER_VALIDATE_IP)){
        $response = [
            'status' => 'error',
            'message' => 'This IP address is not valid. Please check your IP address to ensure it is entered correctly.'
        ];

        exit(json_encode($response));
    }

    $hlblock = HL\HighloadBlockTable::getList([
        'filter' => ['TABLE_NAME' => 'geoip_table']
    ])->fetch();

    if($hlblock){
        $entity = HL\HighloadBlockTable::compileEntity($hlblock); 
        $entity_data_class = $entity->getDataClass(); 
    }

    //проверяем есть ли присланный IP адрес в hl блоке
    $rsData = $entity_data_class::getList(array(
        "select" => array("*"),
        "order" => array("ID" => "ASC"),
        "filter" => array("UF_IP" => $ip)  // Задаем параметры фильтра выборки
    ));

    $arDataFetched = array();

    while($arData = $rsData->Fetch()){
        $arDataFetched = $arData;
    }

    //если ip адрес нашелся, возвращаем данные из hl блока
    if(!empty($arDataFetched)){
        $arDataFetchedClear = htmlspecialchars_decode($arDataFetched['UF_JSON']);
        $response = [
            'status' => 'ok',
            'data' => json_decode($arDataFetchedClear),
            'message' => 'Data from Highload block'
        ];

        exit(json_encode($response));
    }

    //если не нашелся, делаем запрос к API и добавляем данные в hl блок
    else{
        $dadata_result = $dadata->iplocate($ip);

        //проверяем вернулся ли массив из API
        if($dadata_result != null){

            // Массив полей для добавления
            $data = array(
                "UF_IP" => $_POST['ip'],
                "UF_DATE" => date("d.m.Y"),
                "UF_JSON" => json_encode($dadata_result)
            );

            $result = $entity_data_class::add($data);

            //если данные добавлены, возвращаем данные, полученные из API
            if($result->isSuccess()){                    
                $response = [
                    'status' => 'ok',
                    'data' => $dadata_result,
                    'message' => 'Data from Dadata API'
                ];

                exit(json_encode($response));
            } 

            //если не добавлено, выводим данные об ошибке
            else{
                $errors = $result->getErrorMessages(); // получаем сообщения об ошибках
                $response = [
                    'status' => 'error',
                    'errors' => $errors
                ];

                exit(json_encode($response));
            }
        }
        
        //если не вернулся, возвращаем сообщение об ошибке
        else{
            $response = [
                'status' => 'error',
                'message' => 'This IP address does not exist or the service could not find data for this address. Please check your IP address to ensure it is entered correctly.'
            ];

            exit(json_encode($response));
        }
    }
}else{
    $response = [
        'status' => 'error',
        'message' => 'IP is not accepted'
    ];

    exit(json_encode($response));
}

// $ip = "178.204.27.167"; //Тест IP Казань
// $ip = "89.250.166.111";  //Тест IP Ульяновск