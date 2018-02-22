<?php 

    function buildUrl($region = 'euw1',$type,$spec,$query){
        // https://euw1.api.riotgames.com/lol/static-data/v3/champions
        $url = "https://".$region.".api.riotgames.com/lol/".$type."/".$spec;
        $q = "";
        foreach (array_keys($query) as $k) { 
            if($q != '') $q.='&';
            $q.= $k."=".$query[$k]; 
        } 
        if($q != '') $url.='?';
        return $url.$q;
    }

    function callAPI($region,$type,$spec,$query,$config){
        $cache 			= "cache/".$spec.".cache"; // make this file in same dir
        $force_refresh	= false; // dev
        $refresh		= 60*60; // once an hour
        
        if ($force_refresh || ((time() - filectime($cache)) > ($refresh) || 0 == filesize($cache))) {

            $ch = curl_init(buildUrl($region,$type,$spec,$query));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-Riot-Token:'. $config["api_key"]
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $curlcontent = curl_exec($ch);            
            $curlcontent =  json_decode($curlcontent) -> data;
            curl_close($ch);

            $handle = fopen($cache, 'wb') or die('no fopen');	
            $json_cache = json_encode($curlcontent) ;
            fwrite($handle, $json_cache);
            fclose($handle);
        } else {
            $json_cache = file_get_contents($cache); //locally
        }

        $jsonR = json_decode($json_cache);
        return $jsonR;
    }

    function calcStatsGrowth($base,$growth,$level){
        return $base + $growth*($level-1)*(0.685+0.0175*$level);
    }
?>