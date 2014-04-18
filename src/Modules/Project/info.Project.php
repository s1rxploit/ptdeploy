<?php

Namespace Info;

class ProjectInfo extends Base {

    public $hidden = false;

    public $name = "Dapperstrano Project Management Functions";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "Project" => array_merge(parent::routesAvailable(),
        array("init", "build-install", "container", "cont") ) );
    }

    public function routeAliases() {
      return array("proj"=>"Project", "project"=>"Project");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Default Modules and handles Project initialisation functions, like configuring a project, or a project
  container and also installing Jenkins build files into a running Jenkins instance.

  Project, project, proj


          - container
          make a container folder for revisions (like /var/www/applications/*APP NAME*)
          example: dapperstrano proj container
          example: dapperstrano proj container --yes --proj-container="/var/www/applications/the-app"

          - init
          initialize Dapper project
          example: dapperstrano proj init
          example: dapperstrano proj init --yes

          - build-install
          copy jenkins project stored in repo to running jenkins so you can run builds
          example: dapperstrano proj build-install
          example: dapperstrano proj build-install
                        --jenkins-fs-dir=/var/lib/jenkins # --guess will set this to /var/lib/jenkins
                        --original-build-dir="/var/www/applications/the-app/build/config/cleopatra/Project/jenkins-builds"
                        --target-job-name="Project_Build"
                        --new-job-dir="Project_Build_Alternate_Name"  # If target one is not available

HELPDATA;
      return $help ;
    }

}