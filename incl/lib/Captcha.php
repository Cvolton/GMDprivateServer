<?php

class Captcha {

	public static function displayCaptcha($vis = '') {
		include __DIR__ . "/../../config/security.php";
		if($enableCaptcha){
			echo "<script src='https://js.hCaptcha.com/1/api.js' async defer></script>";
			if($vis == "no") {
				$vis = 'style="display:none"';
				$very = 'very';
			}
			echo "<div class=\"h-captcha\" $vis id=\"".$very."coolcaptcha\" data-sitekey=\"${hCaptchaKey}\" data-theme='dark' style='border-width: 0px !important;border-radius: 20px !important;'></div>";
		}
	}

	public static function validateCaptcha() {
		include __DIR__ . "/../../config/security.php";
		if(!$enableCaptcha)
			return true;
		
		$data = array(
            'secret' => $hCaptchaSecret,
            'response' => $_POST['h-captcha-response']
        );
		$verify = curl_init();
		curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
		curl_setopt($verify, CURLOPT_POST, true);
		curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($verify, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		$response = curl_exec($verify);
		$responseData = json_decode($response);
		return $responseData->success;
	}

}