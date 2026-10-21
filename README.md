📋 Benjamin Imbriaco

🔴 This repository contains my Red Team Tool for CSEC 473. It contains a PHP web shell script, and the corresponding Ansible playbooks which are used to deploy this script to both Windows and Linux hosts.  

## Overview of functionality:

🔵 On Windows, my tool + Ansible:
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

# Usage Instructions
These instructions walk through how to use my tool, starting with a fresh install of Windows Server 2019 and Ubuntu 24.04 LTS, and a Linux Ansible Controller

On the Ansible controller host, 2 commands have to be run to ensure full functionality:  
`ansible-galaxy collection install microsoft.iis`  
`sudo apt install sshpass`

Then run a git clone on the controller to install my tool and ansible scripts, this command **has to be run in the root directory** in order for the Ansible to work:
`git clone https://github.com/benimbriaco1/Red-Team.git`

Delete the ReadMe locally after, so it won’t interfere. The repository also contains empty inventory files which should be updated contain:

🟠 On Linux, it should have target Linux host IPs, as well as ansible_user, ansible_password, and ansible_become_password values. These can be configured per host or for all hosts.    
🔵 On Windows, it should have target Windows host IPs, as well as the ansible_connection (winrm), ansible_user (use Admin user), ansible_password, ansible_winrm_transport (ntlm), ansible_port (5985), and ansible_winrm_scheme (http) values

## 🔵 Windows

On the Windows target host, to start all that is needed initially is to turn off the Windows Firewall to prevent interference with connection attempts, and to note the Administrator password configured for the above inventory file.  
<img width="588" height="440" alt="image" src="https://github.com/user-attachments/assets/24b3314c-f700-4b7b-9738-3d51b85fa432" />

And now with a proper inventory file, you can deploy the web shell to Windows with:

`ansible-playbook -i win-inventory.ini deploy_iis_webshell.yml`

If successful, you can navigate to `http://<host-ip>/Day2Inject/BikiniBottom.php` on the web browser of a host which can reach the web server running on the victim host (same network). The result should be remote command injection on the targeted host via the web shell:  
<img width="588" height="440" alt="image" src="https://github.com/user-attachments/assets/c6157a0e-e685-40da-aab2-6a998ba73fdd" />   
**Note**: this example uses localhost for demonstration purposes but for competition would use the IP of a Blue Team Window's box

## 🟠 Linux

On the Linux target host, in order to to simulate the functionality of my tool, there needs to be a user with sudoers privileges. To demonstrate, I created a user ‘spongebob’ and added him to the sudo group by running the following commands as root:  
`adduser spongebob`    
`usermod -aG sudo spongebob`   

**Note**: This is just for demonstration purposes. During the competition there will already be admin accounts deployed on the boxes to use.

If not installed yet, SSH server needs to be downloaded to the target Linux hosts so that Ansible can work on those hosts. Can be done via:
`sudo apt update`  
`sudo apt install openssh-server -y`   
^ install package maintainers version

Next, you have to SSH into the box with any user to add the host’s public key to the controller’s known_hosts file (could do via scp too). Example:
`ssh spongebob@<linux-ip>`  

Then you can deploy the web shell via:
`ansible-playbook -i linux-inventory.ini deploy_apache_webshell.yml`  

And you should have remote command injection on the targeted linux hosts now, by navigating to `http://<host-ip>/Day2Inject/BikiniBottom.php`:  

<img width="558" height="440" alt="image" src="https://github.com/user-attachments/assets/1af34a9b-d5f8-4aae-9e7f-bd9a55dc3011" />











