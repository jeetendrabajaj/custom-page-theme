=== Custom Page Theme - A Wordpress Theme Generator Plugin===
Contributors: J.K.
Author URI: https://www.linkedin.com/in/jeetendra-bajaj-14020b14/
Plugin URI: 
Tags: design, theme, custom page design, custom page theme, page theme, design theme, auto designing, theme designing
Requires at least: 4.1
Tested up to: 4.8
Stable tag: 1.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Custom Page Theme is a plugin, that helps you to make a custom wordpress theme and apply it to any wordpress page, so that individual page can 
have completely different theme, irrespective of whatever theme is active. So with this plugin you can apply multiple themes to various pages on 
a single website. Not even this you can make a custom html page of your own apply it as a theme of a page.


== Description ==

Consider a situation when our client demands for a page on their website that have slightly or completely different look then the active theme offers.
(Let's for example a page for Christmas greetings.). Let's not only the content of page is diffent, but also the header and footer of page need also be 
different. 

= What does it do? =

Questions:-
1) Is it possible to implement such page without any programming intervention?? 
2) After implementation, with the passing of time, once when the requirement expires and extra changes no more required. How to deal with this extra code??
3) If we do not remove this extra code then, How to maintain other code as well as other functionality of website intact from this extra code??
4) If we decided to remove this extra functionality once the requirement expires, then How much it is easy to remove this extra code??

Answers:-
1) With Custom Page Theme Plugin it is possible, Because now implementation of such pages need no any programming intervention, even a html designer can now
   fulfill this demand, using this plugin.
2) Custom Page Theme Plugin maintains this extra code into separate location as a seperate theme, and do not merge any portion of it with active code. So just 
   by removing the link between page and the custom theme, extra functionality can be removed or set as inactive. And this all can be done from admin panel only.
3) Now once when extra changes no more required, we can keep the changes. As we know Custom Page Theme Plugin maintains this extra code into separate location as 
   a seperate theme, so the influence of extra code can be removed or set inactive from admin panel.
4) We can even remove this custom theme once the extra changes no more require too. It is now up to admin decision. No more programing intervention required.


= Disclaimer =
 
However lot of studies has been done while making this plugin. Our intention is to automate a lot of work that is not possible with any programing intervention.
And help designer to design pages separately with effecting the active theme. With a little technical knowledge designers can design their wordpress themes.  

Still as it is the first version of plugin, we will suggest it to first use it on some stagging installation of wordpresss. Take complete backup of your WordPress website 
before installing it on your deployed version or use it at your own risk but please do not forget to back up your files and databases before use.
If you're new to WordPress or have a very limited technical background you may consider seeking out professional help your first time using the plugin. 
For any kind of assistance from our side, you can post your suggestions on our blog section.


== Installation ==

1. Upload `custom-page-theme` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Now in admin panel a 'Custom Page Theme'Click will be add in the main menu.
 

== How it works?? ==

The core idea behind this plugin is to attach the page specific theming concept with wordpress, and can give free hands to designers to spread their imaginations 
over specific pages of their wordpress website. Cause using Custom Page Theme Plugin they can save their work in separate themes and use those themes whenever
& whatever pages they want.

== How to use?? ==

Once installed & activation on wordpress website. Under Admin Panel the plugin adds a main menu link "Custom Page Theme". Having 2 Submenues "All Custom Page Themes"
 & "Add Custom Page Theme".

 Custom Page Theme (Main menu item link - Added by Custom Page Theme plugin)
      |
      |- All Custom Page Themes (Submenu item link - Dispaly list of all Custom Page Themes been created and links to edit,delete & check the pages the theme is hooked.)
      |- Add Custom Page Theme (Submenu item link - To add/create a new Custom Page Theme)


== Add Custom Page Theme ==

A WordPress theme needs only two files to exist – style.css and index.php. So if we can write a seperate style.css and index.php file and save it in a 
theme, and then we can hook that custom theme with required page from admin panel without any code intervention. 

Below with 3 samples i will try to explain the complete idea. Starting with a very simple Sample, we will try little more complex pages too in next 2 Samples.

= Sample 1 =
In Next 10 steps we will create a Custom Page Theme and apply it to a page. The content of page will be <h1>My First Custom Page Theme</h1>

1) Create a file named index.php. It's mendatory that the content of index.php file must be inner-html of body tage, and should not contain markup before & after body tag along with <body> tag itself.
2) Paste  <h1>My First Custom Page Theme</h1> in index.php.
3) Create an empty file and saved it as style.css
4) Open your website admin panel.(I assumed the Custom Page Theme plugin is activate.)
5) Click on link Custom Page Theme -> Add Custom Page Theme.
6) In Add Custom Page Theme Page their are 4 fields that are mendatory. Title, Description, Upload file (index.php) & Upload file (style.css). 
   - Title: The inserted vlaue will apply as title of theme. Write "My First Custom Page Theme". 
   - Description: The inserted vlaue will apply as description of theme. Write "My First Custom Page Theme". 
   - Upload file (index.php): Upload the above created index.php file here.
   - Upload file (style.css): Upload the above created style.css file here.
7) Submit Add Custom Page Theme Form. Don't forget untill all the 4 mendatory fields are not satisfied. The form will not submit and It will not create a theme.
8) Hook the above create theme with a page:- Create a new page. Click on link Pages -> Add New. 
   Note:- In "Add New Page" you will find a metabox named "Custom Page Theme" at righti-side column. In Custom Page Theme metabox all themes along with the above created theme 
   are listed in a select dropdown. Any theme that you will select from dropdown will be applied on this page. By default it's value is set as default (It means the 
   active theme of website will be applied on this page.)  
9) In "Add New Page" under Title & Body fields insert "My First Custom Page Theme". and from "Custom Page Theme" metabox select "My First Custom Page Theme". Click on Publish button.
10)Now click on "View Page" button or open the Permalink of the page in another browser-window. 

Note: Now you can see here that your complete website is working on the active theme applied only

= Sample 2 =
