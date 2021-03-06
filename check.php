<?php
    function domain_name($domain_name)
    {
        $domain_len = strlen($domain_name);
        if ($domain_len < 3 OR $domain_len > 253)
            return FALSE;
        if(stripos($domain_name, 'http://') === 0)
            $domain_name = substr($domain_name, 7); 
        elseif(stripos($domain_name, 'https://') === 0)
            $domain_name = substr($domain_name, 8);
        if(stripos($domain_name, 'www.') === 0)
            $domain_name = substr($domain_name, 4); 
        if(strpos($domain_name, '.') === FALSE OR $domain_name[strlen($domain_name)-1]=='.' OR $domain_name[0]=='.')
            return FALSE;
        return (filter_var ('http://' . $domain_name, FILTER_VALIDATE_URL)===FALSE)? FALSE:TRUE;
    }
    $contents = file_get_contents("info.html");
    if( isset($argv[1])){
        $contents = file_get_contents($argv[1]);
    }
    $tempString = str_replace('<li class="softitem">', '<lilili>', $contents);
    $tempString = str_replace('<li class="pathitem">', '<lilili>', $contents);
    $lstTmp = explode("<lilili>", $tempString);
    $outFName = "output.txt";
    for( $i = 1; $i < count($lstTmp); $i++){
        $curNode =  $lstTmp[$i];
        $arrNodes = explode("</li>", $curNode);
        $arrDomains = explode(":", $arrNodes[0]);
        foreach ($arrDomains as $value) {
            echo $value . " : ";
            if (filter_var($value, FILTER_VALIDATE_IP)){
                echo "IP Address.\n";
                continue;
            }
            if( domain_name($value)){
                file_put_contents($outFName, $value . "\n", FILE_APPEND);
                echo "YES";
            } else{
                echo "NO";
            }
            echo "\n";
        }
    }