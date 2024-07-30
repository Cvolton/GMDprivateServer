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
    public static function ip2long6($ip) {
        if (substr_count($ip, '::')) {
            $ip = str_replace('::', str_repeat(':0000', 8 - substr_count($ip, ':')) . ':', $ip);
        }

        $ip = explode(':', $ip);
        $r_ip = '';
        foreach ($ip as $v) {
            $r_ip .= str_pad(base_convert($v, 16, 2), 16, 0, STR_PAD_LEFT);
        }

        return base_convert($r_ip, 2, 10);
    }
    public static function ipv6_in_range($ip, $range_ip) {
        $pieces = explode ("/", $range_ip, 2);
        $left_piece = $pieces[0];
        $right_piece = $pieces[1];

        // Extract out the main IP pieces
        $ip_pieces = explode("::", $left_piece, 2);
        $main_ip_piece = $ip_pieces[0];
        $last_ip_piece = $ip_pieces[1];

        // Pad out the shorthand entries.
        $main_ip_pieces = explode(":", $main_ip_piece);
        foreach($main_ip_pieces as $key=>$val) {
            $main_ip_pieces[$key] = str_pad($main_ip_pieces[$key], 4, "0", STR_PAD_LEFT);
        }

        // Create the first and last pieces that will denote the IPV6 range.
        $first = $main_ip_pieces;
        $last = $main_ip_pieces;

        // Check to see if the last IP block (part after ::) is set
        $last_piece = "";
        $size = count($main_ip_pieces);
        if (trim($last_ip_piece) != "") {
            $last_piece = str_pad($last_ip_piece, 4, "0", STR_PAD_LEFT);

            // Build the full form of the IPV6 address considering the last IP block set
            for ($i = $size; $i < 7; $i++) {
                $first[$i] = "0000";
                $last[$i] = "ffff";
            }
            $main_ip_pieces[7] = $last_piece;
        }
        else {
            // Build the full form of the IPV6 address
            for ($i = $size; $i < 8; $i++) {
                $first[$i] = "0000";
                $last[$i] = "ffff";
            }
        }

        // Rebuild the final long form IPV6 address
        $first = ip2long6(implode(":", $first));
        $last = ip2long6(implode(":", $last));
        $in_range = ($ip >= $first && $ip <= $last);

        return $in_range;
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
	        if (ipInRange::ipv4_in_range($ip, $cf_ip)) {
	            return true;
	        }
	    }
	    foreach ($cf_ipv6s as $cf_ip) {
	        if (ipInRange::ipv6_in_range($ip, $cf_ip)) {
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
