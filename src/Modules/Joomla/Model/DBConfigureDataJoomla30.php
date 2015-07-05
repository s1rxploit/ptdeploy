<?php

Namespace Model;

class DBConfigureDataJoomla30 extends Base {

    // Compatibility
    public $os = array("Linux", "Darwin") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default", "Joomla30Config") ;

    private $friendlyName = 'Joomla 3.x Series';
    private $shortName = 'Joomla30';
    private $settingsFileLocation = ''; // no trail slash, empty for root
    private $settingsFileName = 'configuration.php';
    private $settingsFileReplacements ;
    private $extraConfigFileReplacements ;
    private $extraConfigFiles ; // extra files requiring db config

    public function __construct(){
        $this->extraConfigFiles = array('build'.DS.'config'.DS.'phpunit'.DS.'bootstrap.php');
		$this->setProperties();
        $this->setReplacements();
        $this->setExtraConfigReplacements();
    }

    protected function setProperties() {
		$prefix = (isset($this->params["parent-path"])) ? $this->params["parent-path"] : "" ;
        if (strlen($prefix) > 0) {
            $this->settingsFileLocation = $prefix; }
        else {
            $this->settingsFileName = 'src'.DS.'configuration.php'; }
    }

    public function getProperty($property) {
        return $this->$property;
    }

    public function __call($var1, $var2){
        return "" ; // @todo what even is this
    }

    private function setReplacements(){
        $this->settingsFileReplacements = array(
            'public $db ' => '  public $db = "****DB NAME****";',
            'public $user ' => '  public $user = "****DB USER****";',
            'public $password ' => '  public $password = "****DB PASS****";',
            'public $host ' => '  public $host = "****DB HOST****";',
        );
    }

    private function setExtraConfigReplacements(){
        $this->extraConfigFileReplacements = array(
            '$bootstrapDbName =' => '$bootstrapDbName = "****DB NAME****" ; ',
            '$bootstrapDbUser =' => '$this->dbUser = "****DB USER****" ; ',
            '$bootstrapDbPass =' => '$this->dbPass = "****DB PASS****" ; ',
            '$bootstrapDbHost =' => '$this->dbHost = "****DB HOST****" ; ');
    }

}
