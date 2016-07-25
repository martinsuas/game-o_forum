<?php   # Script 3.4 - index.php
		# Created 01/11/2016
		# Created by Martin Suarez
		# This script experiments with using multiple files.
		# 
		# Script 3.7 - update #2
		# Created 02/26/2016
		# Created by Martin Suarez
		# Added functions to the website
		
// Adds an ad.
function create_ad() {
	echo '<p class="ad">ADVERTISEMENT!</p>';
}
$page_title = "Welcome!";
include( 'includes/header.html');

// Call the function
create_ad();
 ?>
<h1>Content Header</h1>
<p>Welcome to Game-o Forum! This sample website is created using PHP, MySQL, and will eventually include
    JavaScript. The goal of it is to apply newly learned concepts and showcase them as a portafolio
    of my current mastery of these languages.</p>

<p></p>

<p>Catelyn slapped him so hard she broke his lip. Olyvar, she thought, and Perwyn, 
Alesander, all absent. And Roslin wept . . .</p>

<p>Edwyn Frey shoved her aside. The music drowned all other sound, echoing off the walls as 
if the stones themselves were playing. Robb gave Edwyn an angry look and moved to block his 
way... and staggered suddenly as a quarrel sprouted from his side, just beneath the shoulder. 
If he screamed then, the sound was swallowed by the pipes and horns and fiddles. Catelyn saw a 
second bolt pierce his leg, saw him fall. Up in the gallery, half the musicians had crossbows 
in their hands instead of drums or lutes. She ran toward her son, until something punched in the 
small of the back and the hard stone floor came up to slap her. ‘‘Robb!’’ she screamed. She saw 
Smalljon Umber wrestle a table off its trestles. Crossbow bolts thudded into the wood, one two 
three, as he flung it down on top of his king. Robin Flint was ringed by Freys, their daggers 
rising and falling. Ser Wendel Manderly rose ponderously to his feet, holding his leg of lamb. 
A quarrel went in his open mouth and came out the back of his neck. Ser Wendel crashed forward, 
knocking the table off its trestles and sending cups, flagons, trenchers, platters, turnips, beets, 
and wine bouncing, spilling, and sliding across the floor.</p>



<?php 
create_ad();
include( 'includes/footer.html' ); ?>

		