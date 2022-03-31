<?php
    /**
     * QR Code + Logo Generator
     *
     * http://labs.nticompassinc.com
     */
    $data = $transaction_narration;
    $size = '180x180';
    $logo = 'img/logo.png';


    header('Content-type: image/png');
    // Get QR Code image from Google Chart API
    // http://code.google.com/apis/chart/infographics/docs/qr_codes.html
    $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
    if($logo !== FALSE){
        $logo = imagecreatefromstring(file_get_contents($logo));

        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);

        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);

        // Scale logo to fit in the QR Code
        $logo_qr_width = $QR_width/3;
        $scale = $logo_width/$logo_qr_width;
        $logo_qr_height = $logo_height/$scale;

        imagecopyresampled($QR, $logo, $QR_width/3, $QR_height/3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

    }
    //imagepng($QR, 'qrcode.png');
    // Ouput image in the browser
    //echo '<img src="../qrcode.png">';

    ob_start();
    imagepng($QR);
    $QR = ob_get_contents();
    ob_end_clean();
    echo '<img src="data:image/png;base64,'.base64_encode($QR).'" class="mx-auto d-block" style=" width: 200px; border-radius: 20px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border: 4px solid #2374e1; "/>';

    imagedestroy($QR);

  ?>