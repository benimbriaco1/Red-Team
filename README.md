# Red-Team

🔴 This repository contains my Red Team Tool for CSEC 473. It contains a PHP web shell script, and the corresponding Ansible playbooks which are used to deploy this script to both Windows and Linux hosts.  

## Overview of functionality:

⚪️ On Windows, my tool + Ansible:
  - Turns off the Windows Firewall
  - Installs IIS Web Server onto the target host(s)
  - Installs PHP and sets up necessary IIS configuration via FastCGI, Module Mappings, and Handlers
  - Copies my PHP web shell script into a fake "Day2Inject" folder in the webroot directory so that it can be accessed elsewhere via browser
  - Configures the application pool identity to be Localsystem

🟠 On Linux, my tool + Ansible:
  - Opens port 80 if UFW is being used
  - Installs Apache and PHP onto the host(s)
  - Creates a fake "Day2Inject" folder in the /var/www/html/ directory
  - Copies my PHP web shell script into the fake directory so it can be accessed elsewhere via browser
  - Runs a command which allows www-data to run any command as any user without supplying a password
