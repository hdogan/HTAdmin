HTAdmin
=======

Warning; this project is hardly deprecated, do not use it in production.

HTAdmin is a basic and simple PHP tool for administrating Apache .htpasswd files.

Develpoment has been started at 2000 (when PHP 4 is first released) and stopped at 2005 (before PHP 5).

REQUIREMENTS
------------

* Linux/Unix/BSD, Windows or Mac OS X
* Apache web server
* PHP

INSTALLATION
------------

* Edit the following lines in config.inc.php file:
```
  $cfgUseAuth        = true;
  $cfgSuperUser      = 'admin';
  $cfgSuperPass      = 'password';

  $cfgHTPasswd[0][N] = '/htdocs/example/.htpasswd'; // First file's full path and name
  $cfgHTPasswd[0][D] = 'Sample htpasswd file'; // First file's description
  $cfgHTPasswd[1][N] = ''; // Second file's full path and name
  $cfgHTPasswd[2][D] = ''; // Second file's description
```

* If you want to run on Linux/Unix/BSD and Mac OS X, change your .htpasswd 
  file's mode to 666 (chmod 666 .htpasswd).

* If you want to run on Windows operating system, change $cfghtpasswdEXE 
  configuration directive and write your htpasswd.exe filename with full path.
  (Use included htpasswd.exe file).

THANKS
------

* Bastian Friedrich (An author of HTAdmin 2.0 and Disclaimer)
  URL: http://www.bastian-friedrich.de
  PS: I see you on your webcam! ;)

* Shane Allen (An author of HTAdmin PERL-1.0c)
  PS: This project is dead :(

* Michael McIntosh (Bug report and fix)

* Alex Piaz (Bug report and fix)

* Osvaldo Tulini

* Mike Eliott (Ideas/1.1b changes)

* David Lightman (Bug report)

* Ryan Bohm (Idea for supporting PHP4)
  URL: http://www.interwebber.com

* Pieter Bos (Report and fix Language mistakes)

* Guillermo Gianello (Bug report and fix)

* Anyone else I forgot

* EVERYONE using this software

DISCLAIMER
----------

* No responsiblity for any security risks or software bugs whatsoever is
  accepted by the author(s).
