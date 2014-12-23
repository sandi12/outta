<?php
    define('ADMIN_LOG', 'admin/admin.log');
    
    function serFile($filename) {
        $list = file($filename);
        $res = [];
        foreach ($list as $item) {
            $item = unserialize($item);
            $res[$item['ip']] = $item;
        }
        return $res;
    }
    
    $length = strlen (MAIN_WAY);
    $ip = $_SERVER['REMOTE_ADDR'];
    $first = true;
    
    if (is_file(ADMIN_LOG)) {
        $list = serFile(ADMIN_LOG);
        if (isset($list[$ip])) {
            $item = &$list[$ip];
            
            $item['listPage'][] = [
                'time' => time(), 
                'addr' => $_SERVER['REQUEST_URI'],
                'method' => $_SERVER['REQUEST_METHOD']
            ];
            
            if (!isset($_SERVER['HTTP_REFERER']) || substr($_SERVER['HTTP_REFERER'], 0, $length)!=MAIN_WAY) {
                $item['ref']= (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : 'загруженно с закладок';
                $item['amountVis']++;
                $item['soft'][] = $_SERVER['HTTP_USER_AGENT'];
            }
            
            $first = false;
            unset($item);
            
            $handle=fopen(ADMIN_LOG, 'w'); //have made rewriting
            fclose($handle);
        
            foreach ($list as $item)
                file_put_contents(ADMIN_LOG, serialize($item)."\n", FILE_APPEND);
        }
    }
    
    if (!is_file(ADMIN_LOG) || $first) {
        
        $item=[
            'ip' => $_SERVER['REMOTE_ADDR'], 
            'listPage' => [
                [
                    'time' => time(),
                    'addr' => $_SERVER['REQUEST_URI'],
                    'method' => $_SERVER['REQUEST_METHOD']
                ]
            ],
            'firstVis' => time(),
            'soft' => [$_SERVER['HTTP_USER_AGENT']], 
            'amountVis' => 1
        ];
        
        $item['ref']= (isset($_SERVER['HTTP_REFERER']) && substr($_SERVER['HTTP_REFERER'], 0, $length)!=MAIN_WAY) ? $_SERVER['HTTP_REFERER'] : 'загруженно с закладок';
        
        file_put_contents(ADMIN_LOG, serialize($item)."\n", FILE_APPEND);
    }
    
    unset($list, $item, $length);