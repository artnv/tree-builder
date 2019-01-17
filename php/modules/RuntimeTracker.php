<?php

/*
 *
 * https://github.com/artnv/RuntimeTracker
 *
 */
class RuntimeTracker
{

    private $mem_start;

    private $time_start;

    private function timeNow()
    {
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        return $time;
    }

    public function start()
    {
        $this->mem_start = memory_get_usage();
        $this->time_start = $this->timeNow();
    }

    public function end()
    {
        $time = round(($this->timeNow() - $this->time_start), 4);
        $mem = memory_get_usage() - $this->mem_start;
        $kb = round($mem / 1024, 2);
        $mb = round($mem / 1024 / 1024, 2);

        echo '<br/>';
        echo 'Memory Usage: ' . $kb . 'KB. | ' . $mb . 'MB.<br/>';
        echo 'Time: ' . $time . ' Sec.';
        echo '<br/>';
    }
}
?>