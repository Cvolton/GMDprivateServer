<?php
require_once __DIR__ . "/ip_in_range.php";
class ipCheck {
	public function ipv4inrange($ip, $range) {
		return ipInRange::ipv4_in_range($ip, $range);
	}
    public static function ip2long6($ip) {
        return ipInRange::ip2long6($ip, $range);
    }
    public static function ipv6_in_range($ip, $range_ip) {
        return ipInRange::ipv6_in_range($ip, $range_ip);
    }
	public function isCloudFlareIP($ip) {
    	$cf_ipv4s = array(
			'173.245.48.0/20',
			'103.21.244.0/22',
			'103.22.200.0/22',
			'103.31.4.0/22',
			'141.101.64.0/18',
			'108.162.192.0/18',
			'190.93.240.0/20',
			'188.114.96.0/20',
			'197.234.240.0/22',
			'198.41.128.0/17',
			'162.158.0.0/15',
			'104.16.0.0/13',
			'104.24.0.0/14',
			'172.64.0.0/13',
			'131.0.72.0/22'
	    );
    	$cf_ipv6s = array(
			'2400:cb00::/32',
			'2606:4700::/32',
			'2803:f800::/32',
			'2405:b500::/32',
			'2405:8100::/32',
			'2a06:98c0::/29',
			'2c0f:f248::/32'
	    );
	    foreach ($cf_ipv4s as $cf_ip) {
	        if ($this->ipv4inrange($ip, $cf_ip)) {
	            return true;
	        }
	    }
	    foreach ($cf_ipv6s as $cf_ip) {
	        if ($this->ipv6_in_range($ip, $cf_ip)) {
	            return true;
		}
	    }
	    return false;
	}
	public function getYourIP() {
		if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && $this->isCloudFlareIP($_SERVER['REMOTE_ADDR'])) //CLOUDFLARE REVERSE PROXY SUPPORT
  			return $_SERVER['HTTP_CF_CONNECTING_IP'];
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $this->ipv4inrange($_SERVER['REMOTE_ADDR'], '127.0.0.0/8')) //LOCALHOST REVERSE PROXY SUPPORT (7m.pl)
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['REMOTE_ADDR'] == "10.0.1.10") // 141412 PROXY SUPPORT FUCK YOU HESTIA
			return explode(",", $_SERVER['HTTP_X_FORWARDED_FOR'])[0]; // fuck my life
		return $_SERVER['REMOTE_ADDR'];
	}
	public function checkProxy() {
		require __DIR__."/../../config/security.php";
		if(!isset($blockFreeProxies)) global $blockFreeProxies;
		if(!isset($proxies)) global $proxies;
		if(!$blockFreeProxies) return;
		$fileExists = file_exists(__DIR__ .'/../../config/proxies.txt');
		$lastUpdate = $fileExists ? filemtime(__DIR__ .'/../../config/proxies.txt') : 0;
		$checkTime = time() - 3600;
		$allProxies = '';
		if($checkTime > $lastUpdate) {
			foreach($proxies AS $link) {
				$ch = curl_init($link);
				if($proxytype > 0) {
					curl_setopt($ch, CURLOPT_PROXY, $host);
					if($proxytype == 2) curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
					if(!empty($auth)) curl_setopt($ch, CURLOPT_PROXYUSERPWD, $auth); 
				}
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
				curl_setopt($ch, CURLOPT_USERAGENT, "");
				$IPs = curl_exec($ch);
				$proxy = preg_split('/\r\n|\r|\n/', $IPs);
				foreach($proxy AS $ip) $allProxies .= explode(':', $ip)[0].PHP_EOL;
			}
			file_put_contents(__DIR__ .'/../../config/proxies.txt', $allProxies);
		}
		if(empty($allProxies)) $allProxies = file(__DIR__ .'/../../config/proxies.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		else $allProxies = explode(PHP_EOL, $allProxies);
		if(in_array($this->getYourIP(), $allProxies)) {
			http_response_code(404);
			exit;
		}
	}
	public function checkVPN() {
		require __DIR__."/../../config/security.php";
		require __DIR__."/../../config/proxy.php";
		if(!isset($blockCommonVPNs)) global $blockCommonVPNs;
		if(!isset($vpns)) global $vpns;
		if(!$blockCommonVPNs) return;
		$fileExists = file_exists(__DIR__ .'/../../config/vpns.txt');
		$lastUpdate = $fileExists ? filemtime(__DIR__ .'/../../config/vpns.txt') : 0;
		$checkTime = time() - 3600; 
		$allVPNs = '';
		if($checkTime > $lastUpdate) {
			foreach($vpns AS $link) {
				$ch = curl_init($link);
				if($proxytype > 0) {
					curl_setopt($ch, CURLOPT_PROXY, $host);
					if($proxytype == 2) curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
					if(!empty($auth)) curl_setopt($ch, CURLOPT_PROXYUSERPWD, $auth); 
				}
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
				curl_setopt($ch, CURLOPT_USERAGENT, "");
				$IPs = curl_exec($ch);
				$allVPNs .= $IPs.PHP_EOL;
			}
			file_put_contents(__DIR__ .'/../../config/vpns.txt', $allVPNs);
		}
		if(empty($allVPNs)) $allVPNs = file(__DIR__ .'/../../config/vpns.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		else $allVPNs = explode(PHP_EOL, $allVPNs);
		foreach($allVPNs AS &$vpnCheck) {
			if($this->ipv4inrange($this->getYourIP(), $vpnCheck)) {
				http_response_code(404);
				exit;
			}
		}
	}
	public function checkIP() {
		global $db;
		$this->checkProxy();
		$this->checkVPN();
		$banip = $db->prepare("SELECT count(*) FROM bannedips WHERE IP = :ip");
		$banip->execute([':ip' => $this->getYourIP()]);
		$banip = $banip->fetchColumn();
		if($banip > 0) {
			http_response_code(404);
			exit;
		}
	}
}
?>
