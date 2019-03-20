<?php

namespace Oranger\Library\Tools;

class CSVWriter
{
    public function __construct($file_or_handle, $sep = "\t", $quot = '"')
    {
        $args = func_get_args();
        $mode = isset($opts['mode']) ? $opts['mode'] : 'w';

        $this->f =
            is_string($file_or_handle)
            ? fopen($file_or_handle, $mode)
            : $file_or_handle;

        $this->fputcsv_args = [$this->f, null, $sep, $quot];

        if (! $this->f) {
            throw new Exception('bad file descriptor');
        }
    }

    public function write($row)
    {
        $this->fputcsv_args[1] = &$row;
        call_user_func_array('fputcsv', $this->fputcsv_args);
    }

    public function close()
    {
        if (! is_null($this->f)) {
            fclose($this->f);
        }
        $this->f = null;
    }

    public function __destruct()
    {
        $this->close();
    }
}
