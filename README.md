Golden Contact Computing - Devhelper Tool
-------------------

About:
-----------------
This tool helps with setting up projects. It's really cool for cloning/installing/spinning up webs apps easily and
quickly.

Very cool for CI, after your CI tool performs the project checkout to run tests, you can install your webb app in one
line like:

devhelper install autopilot *autopilot-file*


Installation
-----------------

To install devhelper cli on your machine do the following. If you already have php5 and git installed skip line 1:

line 1: apt-get php5 git
line 2: git clone https://github.com/phpengine/devhelper && sudo devhelper/install

... that's it, now the devhelper command should be available at the command line for you.

-------------------------------------------------------------

Available Commands:
---------------------------------------

install       - cli
                install a full web project - Checkout, Vhost, Hostfile, Cucumber Configuration, Database and Jenkins
                Job. The installer will ask you for required values
                example: devhelper install cli

              - autopilot
                perform an "unattended" install using the defults in an autopilot file. Great for Remote Builds.
                example: devhelper install autopilot

checkout,     - perform a checkout into configured projects folder
co              example: devhelper co git https://github.com/phpengine/yourmum {optional custom clone dir}

cukeconf,     - conf
cuke            modify the url used for cucumber features testing
                example: devhelper cukeconf cli

              - reset
                reset cuke uri to generic values so devhelper can write them. may need to be run before cuke conf.
                example: devhelper cukeconf reset

database, db  - configure, conf
                set up db user & pw for a project, use admins to create new resources as needed.
                example: devhelper db conf drupal

              - reset
                reset current db to generic values so devhelper can write them. may need to be run before db conf.
                example: devhelper db reset drupal

              - install
                install the database for a project. run conf first to set up users unless you already have them.
                example: devhelper db install

              - drop
                drop the database for a project.
                example: devhelper db drop

hosteditor,   - add
                add a Host File entry
                example: devhelper hosteditor add

              - rm
                remove a Host File entry
                example: devhelper hosteditor rm

project, proj - init
                initialize DH project
                example: devhelper proj init

              - build-install
                copy jenkins project stored in repo to running jenkins so you can run builds
                example: devhelper proj build-install

vhosteditor,  - add
vhc             create a Virtual Host
                example: devhelper vhc add

              - rm
                remove a Virtual Host
                example: devhelper vhc rm