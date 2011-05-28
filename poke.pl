#!/usr/bin/perl
use strict;
use WWW::Mechanize;
use HTTP::Cookies;
use Term::ReadKey;

# Version: 1.0 Alpha
# Date:    2010-12-06
# Revised: 2010-12-07
# Author:  Patrik Greco <sikevux @sikevux.se>
#          https://sikevux.se
# License: Kopimi
# Description:
#          This script was written to make sure that you will be
#          assured a victory in case of a so called poke war at
#          Facebook.
#          This script violates the Facebook Terms of Service.
#          You can, and probably will get banned for using it.
#          You have been warned. Enjoy!

#-- Initiate all Vars --#
my $login;
my $password;
my $mech;
my $pokeback;
#-- End Vars --#
#-- Start of the program --#
print("                                                                         
        __  _                                                                   
    .-.'  `; `-._                                                               
   (_,           )                                                              
 ,'o'( Sikevux's  )                                                             
(__,-'   perl     )>                                                            
   (     poker   )                                                              
    `-'._.--._.-'                                                               
,,,,,,,|||,,|||,,,,,,,                                                          
");

#-- end of Sheep --#

#-- Login prompt --#
print "Facebook login: ";
$login = ReadLine(0);
chomp($login);
ReadMode 0;

print "Password: ";

# Don't print the password as we type
 ReadMode('noecho');
 $password = ReadLine(0);
 chomp( $password );
 ReadMode 0;

# Working on it.
 print "\n";
 print "######################\n";
print "#  We are now Live!  #\n";
print "#     Take cover!    #\n";
 print "######################\n";
#-- End login prompt --#

#-- Mechanize start --#
 $mech = WWW::Mechanize->new();

# We need to store some tmp cookies
 $mech->cookie_jar(HTTP::Cookies->new());

# Grab the login so we can get the login form
 $mech->get("https://m.facebook.com/login.php");

# Stop Facebutt from sending you to HTTP after auth
 $mech->max_redirect(0);

# Send the login form to facebutt
$mech->submit_form(
    form_number => 1,
    fields =>
    {
		email => $login,
		pass => $password
    }
 );
#-- Auth Done :) --#

#-- Poke :) --#
# Get the page!
 $mech->get("https://m.facebook.com/home.php");

# As long as 1 is 1 everything will be ok
 while (1==1) {

# if the page includes "poke" poke ppl!
	 if ($mech->content()=~/poke/) { 
		 $pokeback = $mech->content();
		 $pokeback =~ s/\n//g;
		 $pokeback =~ s/^.*poke=//g;
		 $pokeback =~ s/\">Poke.*$//g;
		 $pokeback =~ s/&amp;/&/g;
		 $mech->get("https://m.facebook.com/a/home.php?poke=$pokeback");
		 $mech->get("https://m.facebook.com/home.php");
	 }

# if there's no one to poke back, just wait 1 minute.
	 else {
		 sleep(60);
		 $mech->get("https://m.facebook.com/home.php");
	 }
 }
#-- Poke done --#
