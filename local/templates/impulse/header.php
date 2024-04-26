<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;

$curPage = $APPLICATION->GetCurPage(true);
$APPLICATION->ShowPanel();

?>

<!DOCTYPE html>
<html lang="<?= LANGUAGE_ID ?>">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
    // JS libraries
    Asset::getInstance()->addJs("https://code.jquery.com/jquery-3.7.1.min.js");
    Asset::getInstance()->addJs("https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js");
    Asset::getInstance()->addJs("/local/static/js/stars.js");
    Asset::getInstance()->addJs("/local/static/js/custom.js");

    // CSS libraries
    Asset::getInstance()->addCss("https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css");
    Asset::getInstance()->addCss("/local/static/css/custom.css");


    $APPLICATION->ShowHead();
    CJSCore::Init(array("fx"));

    ?>

    <title><?php $APPLICATION->ShowTitle(); ?></title>
</head>

<div class="wrapper" id="bx_eshop_wrap">
	<header class="header">

    <!-- ЗДЕСЬ МОГЛА БЫТЬ ВАША РЕКЛАМА -->

	</header>

	<div class="workarea">