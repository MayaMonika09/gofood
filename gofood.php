<?php 
include 'curl.php';
function headers($token = null) {
	$huruf = '0123456789ABCDEFGHIJKLMOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    	$uniq = '';
    	for ($i = 0; $i < 16; $i++) {
        $uniq .= $huruf[mt_rand(0, strlen($huruf) - 1)];
    	}

    if  ($token != "") {

        $headers = array(
        'Accept: application/json',
        'X-Session-ID: 28667f0c-80e8-43db-9ab4-c6d411f00a86',
        'X-AppVersion: 3.39.1',
        'X-AppId: com.gojek.app',
        'X-Platform: Android',
        'X-UniqueId: '.$uniq,
        'D1: 41:ED:AC:6E:29:0D:B2:24:C4:89:42:02:4D:C5:0F:33:72:DC:D1:9D:14:68:45:AD:84:9C:74:6E:3F:0E:8D:4C',
        'Authorization: Bearer '.$token,
        'X-DeviceOS: Android,8.1.0',
        'User-uuid: 654547255d',
        'X-DeviceToken: dTmJ6tjtkoE:APA91bGxQ4LePlAcxfk5s8UKuohf-M27J7qIUfYmjEbg47BhMOozw9yC7hbg7c0nHCSMMxxF_FS2m7-_fe27a_XUVwXWVV4wPEfZuelTH2x0OFLS6CQEil8c3SFGNLPjXCYLTQ-hZirW',
        'X-PushTokenType: FCM',
        'X-PhoneModel: xiaomi,Redmi 6',
        'Accept-Language: id-ID',
        'X-User-Locale: id_ID',
        'X-Location: -6.9212751658159934,107.62244586389556',
        'X-Location-Accuracy: 0.1',
        'X-M1: 1:__b7d2f5195e984b97943895084f44d115,2:c71b9b0b7d24,3:1571508895362-7518963721879435750,4:24519,5:mt6765|2001|8,6:0C:98:38:CB:1A:87,7:"XLGO-83C6",8:720x1344,9:passive\,network\,gps,10:0,11:sHLp9psghlEJimfsIzXKhptQnGhigYRUifllHhizjNg=',
        'Content-Type: application/json; charset=UTF-8',
        'Host: api.gojekapi.com',
        'User-Agent: okhttp/3.12.1'
        );

        return $headers;

    } else {

        $headers = array(
        'Accept: application/json',
        'D1: 41:ED:AC:6E:29:0D:B2:24:C4:89:42:02:4D:C5:0F:33:72:DC:D1:9D:14:68:45:AD:84:9C:74:6E:3F:0E:8D:4C',
        'X-Session-ID: 28667f0c-80e8-43db-9ab4-c6d411f00a86',
        'X-AppVersion: 3.39.1',
        'X-AppId: com.gojek.app',
        'X-Platform: Android',
        'X-UniqueId: '.$uniq,
        'Authorization: Bearer ',
        'X-DeviceOS: Android,8.1.0',
        'User-uuid: ',
        'X-DeviceToken: dTmJ6tjtkoE:APA91bGxQ4LePlAcxfk5s8UKuohf-M27J7qIUfYmjEbg47BhMOozw9yC7hbg7c0nHCSMMxxF_FS2m7-_fe27a_XUVwXWVV4wPEfZuelTH2x0OFLS6CQEil8c3SFGNLPjXCYLTQ-hZirW',
        'X-PushTokenType: FCM',
        'X-PhoneModel: xiaomi,Redmi 6',
        'Accept-Language: id-ID',
        'X-User-Locale: id_ID',
        'X-M1: 1:__b7d2f5195e984b97943895084f44d115,2:c71b9b0b7d24,3:1571508895362-7518963721879435750,4:24519,5:mt6765|2001|8,6:0C:98:38:CB:1A:87,7:"XLGO-83C6",8:720x1344,9:passive\,network\,gps,10:0,11:sHLp9psghlEJimfsIzXKhptQnGhigYRUifllHhizjNg=',
        'Content-Type: application/json; charset=UTF-8',
        'Host: api.gojekapi.com',
        'User-Agent: okhttp/3.12.1'
        );

        return $headers; 

    }

}

