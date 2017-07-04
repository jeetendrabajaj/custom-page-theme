<?php

/**
 * Helper class for Inc access
 *
 * @package    Custom Page Theme
 * @copyright  Copyright (c) Jeetendra Bajaj 
 * @license    GPLv3 (http://www.gnu.org/licenses/gpl-3.0.html)
 * @author     Jeetendra Bajaj <bajajeet@gmail.com>
 */
class Inc {


	public function __construct(){}



	// Function to remove folders and files 
    function rrmdir($dir) {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file)
                if ($file != "." && $file != "..") $this->rrmdir("$dir/$file");
            rmdir($dir);
        }
        else if (file_exists($dir)) unlink($dir);
    }

	function rcopy($src, $dst) {
        if (file_exists ( $dst ))
            $this->rrmdir ( $dst );
        if (is_dir ( $src )) {
            mkdir ( $dst );
            $files = scandir ( $src );
            foreach ( $files as $file )
                if ($file != "." && $file != "..")
                    $this->rcopy ( "$src/$file", "$dst/$file" );
        } else if (file_exists ( $src ))
            copy ( $src, $dst );
    }

	 /**
	 * Remove special characters from the file name passed except underscore, hyphen & dot.
	 */
	function filename_sanitize($file_name){
		return preg_replace('/[^a-zA-Z0-9\-\_\.]/', '', $file_name);
	}

	 /**
	 * Remove special characters from the string passed except underscore & hyphen.
	 */
	function string_sanitize($string){
		return preg_replace('/[^a-zA-Z0-9\-\_]/', '', $string);
	}

	 /**
	 * Append passed text at the top of passed file.
	 */	
	function prepand_text($txt, $file){
		$handle = fopen($file, "r+");
		$len = strlen($txt);
		$final_len = filesize($file) + $len;
		$txt_old = fread($handle, $len);
		rewind($handle);
		$i = 1;
		while (ftell($handle) < $final_len) {
		  fwrite($handle, $txt);
		  $txt = $txt_old;
		  $txt_old = fread($handle, $len);
		  fseek($handle, $i * $len);
		  $i++;
		}
	}

	 /**
	 * Append passed text at the end of passed file.
	 */	
	function postappand_text($txt, $file){
		return file_put_contents($file, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
	}
}