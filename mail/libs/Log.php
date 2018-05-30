<?php


define("ENTER", "\r\n");
require_once __DIR__.'/../bootstrap/ini.php';
class Log
{

    /**
     * @version             v1.0
     * @author              JianJia.Zhou
     * @changeTime          dt
     * @param int    $level
     * @param        $msg
     * @param        $data
     * @param string $log_type
     */
    public static function logWrite($level = 2, $msg, $data, $log_type = "error")
    {
        global $log_config;
        $path = $log_config['path'] . date("Ymd") . "/";
        $filename = $log_type . ".log";
        self::createDir($path);
        $path = $path . $filename;
        if (!is_writable($path)) {
            @touch($path);
        }
        $log_level = array_flip($log_config['level']);
        $level_desc = $log_level[$level];
        /* 每段日志之前插入分隔符*/
        $head = ENTER . ENTER . date("Y-m-d H:i:s") . " " . substr(number_format(microtime(true), 6, '', ''), 10, 6) . ENTER;
        $head .= '************************************************************' . ENTER;
        $head .= $level_desc . ":";
        $formatData = self::formatData($data);
        if (empty(trim($formatData))) {
            $formatData = 'NULL';
        }
        $write_data = $head . $msg . ENTER . $formatData;
        $handle = @fopen($path, 'a');
        if ($handle) {
            fwrite($handle, $write_data);
            fclose($handle);
        }
    }

    public static function trackTrace()
    {
        $str = '';
        $array = debug_backtrace();
        unset ($array[0]);
        foreach ($array as $row) {
            $str .= $row['file'] . ':' . $row['line'] . '行，调用方法：' . $row['function'] . '<br>';
        }
        return $str;
    }

    /**
     * @version             v1.0
     * @author              JianJia.Zhou
     * @changeTime          dt
     * @param string $path 文件夹路径名
     * @param int    $mode
     * @param int    $recursive
     */
    private static function createDir($path='', $mode = 0777, $recursive = 1)
    {
        !is_dir($path) && @mkdir($path, $mode, $recursive);
    }

    /**
     * 格式转换
     * @param object $data
     * @return string
     */
    public static function formatData($data)
    {
        $return = '';
        /* 数组和对象都格式化 */
        if (is_array($data) || is_object($data)) {
            $return .= 'total_count:' . count($data) . "\r\n";
            $return .= json_encode($data) . "\r\n";
        } else {
            $return .= "$data\r\n";
        }
        return $return;
    }

}

