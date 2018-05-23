 <?php 

function email_valid($email) {
	if(preg_match("/[\\000-\\037]/", $email)) {
		return false;
	}
	
	$pattern = "/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD";
	
	if(!preg_match($pattern, $email)){
		return false;
	}
	
	// Validate the domain exists with a DNS check
	list($user,$domain) = explode('@', $email);
	if(function_exists('checkdnsrr')) {
		if(!checkdnsrr($domain, "MX")) {
		return false;
		}
	} else if(function_exists("getmxrr")) {
		if(!getmxrr($domain, $mxhosts)) {
			return false;
		}
	}
	
	return true;
}