function register_gojek() {
     $fakename = curl('https://fakenametool.net/random-name-generator/random/id_ID/indonesia/1');
     preg_match('/<span>(.*?)<\/span>/s', $fakename, $name);
     $email = strtolower(str_replace(' ',  '', $name[1])).rand(0000,1111).'@gmail.com';

     echo "Nomor  : ";
     $phone = trim(fgets(STDIN));
     $register = curl('https://api.gojekapi.com/v5/customers', '{"email":"'.$email.'","name":"'.$name[1].'","phone":"+'.$phone.'","signed_up_country":"ID"}', headers());

    if (stripos($register, '"success":true')) {
        $otp_token = fetch_value($register,  '"otp_token":"', '"');
        echo "Otp : ";
        $otp_code = trim(fgets(STDIN));

        $verify = curl('https://api.gojekapi.com/v5/customers/phone/verify', '{"client_name":"gojek:cons:android","client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e","data":{"otp":"'.$otp_code.'","otp_token":"'.$otp_token.'"}}', headers());

        if (stripos($verify, '"access_token"')) {
            $access_token = fetch_value($verify, '"access_token":"','"');
            
                  $claim = curl('https://api.gojekapi.com/go-promotions/v1/promotions/enrollments', '{"promo_code":"GOFOODBOBA07"}', headers($access_token));
                  echo "\nAuthorization: Bearer : ".$access_token;
                  echo "\n\nMencoba Redem Voucher";
                    for ($i=0; $i < 3 ; $i++) { 
                        sleep(1);
                        echo ".";
                    }
                    echo "\n";
                    sleep(3);
                    if (stripos($claim, '"success":true')) {
                        echo "Berhasil Claim Kak? Selamat Makan\n";
                    } else {
                        echo "Cie Gagal Redem Ga Jadi Makan\n";
                }

            } else { 
                echo "Promo tidak ditemukan\n";
            }
    } else {
        echo "Gagal mendaftar No HP / Email Sudah Terdaftar\n";
    }

}

```````         ``````        `````    ``````      ``````     `````
           
echo           /NMMMMMMMMMMs  -mMMMMMMMMMMh`.dMMMMMMMMMMMMMMMMMMN:/NMMMMMMMMMmMMMMMMMMN+
echo          .NMMMMMMMMMMMM: dMMMMMMMMMMMMshMMMMMMMMMMMMMMMMMMMMNNMMMMMMMMMMMMMMMMMMMMM-
echo          +MMMMMMMMMMMMMh:MMMMMMMMMMMMMNMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMy
echo          sMMMM+++++dMMMMhMMMMo++++hMMMMMMMMs+++mMMMMd++++NMMMMMMN++++mMMMMMs+++mMMMN`
echo          sMMMM     /MMMMMMMMd     oMMMMMMMN    +MMMMN.   sMMMMMM+   -MMMMMN    +MMMM+
echo          sMMMM     `NMMMMMMM+     oMMMMMMMs    `MMMMMy   .NMMMMN`   hMMMMMs    `MMMMd
echo          sMMMM      sMMMMMMM`     oMMMMMMM.     yMMMMM-   sMMMMo   :MMMMMM.     yMMMM-
echo          sMMMM      -MMMMMMh      oMMMMMMh      :MMMMMh   .MMMN`   mMMMMMh      :MMMMy
echo          sMMMM   .   mMMMMM:  .   oMMMMMM/   /   mMMMMM:   sMMo   +MMMMMM/   /   mMMMN`
echo          sMMMM   :.  +MMMMN   o   oMMMMMN   :d   +MMMMMm   .MN`  `NMMMMMN   :d   +MMMM+
echo          sMMMM   :s  `MMMMs  `h   oMMMMMs   yM.  `MMMMMM+   so   oMMMMMMs   yM.  `MMMMm
echo          sMMMM   -N   hMMM.  +h   oMMMMM.  `NMo   yMMMMMN`  .`  .NMMMMMM.  `NMo   yMMMM-
echo
echo          sMMMM   .Mh   NM+  -My   oMMMM/   hMMM-   mMMMMMN.    -MMMMMMM/   hMMM-   mMMMN`
echo          sMMMM   `MM.  sN`  yMs   oMMMN`  `hddd+   +MMMMMMy    hMMMMMMN`  `hddd+   +MMMM+
echo          sMMMM   `MMo  -y  `NMo   oMMMs    ````    `NMMMMMN    MMMMMMMs    ````    `NMMMm
echo          sMMMM    MMm   .  +MMo   oMMM.             yMMMMMN    MMMMMMM.             yMMMM-
echo          sMMMM    MMM:     dMMo   oMMh   `------.   -MMMMMN    MMMMMMh   `------.   -MMMMy
echo          sMMMM    MMMy    -MMMo   oMM/   oNNNNNNN`   mMMMMN    MMMMMM/   oNNNNNNN`   mMMMN`
echo          sMMMM    MMMN`   sMMMo   oMN`   mMMMMMMM/   +MMMMN    MMMMMN`   mMMMMMMM/   +MMMM+
echo          sMMMM    MMMM+  `NMMMo   oMs   -MMMMMMMMh   `NMMMN    MMMMMs   -MMMMMMMMh   `NMMMd
echo          sMMMM++++MMMMm++sMMMMh+++hMs+++hMMMMMMMMM++++mMMMN++++MMMMMs+++hMMMMMMMMM++++mMMMN
echo
echo
echo
echo            -ydmmmmdy/ymmmmdo+dmmmmmmmmmmmh/    .sdmmmmmh+ymmmmmdy:sdmmmmmh/    .sdmmmmmh/`
echo "Nabila Tools - Gojek Register + Claim GoFood\n";
echo "Thanks To : Alone & Maya \n";
register_gojek();

?> 