<?php
class ipCheck {
  public function ipv4inrange($ip, $range) {
       if (strpos($range, '/') !== false) {
            // $range is in IP/NETMASK format
            list($range, $netmask) = explode('/', $range, 2);
            if (strpos($netmask, '.') !== false) {
                // $netmask is a 255.255.0.0 format
                $netmask = str_replace('*', '0', $netmask);
                $netmask_dec = ip2long($netmask);
                return ( (ip2long($ip) & $netmask_dec) == (ip2long($range) & $netmask_dec) );
            } else {
                // $netmask is a CIDR size block
                // fix the range argument
                $x = explode('.', $range);
                while(count($x)<4) $x[] = '0';
                list($a,$b,$c,$d) = $x;
                $range = sprintf("%u.%u.%u.%u", empty($a)?'0':$a, empty($b)?'0':$b,empty($c)?'0':$c,empty($d)?'0':$d);
                $range_dec = ip2long($range);
                $ip_dec = ip2long($ip);

                # Strategy 1 - Create the netmask with 'netmask' 1s and then fill it to 32 with 0s
                #$netmask_dec = bindec(str_pad('', $netmask, '1') . str_pad('', 32-$netmask, '0'));

                # Strategy 2 - Use math to create it
                $wildcard_dec = pow(2, (32-$netmask)) - 1;
                $netmask_dec = ~ $wildcard_dec;

                return (($ip_dec & $netmask_dec) == ($range_dec & $netmask_dec));
            }
        } else {
            // range might be 255.255.*.* or 1.2.3.0-1.2.3.255
            if (strpos($range, '*') !==false) { // a.b.*.* format
                // Just convert to A-B format by setting * to 0 for A and 255 for B
                $lower = str_replace('*', '0', $range);
                $upper = str_replace('*', '255', $range);
                $range = "$lower-$upper";
            }

            if (strpos($range, '-')!==false) { // A-B format
                list($lower, $upper) = explode('-', $range, 2);
                $lower_dec = (float)sprintf("%u",ip2long($lower));
                $upper_dec = (float)sprintf("%u",ip2long($upper));
                $ip_dec = (float)sprintf("%u",ip2long($ip));
                return ( ($ip_dec>=$lower_dec) && ($ip_dec<=$upper_dec) );
            }
            return false;
        }
 }
	public function cloudFlareIP($ip) {
    	$cf_ips = array(
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
	    foreach($cf_ips as $cf_ip) {
	        if($this->ipv4inrange($ip, $cf_ip)) {
	            return true;
	        }
	    }
	    return false;
	}
	public function getYourIP() {
		if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && $this->cloudFlareIP($_SERVER['REMOTE_ADDR'])) //CLOUDFLARE REVERSE PROXY SUPPORT
  			return $_SERVER['HTTP_CF_CONNECTING_IP'];
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $this->ipv4inrange($_SERVER['REMOTE_ADDR'], '127.0.0.0/8')) //LOCALHOST REVERSE PROXY SUPPORT (7m.pl)
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		return $_SERVER['REMOTE_ADDR'];
	}
	public function checkProxy() {
		include __DIR__."/../../config/security.php";
		if(!isset($blockFreeProxies)) global $blockFreeProxies;
		if(!isset($proxies)) global $proxies;
		if(!$blockFreeProxies) return;
		$fileExists = file_exists(__DIR__ .'/../../config/proxies.txt');
		$lastUpdate = $fileExists ? filemtime(__DIR__ .'/../../config/proxies.txt') : 0;
		$checkTime = time() - 3600;
		$allProxies = '';
		if($checkTime > $lastUpdate) {
			foreach($proxies AS $link) {
				$IPs = file_get_contents($link);
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
		include __DIR__."/../../config/security.php";
		if(!isset($blockCommonVPNs)) global $blockCommonVPNs;
		if(!isset($vpns)) global $vpns;
		if(!$blockCommonVPNs) return;
		$fileExists = file_exists(__DIR__ .'/../../config/vpns.txt');
		$lastUpdate = $fileExists ? filemtime(__DIR__ .'/../../config/vpns.txt') : 0;
		$checkTime = time() - 3600; 
		$allVPNs = '';
		if($checkTime > $lastUpdate) {
			foreach($vpns AS $link) {
				$IPs = file_get_contents($link);
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
		$this->checkProxy();
		$this->checkVPN();
	}
}
?>
