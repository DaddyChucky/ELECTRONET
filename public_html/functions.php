<?php


	//FOR SQL INJECTION
	function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);

		return $data;
	}


	//RANDOM STRING GENERATOR
	function generateRandomString($length = 50) 
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';

	    for ($i = 0; $i < $length; $i++) 
	    {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }

	    return $randomString;
	}
	

	//GET BROWSER
	function get_browser_name($user_agent)
	{
	        // Make case insensitive.
	        $t = strtolower($user_agent);

	        // If the string *starts* with the string, strpos returns 0 (i.e., FALSE). Do a ghetto hack and start with a space.
	        // "[strpos()] may return Boolean FALSE, but may also return a non-Boolean value which evaluates to FALSE."
	        //     http://php.net/manual/en/function.strpos.php
	        $t = " " . $t;

	        // Humans / Regular Users      
	        if     (strpos($t, 'opera'     ) || strpos($t, 'opr/')     ) return 'Opera'            ;
	        elseif (strpos($t, 'edge'      )                           ) return 'Edge'             ;
	        elseif (strpos($t, 'chrome'    )                           ) return 'Chrome'           ;
	        elseif (strpos($t, 'safari'    )                           ) return 'Safari'           ;
	        elseif (strpos($t, 'firefox'   )                           ) return 'Firefox'          ;
	        elseif (strpos($t, 'msie'      ) || strpos($t, 'trident/7')) return 'Internet Explorer';

	        // Search Engines  
	        elseif (strpos($t, 'google'    )                           ) return '[Bot] Googlebot'   ;
	        elseif (strpos($t, 'bing'      )                           ) return '[Bot] Bingbot'     ;
	        elseif (strpos($t, 'slurp'     )                           ) return '[Bot] Yahoo! Slurp';
	        elseif (strpos($t, 'duckduckgo')                           ) return '[Bot] DuckDuckBot' ;
	        elseif (strpos($t, 'baidu'     )                           ) return '[Bot] Baidu'       ;
	        elseif (strpos($t, 'yandex'    )                           ) return '[Bot] Yandex'      ;
	        elseif (strpos($t, 'sogou'     )                           ) return '[Bot] Sogou'       ;
	        elseif (strpos($t, 'exabot'    )                           ) return '[Bot] Exabot'      ;
	        elseif (strpos($t, 'msn'       )                           ) return '[Bot] MSN'         ;

	        // Common Tools and Bots
	        elseif (strpos($t, 'mj12bot'   )                           ) return '[Bot] Majestic'     ;
	        elseif (strpos($t, 'ahrefs'    )                           ) return '[Bot] Ahrefs'       ;
	        elseif (strpos($t, 'semrush'   )                           ) return '[Bot] SEMRush'      ;
	        elseif (strpos($t, 'rogerbot'  ) || strpos($t, 'dotbot')   ) return '[Bot] Moz or OpenSiteExplorer';
	        elseif (strpos($t, 'frog'      ) || strpos($t, 'screaming')) return '[Bot] Screaming Frog';
	        
	        // Miscellaneous 
	        elseif (strpos($t, 'facebook'  )                           ) return '[Bot] Facebook'     ;
	        elseif (strpos($t, 'pinterest' )                           ) return '[Bot] Pinterest'    ;
	        
	        // Check for strings commonly used in bot user agents   
	        elseif (strpos($t, 'crawler' ) || strpos($t, 'api'    ) ||
	                strpos($t, 'spider'  ) || strpos($t, 'http'   ) ||
	                strpos($t, 'bot'     ) || strpos($t, 'archive') || 
	                strpos($t, 'info'    ) || strpos($t, 'data'   )    ) return '[Bot] Other'   ;
	        
	        return 'Other (Unknown)';
	}


	//RETRIEVE SESSION IP
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
	{
	    $_SESSION['IP'] = $_SERVER['HTTP_CLIENT_IP'];
	} 

	else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
	{
	    $_SESSION['IP'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} 

	else 
	{
	    $_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
	}

?>