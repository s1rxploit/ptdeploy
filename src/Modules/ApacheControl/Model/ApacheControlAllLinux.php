<?php

Namespace Model;

class ApacheControlAllLinux extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    private $apacheCommand;

    public function askWhetherToStartApache() {
        if ( !$this->askForApacheCtl("start") ) { return false; }
        $this->apacheCommand = $this->askForApacheCommand();
        $this->startApache();
        return true;
    }

    public function askWhetherToStopApache() {
        if ( !$this->askForApacheCtl("stop") ) { return false; }
        $this->apacheCommand = $this->askForApacheCommand();
        $this->stopApache();
        return true;
    }

    public function askWhetherToRestartApache() {
        if ( !$this->askForApacheCtl("restart") ) { return false; }
        $this->apacheCommand = $this->askForApacheCommand();
        $this->restartApache();
        return true;
    }

    public function askWhetherToReloadApache() {
        if ( !$this->askForApacheCtl("reload") ) { return false; }
        $this->apacheCommand = $this->askForApacheCommand();
        $this->restartApache();
        return true;
    }

    public function runAutoPilot($autoPilot) {
        $this->runAutoPilotApacheCtlStart($autoPilot);
        $this->runAutoPilotApacheCtlRestart($autoPilot);
        $this->runAutoPilotApacheCtlReload($autoPilot);
        $this->runAutoPilotApacheCtlStop($autoPilot);
        return true;
    }

    public function runAutoPilotApacheCtlStart($autoPilot){
        if ( !isset($autoPilot["apacheCtlStartExecute"]) ||
            $autoPilot["apacheCtlStartExecute"] == false ) { return false; }
        $this->params["guess"] = true ;
        $this->apacheCommand = $this->askForApacheCommand();
        $this->startApache();
        return true;
    }

    public function runAutoPilotApacheCtlRestart($autoPilot){
        if ( !isset($autoPilot["apacheCtlRestartExecute"]) ||
            $autoPilot["apacheCtlRestartExecute"] == false ) { return false; }
        $this->params["guess"] = true ;
        $this->apacheCommand = $this->askForApacheCommand();
        $this->restartApache();
        return true;
    }

    public function runAutoPilotApacheCtlReload($autoPilot){
        if ( !isset($autoPilot["apacheCtlReloadExecute"]) ||
            $autoPilot["apacheCtlReloadExecute"] == false ) { return false; }
        $this->params["guess"] = true ;
        $this->apacheCommand = $this->askForApacheCommand();
        $this->reloadApache();
        return true;
    }

    public function runAutoPilotApacheCtlStop($autoPilot){
      if ( !isset($autoPilot["apacheCtlStopExecute"]) ||
        $autoPilot["apacheCtlStopExecute"] == false ) { return false; }
        $this->params["guess"] = true ;
        $this->apacheCommand = $this->askForApacheCommand();
      $this->stopApache();
      return true;
    }

    private function askForApacheCtl($type) {
      if (!in_array($type, array("start", "stop", "restart", "reload"))) { return false; }
      if (isset($this->params["yes"]) && $this->params["yes"]==true) { return true ; }
      $question = 'Do you want to '.ucfirst($type).' Apache?';
      return self::askYesOrNo($question);
    }

    private function askForApacheCommand() {
      $appConfigFactory = new \Model\AppSettings();
      $appConfigModel = $appConfigFactory->getModel($this->params, "AppConfig");
      $linuxTypeFromConfig = $appConfigModel::getAppVariable("linux-type") ;
      if ( in_array($linuxTypeFromConfig, array("debian", "redhat") ) ) {
          $input = ($linuxTypeFromConfig == "debian") ? "apache2" : "httpd" ; }
      else if (isset($this->params["guess"]) && $this->params["guess"]==true) {
          $isDebian = $this->detectDebianApacheVHostFolderExistence();
          $input = ($isDebian) ? "apache2" : "httpd" ; }
      else {
          $question = 'What is the apache service name?';
          $input = self::askForArrayOption($question, array("apache2", "httpd"), true) ; }
      return $input ;
    }

    private function detectDebianApacheVHostFolderExistence(){
        return file_exists("/etc/apache2/sites-available");
    }

    private function restartApache(){
        echo "Restarting Apache...\n";
        $command = "sudo service $this->apacheCommand restart";
        return self::executeAndOutput($command);
    }

    private function reloadApache(){
        echo "Reloading Apache Configuration...\n";
        $command = "sudo service $this->apacheCommand reload";
        return self::executeAndOutput($command);
    }

    private function startApache(){
        echo "Starting Apache...\n";
        $command = "sudo service $this->apacheCommand start";
        return self::executeAndOutput($command);
    }


    private function stopApache(){
        echo "Stopping Apache...\n";
        $command = "sudo service $this->apacheCommand stop";
        return self::executeAndOutput($command);
    }

}