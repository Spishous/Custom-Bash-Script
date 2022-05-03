<?php

const foreground_black='0;30',
      foreground_dark_gray='1;30',
      foreground_blue='0;34',
      foreground_light_blue='1;34',
      foreground_green='0;32',
      foreground_light_green='1;32',
      foreground_cyan='0;36',
      foreground_light_cyan='1;36',
      foreground_red='0;31',
      foreground_light_red='1;31',
      foreground_purple='0;35',
      foreground_light_purple='1;35',
      foreground_brown='0;33',
      foreground_yellow='1;33',
      foreground_light_gray='0;37',
      foreground_white='1;37';

const background_black= '40',
      background_red= '41',
      background_green= '42',
      background_yellow= '43',
      background_blue= '44',
      background_magenta= '45',
      background_cyan= '46',
      background_light_gray= '47';

class script_object {
    public $system;

    public function __construct(){
        $this->system= isset($_SERVER["OS"]) ? $_SERVER["OS"] : "";
    }

    // Returns colored string
    public function startStyle($foreground_color = null, $background_color = null,$bold=false,$italic=false,$underline=false,$strike=false){
        $colored_string = "";

        // Check if given foreground color found


        if (isset($foreground_color)) {
            $colored_string .= "\033[" . $foreground_color . "m";
        }
        // Check if given background color found
        if (isset($background_color)) {
            $colored_string .= "\033[" . $background_color . "m";
        }
        if($bold) {
            $colored_string .= "\e[1m";
        }
        if($italic) {
            $colored_string .= "\e[3m";
        }
        if($underline){
            $colored_string .= "\e[4m";
        }
        if($strike){
            $colored_string .= "\e[9m";
        }
        echo $colored_string;
    }
    public function endStyle(){
        echo "\033[0m\e[0m";
        return $this;
    }
    public function printStyle($string, $foreground_color = null, $background_color = null,$bold=false,$italic=false,$underline=false,$strike=false){
        self::startStyle($foreground_color, $background_color,$bold,$italic,$underline,$strike);
        echo $string . "\033[0m\e[0m";
        return $this;
    }
    public function printText($string){
        echo $string;
        return $this;
    }

    public function clear(){
        echo "\n";
        system('clear');
        return $this;
    }
    public function newline(){
        echo "\n";
        return $this;
    }
    private function sshMode(){
        return ($this->system!=="Windows_NT");
    }
    public function hideKey(){
        if($this->sshMode()){
            system('stty -echo');
        }

    }
    public function showKey(){
        if($this->sshMode()){
            system('stty echo');
        }
    }
    public function input($prompt = '') {
        if($this->sshMode()){
            $prompt && print "\n".$prompt;
            $terminal_device = '/dev/tty';
            $h = fopen($terminal_device, 'r');
            if ($h === false) {
                #throw new RuntimeException("Failed to open terminal device $terminal_device");
                return false; # probably not running in a terminal.
            }
            $line = rtrim(fgets($h),"\r\n");
            fclose($h);
            return $line;
        }else{
            $prompt && print $prompt;
            $line=fgets(STDIN);
            $line=trim($line);
            if($line==""){
                $line=$this->input();
            }
            return $line;
        }
    }
}
