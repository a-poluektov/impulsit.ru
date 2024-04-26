<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Демо");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Демо");
?> 

<canvas id="space"></canvas>

<div class="container">
    <div class="geoip-wrapper">
        <?$APPLICATION->IncludeComponent(
            "impulse:geoip", "custom",
            Array(
            ),
            false
        );?>
    </div>
</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>