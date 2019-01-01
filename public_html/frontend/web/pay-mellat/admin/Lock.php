<style type="text/css">
.CENTER {
	text-align: center;
}
.CENTER {
	font-family: tahoma;
}
.CENTER {
	font-size: 10px;
}
.CENTER {
	font-size: 12px;
}
.CENTEr {
	color: #FFF;
}
</style>
<body class="CENTER"><p>www.ivahid.com </p>
<p><a href="www.ivahid.com"><br />
  http://www.ivahid.com<br />
</a></p>
<p> www.ivahid.com</p>
<p>&nbsp;</p>
<p>اخطار - این فایل را حذف نکنید</p>
<p>&nbsp;</p>

<span class="CENTEr">--------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>>
- Run the server installer and follow the instructions.

  IMPORTANT:
	Please note that if you choose to install the server over an existing
	installation the existing installation directory will be removed!

  Example:
  $ sh bf2142_linuxded-x.y.z-installer.sh

- Modify mods/bf2142/settings/serversettings.con to your taste.

  Example:
  $ cd /path/to/installation/bf2142
  $ vi mods/bf2142/settings/serversettings.con

- Modify mods/bf2142/settings/maplist.con to your taste.

  Example:
  $ cd /path/to/installation/bf2142
  $ vi mods/bf2142/settings/serversettings.con

  IMPORTANT:
    Please see the information below to understand the new map list format.

- Run the server from within the top-level directory by typing
  ./start.sh [arguments] from a shell.

  Example:
  $ cd /path/to/installation/bf2142
  $ ./start.sh

- If you are starting the server from a remote connection you will need to
  encapsulate it inside a "screen" session to let it stay behind when you log
  out from the shell.

  Example (to start the server):
  $ cd /path/to/installation/bf2142
  $ screen ./start.sh
  Now press Ctrl-A followed by Ctrl-D to detach the screen session, leaving it
  running in the background. You can now log out without affecting the server.

  Example (to reconnect to the server status monitor):
  $ screen -r

  Please see the man page for screen to learn more about what it can do.


==============================================================================
More information
==============================================================================

Welcome to the Battlefield 2142™ dedicated server. For patch-specific
information please refer to the generic read me file included with both the
Linux and win32 distributions.

Note that if your system clock and date are not set correctly this can lead to issues with stats processing on Ranked servers. Please ensure the time and date are set correctly before starting the game server.

==============================================================================
BattleRecorder
==============================================================================
See ReadmeServer.txt located in the same directory as this file for information
on setting up and using BattleRecorder on your server.

For this feature to work on linux you will need to have Python installed on your
machine. You can find python at http://www.python.org. Many Linux distributions now ship with Python already included. Please refer to your Linux documentation to see if your distribution has Python included.

==============================================================================
The file case confusion problem solved
==============================================================================

The Battlefield 2142™ Linux server will read lower-case filenames ONLY. All file names
encountered at runtime are lower-cased before a filesystem access is
attempted. The only exception is Python-scripts. You should therefore make sure 
all files are lower-case when installing third-party modifications and maps.

To aid you with this there is an included python script called
lowercaseDir.py which recursively changes the case of files and directories from
the directory where it's run.

Usage:
lowercaseDir.py 
<directory> [--pretend] [--verbose]

You can simulate the actions of the script with these options:
 $ ./lowercaseDir.py mods/yourMod --pretend

When you're certain it looks good run the conversion:
 $ ./lowercaseDir.py mods/yourMod --verbose


Known issues
==============================================================================

OVERLAY SERVERS
- You must set sv.allowNATNegotiation to 1 in order to broadcast all instances
  of overlay servers.


Licensing information
==============================================================================

The Battlefield 2142™ server is linked with the GNU C and C++ libraries which
are under the LGPL license. By linking dynamically we ensure that you as a
user can use this software with other versions of these libraries.

A statically linked binary also linked with these libraries is supplied purely
for convenience should you not be able to run the dynamically linked binary.

The LGPL license text is included with this release and can be found on the
web at http://www.gnu.org/licenses/lgpl.html.

Please note that the Battlefield 2142™ dedicated server itself is not covered
by the LGPL license.

==========================================================================
</span> &nbsp;