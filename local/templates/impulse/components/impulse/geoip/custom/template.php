<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(!empty($_SERVER['REMOTE_ADDR'])):?>
    <h1>Find out where a person is located by IP address</h1>
    <div class="hello-user">
        Your IP is <?=$_SERVER['REMOTE_ADDR']?>
    </div>
    <div class="geoip-form mt-5">
        <form class="row g-3">
            <div class="form-row">
                <input type="text" id="inputIP" class="form-control form-control-lg" aria-describedby="ipHelpBlock" 
                placeholder="Type IP adress here">
                <button id="ip_send" class="btn btn-primary btn-lg" type="button">Check</button>
            </div>
            <textarea id="geoip_result"></textarea>
            <span id="data_from"></span>
        </form>
    </div>
<?endif;?>