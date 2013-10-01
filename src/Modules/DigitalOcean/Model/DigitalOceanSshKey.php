<?php

Namespace Model;

class DigitalOceanSshKey extends BaseDigitalOcean {

    public function runAutoPilot($autoPilot){
        $this->runAutoPilotSaveSshKey($autoPilot);
        return true;
    }

    public function askWhetherToSaveSshKey($params=null) {
        return $this->performDigitalOceanSaveSshKey($params);
    }

    public function runAutoPilotSaveSshKey($autoPilot) {
        if ( !isset($autoPilot["digitalOceanSshKeyExecute"]) || $autoPilot["digitalOceanSshKeyExecute"] !== true ) {
            return false; }
        $this->apiKey = $this->askForDigitalOceanAPIKey();
        $this->clientId = $this->askForDigitalOceanClientID();
    }

    public function performDigitalOceanSaveSshKey($params=null){
        if ($this->askForSSHKeyExecute() != true) { return false; }
        $this->apiKey = $this->askForDigitalOceanAPIKey();
        $this->clientId = $this->askForDigitalOceanClientID();
        $fileLocation = $this->askForSSHKeyPublicFileLocation();
        $fileData = file_get_contents($fileLocation);
        $keyName = $this->askForSSHKeyNameForDigitalOcean();
        return $this->saveSshKeyToDigitalOcean($fileData, $keyName);
    }

    private function askForSSHKeyExecute(){
        $question = 'Save local SSH Public Key file to Digital Ocean?';
        return self::askYesOrNo($question);
    }

    private function askForSSHKeyPublicFileLocation(){
        $question = 'Enter Location of ssh public key file to upload';
        return self::askForInput($question, true);
    }

    private function askForSSHKeyNameForDigitalOcean(){
        $question = 'Enter name to store ssh key under on Digital Ocean';
        return self::askForInput($question, true);
    }

    public function saveSshKeyToDigitalOcean($keyData, $keyName){
        $callVars = array();
        $callVars["ssh_pub_key"] = urlencode($keyData);
        $callVars["ssh_key_name"] = $keyName;
        $curlUrl = "https://api.digitalocean.com/ssh_keys/new" ;
        return $this->digitalOceanCall($callVars, $curlUrl);
    }

}