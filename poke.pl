#!/usr/bin/perl
use strict;
use WWW::Mechanize;
use HTTP::Cookies;
use Term::ReadKey;

# Version: 1.0 Alpha
# Date:    2010-12-06
# Revised: 2011-06-14
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
my ($login, $password, $sec_code, $comp_name, $mech, $pokeback);
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

#-- End login prompt --#

#-- Mechanize start --#
$mech = WWW::Mechanize->new();

# We need to store some tmp cookies
$mech->cookie_jar(HTTP::Cookies->new());

# Grab the login so we can get the login form
$mech->get("https://m.facebook.com/login.php");


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
#-- 2nd Auth --#
print $mech->content();
print "Security code: ";
$sec_code = ReadLine(0);
chomp($sec_code);
ReadMode 0;

 if($mech->content()=~/approvals_code/) {
$mech->submit_form(
	form_number => 1,
	fields =>
	{
		approvals_code => $sec_code
	}
);
 }
#-- 2nd Auth Done --#
#-- Add fakkin puter --#
print "Computer name: ";
$comp_name = ReadLine(0);
chomp($comp_name);
ReadMode 0;
$mech->submit_form(
	form_number => 1,
	fields =>
	{
		machine_name => $comp_name
	}
);
print $mech->content();
 my $plompt = ReadLine(0);
 chomp($plompt);
 ReadMode 0;
 if($plompt != 'y') {
	 exit();
 }
#-- Add puter Done --#
print "\n";
print "######################\n";
print "#  We are now Live!  #\n";
print "#     Take cover!    #\n";
print "######################\n";
#-- Poke :) --#
# Get the page!
$mech->get("https://m.facebook.com/home.php");
 print $mech->content();
 my $ndplompt = ReadLine(0);
 chomp($ndplompt);
 ReadMode 0;
 if($ndplompt != 'y') {
	 exit();
 }
# As long as 1 is 1 everything will be ok
while (1==1) {

# if the page includes "poke" poke ppl!
if ($mech->content()=~/poke/) { 
	print "starting to poke";
	$pokeback = $mech->content();
	$pokeback =~ s/\n//g;
	$pokeback =~ s/^.*poke=//g;
	$pokeback =~ s/\">Poke.*$//g;
	$pokeback =~ s/&amp;/&/g;
	$mech->get("https://m.facebook.com/a/home.php?poke=$pokeback");
	$mech->get("https://m.facebook.com/home.php");
	print "one poke!";
}

# if there's no one to poke back, just wait 1 minute.
else {
	print "something";
	sleep(60);
	$mech->get("https://m.facebook.com/home.php");
}
}
#-- Poke done --#
