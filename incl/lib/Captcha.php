<?php
class Captcha {

	public static function displayCaptcha($vis = '') {
		include __DIR__ . "/../../config/security.php";
		if ($enableCaptcha) {
			if ($vis == "no") {
				$vis = 'style="display:none"';
				$very = 'very';
			}
			if ($captchaType == 1) {
				echo "<script src='https://js.hCaptcha.com/1/api.js' id='captchascript' async defer></script>";
				echo "<div class=\"h-captcha\" $vis id=\"" . $very . "coolcaptcha\" data-sitekey=\"${CaptchaKey}\" data-theme='dark' style='border-width: 0px !important;border-radius: 20px !important;'></div>";
			} elseif ($captchaType == 2) {
				echo "<script src='https://www.google.com/recaptcha/api.js' id='captchascript' async defer></script>";
				echo "<div class=\"g-recaptcha\" $vis id=\"" . $very . "coolcaptcha\" data-sitekey=\"${CaptchaKey}\" data-theme='dark'></div>";
			} elseif ($captchaType == 3) {
				echo "<script src='https://challenges.cloudflare.com/turnstile/v0/api.js' id='captchascript' async defer></script>";
				echo "<div class=\"cf-turnstile\" $vis id=\"" . $very . "coolcaptcha\" data-sitekey=\"${CaptchaKey}\" data-theme='dark' data-callback=\"javascriptCallback\"></div>";
			}
		}
	}

	public static function validateCaptcha() {
		include __DIR__ . "/../../config/security.php";
		if (!$enableCaptcha) {
			return true;
		}
		if ($captchaType == 1) {
			$url = "https://hcaptcha.com/siteverify";
			 $req = isset($_POST['h-captcha-response']) ? $_POST['h-captcha-response'] : null;
		} elseif ($captchaType == 2) {
			$url = "https://www.google.com/recaptcha/api/siteverify";
			$req = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : null;
		} elseif ($captchaType == 3) {
			$url = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
			$req = isset($_POST['cf-turnstile-response']) ? $_POST['cf-turnstile-response'] : null;
		} else {
			return false; // Add this line to handle invalid captchaType
		}

		$data = array(
			'secret' => $CaptchaSecret,
			'response' => $req
		);

		$verify = curl_init();
		curl_setopt($verify, CURLOPT_URL, $url);
		curl_setopt($verify, CURLOPT_POST, true);
		curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($verify, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		$response = curl_exec($verify);
		$responseData = json_decode($response);
		return $responseData->success;
	}
}
