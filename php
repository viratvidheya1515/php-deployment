---
 - hosts: DEV
 
     tasks:
     - name: "installing lamp package"
       yum: name={{item}} state=latest
       with_items:
         - php
         - apache
     - name: " php pkg validation"
       command: php -v
       register: php_validation
       when: pkg_log|success

     - name: "starting php service"
       service: name=php state=started

     - name: "installing apche package"
       apt: name=apache2 state=latest
       register: apachestatus

     - name: "starting tomcat services"
       service: name=apache2 enabled=yes state=started

    handlers:
    - name: stop php
      service: name=php state=stop
    - - name: restart php
      service: name=php state=restarted    
