<?php
set_time_limit(0);
global  $wpdb;
//require_once (TEMPLATEPATH . '/delete_data.php');
$dummy_image_path = get_template_directory_uri().'/images/dummy/';

//====================================================================================//
/////////////// TERMS START ///////////////
require_once(ABSPATH.'wp-admin/includes/taxonomy.php');
$category_array = array('Blog');
insert_category($category_array);
function insert_category($category_array)
{
	for($i=0;$i<count($category_array);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))
		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				$last_catid = wp_create_category( $catname, $parent_catid);
				if($j==0)
				{
					$parent_catid = $last_catid;
				}
			}
			
		}else
		{
			$catname = $category_array[$i];
			wp_create_category( $catname, $parent_catid);
		}
	}
}

/////////////// TERMS END ///////////////
/////////////// PLACE TERMS START ///////////////
$place_category_array = array('Attractions','Hotels','Restaurants','Food Nightlife','Festival','Videos','Feature');
insert_place_category($place_category_array);
function insert_place_category($category_array)
{
	global $wpdb,$dummy_image_path;
	for($i=0;$i<count($category_array);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))
		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				$last_catid = wp_insert_term( $catname, 'placecategory', $args = array('parent'=>$parent_catid) );
				if($j==0)
				{
					$parent_catid = $last_catid;
				}
			}
			
		}else
		{
			$catname = $category_array[$i];
			$last_catid = wp_insert_term( $catname, 'placecategory' );
			$i1 = $i+1;
			$dummy_image_path = get_template_directory_uri().'/images/dummy/';
			if(is_wp_error($last_catid)){}else{
			if($last_catid['term_id']){update_tax_meta($last_catid['term_id'],'ct_cat_icon',array( 'id' => 'icon', 'src' => $dummy_image_path.''.($i+1).'.png'));}}

		}
	}
}
/////////////// PLACE TERMS START ///////////////



//====================================================================================//
$blog_info = array();
$post_info = array();
////post start 1///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "image"			=> $dummy_image_path.'blog1.jpg',
				    "height"		=> '150',
					"width"			=> '150',
					"position"		=> 'left',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
				);
$blog_info[] = array(
					"post_title"	=>	'Cleopatra: The Search for the Last Queen of Egypt',
					"post_content"	=>	'<h3>  The Experience </h3>

The world of Cleopatra, which has been lost to the sea and sand for nearly 2,000 years, will surface in a new exhibition, Cleopatra: The Search for the Last Queen of Egypt, making its world premiere in June 2010 at The Franklin Institute in Philadelphia, from June 5, 2010 – January 2, 2011. The exhibition will feature roughly 140 artifacts while taking visitors inside the present-day search for Cleopatra, which extends from the sands of Egypt to the depths of the Bay of Aboukir near Alexandria.
Cleopatra VIP Hotel Package

Cleopatra visitors looking to make it an overnight stay can book the Cleopatra VIP Hotel Package. Available at 11 hotels, the package includes overnight accommodations for two and two VIP (untimed, bypass-the-line) tickets to the exhibition. (VIP tickets are available only by purchasing a hotel package and are valued at up to $59.)

Click here to check rates and book the package.
<h3>The Search For Cleopatra </h3>

Cleopatra, the last great pharaoh of Egypt before it succumbed to Roman opposition, lived from 69 – 30 B.C., and her rule was marked with political intrigue and challenges to her throne. She captivated two of the most powerful men of her day, Julius Caesar and Mark Antony, as she attempted to restore Egypt to its former superpower status. Later, her Roman conquerors tried to rewrite her history and destroy all traces of her existence. Although her body has never been found, her story survives.

Visitors to the exhibition will be treated to an inside view of the search for Cleopatra through two ongoing expeditions by modern explorers Dr. Zahi Hawass, Egypt&acute;s pre-eminent archaeologist and Secretary General of the Supreme Council of Antiquities, and Franck Goddio, French underwater archaeologist and director of IEASM. Goddio&acute;s search has resulted in one of the most ambitious underwater expeditions ever undertaken, which has uncovered Cleopatra&acute;s royal palace and two ancient cities that had been lost beneath the sea for centuries after a series of earthquakes and tidal waves.

The artifacts in the exhibition — from the smallest gold pieces and coins to colossal statues more than 15-feet tall — provide a window into Cleopatra&acute;s story as well as the daily lives of her contemporaries, both powerful and humble. Artifacts on display will include magnificent black granite statues of a queen of Egypt dating from the Ptolemaic era in which Cleopatra ruled, which Goddio&acute;s team pulled from the sea.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('tag')
					);
////post end///
////post start 2///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "image"			=> $dummy_image_path.'blog2.jpg',
				    "height"		=> '150',
					"width"			=> '150',
					"position"		=> 'left',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
				);
$blog_info[] = array(
					"post_title"	=>	'First Friday',
					"post_content"	=>	'<h3>When </h3>

The First Friday evening of each month, rain or shine, year-round. Hours: 5 to 9 p.m.
<h3>Where </h3>

Most galleries can be found between Front and Third, and Market and Vine Streets.
<h3>The Experience </h3>

Want proof of Philadelphia&acute;s happening art scene? Come down to Old City for First Fridays. On the first Friday evening of every month the streets fill with art lovers of all kinds who wander among the neighborhood&acute;s 40-plus galleries, most of them open from 5 until 9 p.m.

A casual atmosphere encourages art and people watching, eating at Old City&acute;s many restaurants and just plain mingling. There&acute;s diversity both in the crowd and among the galleries, adding flavor to the experience. Most galleries can be found between Front and Third, and Market and Vine Streets.
<h3>History </h3>

Started in 1991 by a group of galleries as a collaborative open house evening, First Fridays grew quickly into one of Philly&acute;s most vital, signature cultural events. Old City&acute;s historic commercial buildings have fostered a SoHo-like cultural ambience with the densest network of galleries in the city.

Some of the arts organizations you can visit on First Fridays include the Clay Studio; the Temple Gallery; the cooperative galleries Nexus, Highwire, Muse and Third Street Gallery; and collaborative Space 1026.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Friday')
					);
////post end///
////post start 3///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "image"			=> $dummy_image_path.'blog3.jpg',
				    "height"		=> '150',
					"width"			=> '150',
					"position"		=> 'left',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
				);
$blog_info[] = array(
					"post_title"	=>	'Philadelphia International Festival of the Arts',
					"post_content"	=>	'<h3>The Experience </h3>

April 7 through May 1, 2011, the Philadelphia International Festival of the Arts (PIFA) will shine a spotlight on the city&acute;s arts and cultural scene. For three weeks, audiences will revel in an array of one-time, only-in-Philadelphia productions by some of the region&acute;s top talents—many of whom will partner with or present international performers. PIFA will feature music, dance, fashion, fine arts, poetry, cuisine and more—all infused with the essence of Paris, circa 1910-1920.

Inspired by the Kimmel Center, PIFA promises to be an out-of-the-box arts festival that honors the vision of longtime Philadelphia resident and philanthropist Leonore Annenberg. Before she passed away in 2009, Mrs. Annenberg provided a generous grant through the Annenberg Foundation to ensure that her lifelong dream for a citywide arts celebration would be fulfilled.

As PIFA transforms the entire city into a giant stage, loyal fans and newcomers to the arts will have the opportunity to choose from among dozens of ticketed and free activities each day. Performances and exhibits will be held throughout Center City and beyond, many in Kimmel Center venues, as well as in theaters, performance halls and other venues, both large and small.

With more than 100 performances planned, three events serve as examples of the serendipitous moments and surprising performances audiences can look forward to. For the first time ever, the Philadelphia Orchestra and the Pennsylvania Ballet will perform together, collaborating on what promises to be an unforgettable presentation of the classic French ballet Pulcinella. In an innovative pairing, Philly&acute;s signature hip-hop band The Roots will play in an anything-can-happen concert with a French chanteuse. What&acute;s more, daring aerialists will swing from the rafters of the Kimmel Center and teach anybody who has ever wanted to join the circus how to fly the trapeze on the Avenue of the Arts.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Friday')
					);
////post end///
////post start 4///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "image"			=> $dummy_image_path.'blog4.jpg',
				    "height"		=> '150',
					"width"			=> '150',
					"position"		=> 'left',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
				);
$blog_info[] = array(
					"post_title"	=>	'Art of the American Soldier',
					"post_content"	=>	'<h3>The Experience </h3>

More than 15,000 paintings and sketches created by over 1,300 American soldiers in the line of duty have been in curatorial storage in Washington, D.C. for decades. Seldom have them been made available for public viewing. Art of the American Soldier will bring these powerful works of art into the spotlight at the National Constitution Center from September 24, 2010 through January 10, 2011.

The exhibition, featuring a never-before-seen collection, was created by the NCC in partnership with the U.S. Army Center of Military History and the National Museum of the United States Army. Following its world debut at the Center, the exhibition will begin a national tour. Tickets to the exhibition are currently available for purchase.

<h3>The Trailer </h3>
 <object height="325" width="500" id="Object1" viewastext="" data="http://constitutioncenter.org/artOfTheAmericanSoldier/_flash/embed.swf" type="application/x-shockwave-flash"><param value="sameDomain" name="allowScriptAccess"><param value="http://constitutioncenter.org/artOfTheAmericanSoldier/_flash/embed.swf" name="movie"><param value="false" name="menu"><param value="best" name="quality"></object>

<h3>History </h3>

The U.S. Army&acute;s art program began during World War I, and continued through World War II, resulting in the creation of over 2,000 pieces of art. In 1945, the Army established its Historical Division, with responsibilities including the preservation of these works. The collection also includes artwork by artists who were sent to document the Vietnam War, as well as works from soldier-artists who are currently deployed in Iraq and Afghanistan. For a complete history of the Army&acute;s art program, click here.
Tickets

Admission to Art of the American Soldier is FREE with regular museum admission of $12 for adults, $11 for seniors ages 65 and over, and $8 for children ages 4-12. Veterans and military families will receive $2 off admission. Active military personnel, career military retirees, and children ages 3 and under are free. Group rates are also available. For ticket information, call 215.409.6700 or visit www.constitutioncenter.org.
Buy Tickets Online In Advance

You can buy admission tickets to the National Constitution Center online through our partners at the Independence Visitor Center. Just click the button below',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Art')
					);
////post end///
////post start 5///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "image"			=> $dummy_image_path.'blog5.jpg',
				    "height"		=> '150',
					"width"			=> '150',
					"position"		=> 'left',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
				);
$blog_info[] = array(
					"post_title"	=>	'Late Renoir Exhibition at the PMA',
					"post_content"	=>	'June 17 – September 6, 2010

The Philadelphia Museum of Art continues its recent trend of focusing in on a significant artist and showcasing the ways in which they influenced the art world for generations. Late Renoir is the first exhibition to survey the achievement of the great Impressionist painter Pierre-Auguste Renoir (1841-1919) during the last three decades before his death. The exhibition will include some 80 of the artist&acute;s paintings, sculpture, and drawings will be on view, along with a selection of works by Henri Matisse, Pablo Picasso, Pierre Bonnard, and others who were inspired by his work.

<h3>About the Exhibition </h3>

A landmark exhibition, Late Renoir examines new directions that the artist explored several decades after he and others such as Claude Monet and Camille Pissarro created the new style of painting known as Impressionism. This new and widely admired phase in Renoir&acute;s career propelled him into the modern age and, at the same time, enabled him to recapture a classical past with expressive brushwork and a palette of sensuous colors that were both lyrical and decorative.

Late Renoir includes major works on loan from public and private collections in Europe, the United States, and Japan. The exhibition is co-organized by the Reunion des Musées nationaux, the Musée d’Orsay, and the Los Angeles County Museum of Art, in collaboration with the Philadelphia Museum of Art. It drew some 420,000 visitors in Paris before traveling to the Los Angeles County Museum of Art. The Philadelphia Museum of Art will be the only East Coast venue.

<h3>Barnes/Renoir Hotel Package </h3>

For the first time, two prestigious arts organization in the Philadelphia region, the Philadelphia Museum of Art and the Barnes Foundation are creating a joint hotel package that will be available June 17th through August 2010.

The 181 Renoir paintings at the Barnes Foundation in addition to the works collected in the Late Renoir exhibition at the Philadelphia Museum of Art allows Philadelphia to boast the largest number of works by Renoir in any city in the world!

Three city hotels — the Four Seasons Hotel, Embassy Suites and Best Western Center City Hotel — are offering a one or two-night package that includes two untimed tickets to see the Late Renoir exhibition at the Philadelphia Museum of Art (June 17 – September 6, 2010), AND two untimed tickets to visit the Barnes Foundation as well as parking at the Barnes and 10% discount to the gift shop. ',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Exhibition')
					);
////post end///
////post start 6///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "image"			=> $dummy_image_path.'blog6.jpg',
				    "height"		=> '150',
					"width"			=> '150',
					"position"		=> 'left',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
				);
$blog_info[] = array(
					"post_title"	=>	'Free Library Festival',
					"post_content"	=>	'April 17-18, 2010
<h3>The Experience </h3>

Now in its fourth year, the Free Library Festival is the Library&acute;s annual burst of ideas and inspiration.

Well on its way to becoming a Philadelphia tradition, the Festival weekend is packed with free programming for all ages, including talks by bestselling authors, poetry readings, musical performances, tours of the Library&acute;s special collections and programs and activities just for children. A fun, free way to spend the day, the Free Library Festival connects book lovers from throughout the mid-Atlantic region.

For a full schedule of performances, view the Festival Program.
<h3>Meet the Authors </h3>

The Free Library will host more than 50 authors on-stage at the 2010 Free Library Festival, including Tina Campbell of the urban gospel duo Mary Mary, talk show host Chelsea Handler, Sapphire — author of Push, basis for the award-winning film Precious, Man Booker Prize winner Yann Martel, Edgar Award-winning mystery author Harlan Coben, Oprah Winfrey biographer Kitty Kelley, pop singer/songwriter Tommy James, a reading and performance by Antonino D’Ambrosio about the making of Johnny Cash&acute;s Bitter Tears album, New York Times bestselling novelist Chang-rae Lee, the story of a road trip with the late David Foster Wallace by David Lipsky, and many, many more.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Festival')
					);
////post end///
////post start 7///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "image"			=> $dummy_image_path.'blog7.jpg',
				    "height"		=> '150',
					"width"			=> '150',
					"position"		=> 'left',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
				);
$blog_info[] = array(
					"post_title"	=>	'A Weekend in Historic Philadelphia…on a Budget',
					"post_content"	=>	'So you&acute;re on vacation. Believe it or not, that doesn&acute;t mean you have to splurge!

In Historic Philadelphia, you&acute;ll find plenty of places where prices haven&acute;t changed much since our Founding Fathers were milling about town.

And we have put an entire weekend itinerary together for you, a step-by-step guide full of budget-conscious meals, fun stuff for the family and even a few cost-effective cocktails.

Welcome to Philadelphia, "America&acute;s best beer-drinking city." To start your vacation on the right foot — rather, the right barstool — head to The Khyber, a charmingly gritty bar in the middle of 2nd Street.

This is a great spot to get a casual burger and fries, knock back a few local microbrews and catch an up-and-coming live act. And for authentic Philadelphia attitude, you really can&acute;t do much better than The Khyber.

Just up the street is National Mechanics, a newer bar known for its gastropub-esque menu and quirky decor. Try a delicious salad or a gourmet burger — everything is tasty and light on your wallet.

From Old City, it&acute;s just a short, breezy walk down to Penn&acute;s Landing where, on Friday nights, you can catch free concerts all summer long. Ranging from gospel to jazz to R&B, the music is family-friendly and the scenery — the Delaware River to the east and the Philadelphia skyline to the west — is pretty much unbeatable.

Extra credit: If you visit Philadelphia for a mid-week stay, you can get cinematic on Thursday nights in the Summer with Penn&acute;s Landing&acute;s free Screenings Under the Stars.

And if you visit during the colder months, lace up and skate at the Blue Cross RiverRink. This ice rink comes equipped with a heated pavilion, snack bar and lessons for the whole family.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Budget')
					);
////post end///
////post start 8///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "image"			=> $dummy_image_path.'blog8.jpg',
				    "height"		=> '150',
					"width"			=> '150',
					"position"		=> 'left',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
				);
$blog_info[] = array(
					"post_title"	=>	'The Cleopatra Girlfriends Weekend Itinerary',
					"post_content"	=>	'Strong, shrewd, beautiful and beguiling, Cleopatra, the last Pharaoh to rule Egypt before the completion of the Roman conquest, has been portrayed reverently by historians and Hollywood alike, making her an enduring icon and role model to women. As such, the world debut of Cleopatra: The Search for the Last Queen of Egypt at The Franklin Institute, which runs from June 5, 2010 through January 2, 2011, will likely resonate with thousands of women who admire the ancient queen. It&acute;s also an ideal opportunity to gather friends together for a girlfriends’ getaway in Philly.
					
					<h3>Check In </h3>

Pamper yourselves like the royalty that you are by checking into one of 11 hotels offering the Cleopatra VIP Hotel Package. The package includes overnight accommodations for two and two VIP (untimed, bypass-the-line) tickets to the exhibition. Before you leave, dress in comfortable shoes and clothes that transition well from day to evening, as your day takes you from sightseeing to a sultry night out.

<h3>Diamonds Are A Girl&acute;s Best Friend </h3>

Take a pleasant walk through Washington Square, one of William Penn&acute;s original parks, to adorn your body in true Cleopatra fashion by picking up some baubles on Jewelers Row, the nation&acute;s oldest diamond district and also one of its largest. 
					',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Girlfriends')
					);
////post end///
////post start 9///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "image"			=> $dummy_image_path.'blog9.jpg',
				    "height"		=> '150',
					"width"			=> '150',
					"position"		=> 'left',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
				);
$blog_info[] = array(
					"post_title"	=>	'Celebrate the Harvest Season at the Peter Wentz Farmstead',
					"post_content"	=>	'Looking for some autumnal, harvest-y activities to do with friends or family over the next few weeks? Consider paying a visit to the Peter Wentz Farmstead in Worcester, PA. Each fall, they host a series of weekend festivals. First up is an event that&acute;s part of their Laerenswaert series, this Saturday, September 11th. A German phrase that means “worth learning,” they&acute;ll be focusing in on the Farmstead&acute;s Colonial gardens from 1-3 p.m.

On Saturday, September 25th, they&acute;ll be showcasing the Fall Harvest, 18th century-style. Demonstrations will include preserving fruits and vegetables, apple cider pressing and the breaking, scutching and combing of flax, to eventually being spun into linen thread. This event runs 10 a.m. to 3 p.m.

The Peter Wentz Farmstead was built in 1758 and served as George Washington&acute;s headquarters during his attempt to keep the British out of Philadelphia in the fall of 1777. Currently, it is run by Montgomery County as a fully restored historical site and admission is free.
					',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Celebrate')
					);
////post end///
////post start 10///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "image"			=> $dummy_image_path.'blog10.jpg',
				    "height"		=> '150',
					"width"			=> '150',
					"position"		=> 'left',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
				);
$blog_info[] = array(
					"post_title"	=>	'A Weekend on the Parkway',
					"post_content"	=>	'The Benjamin Franklin Parkway, or simply "the Parkway," is in many ways the cultural heart of Philadelphia. Designed in 1917 to emulate the Champs-Elysées, the Parkway has been host to the nation&acute;s oldest Thanksgiving Parade, Live 8, a free Bruce Springsteen concert and Sunoco Welcome America!, Philadelphia&acute;s July 4th party.

Lined with flags from around the world, the Parkway begins at City Hall and ends dramatically at the Philadelphia Museum of Art. Between these two points, you&acute;ll discover 4,000-year-old books, 120 sculptures by Auguste Rodin, America&acute;s most historic prison and much, much more.

Since water is the theme, seafood is especially apt for ordering — we recommend the Mediterranean-influenced grilled octopus. Thirsty? You&acute;re at the right place. In addition to a generous wine list, the restaurant offers an international list of waters to try.

After dinner, step outside to enjoy the promenade along the river, the sculptural gardens and the illuminated Philadelphia skyline.
					',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Weekend')
					);
////post end///



/// Attractions ////post start 1///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/a1.jpg";
$image_array[] = "dummy/a2.jpg";
$image_array[] = "dummy/a3.jpg";
$image_array[] = "dummy/a4.jpg";
$image_array[] = "dummy/a5.jpg";
$image_array[] = "dummy/a6.jpg";
$image_array[] = "dummy/a7.jpg";
$image_array[] = "dummy/a8.jpg";
$image_array[] = "dummy/a9.jpg";
$image_array[] = "dummy/a10.jpg";
$image_array[] = "dummy/a11.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '6th and Race Streets Philadelphia, PA 19103',
					"geo_latitude"	=> '39.95458942498639',
					"geo_longitude"	=> '-75.14953136444092',
					"timing"		=> 'Open today until 5 p.m., Sunday 10 am to 9 pm',
					"contact"		=> '(111) 677-4444',
					"email"			=> 'info@franklinsq.com',
					"website"		=> 'http://franklinsquare.com',
					"twitter"		=> 'http://twitter.com/franklinsquare',
					"facebook"		=> 'http://facebook.com/franklinsquare',
					"is_featured"	=> '1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '2',
					
					
				);
$post_info[] = array(
					"post_title"	=>	'Franklin Square',
					"post_content"	=>	' <h3> Location </h3>

6th and Race Streets in Historic Philadelphia
<h3>The Experience</h3>

One of Philadelphia&acute;s newest historic attractions is also one of its oldest.

Franklin Square, one of the five public squares that William Penn laid out in his original plan for the city, has undergone a dramatic renovation.

The park now boasts several all new, family-friendly attractions, including a miniature golf course, a classic carousel, storytelling benches, a picnic area and more.

<h3>Mini Golf </h3>

At Philly Mini Golf, an 18-hole miniature golf course decorated with some of Philadelphia&acute;s favorite icons, play a round of putt-putt and learn a little history at the same time.
<h3>Carousel </h3>

Close your eyes and take a nostalgic ride on the Philadelphia Park Liberty Carousel, a classic tribute to Philadelphia&acute;s great heritage of carousel-making. It&acute;s sure to be a instant kid favorite.
Storytelling Benches

Then catch up on your history at one of the storytelling benches located throughout the park, where you can hear tales of Franklin Square&acute;s past, or learn about the many communities touched by the Square, courtesy of the friendly storytellers of Once Upon a Nation.
<h3>Fountain</h3>

And emanating from the corners of the historic park, four new herringbone brick walking paths with nighttime lighting bring even more charm to the Square after dark. The paths lead to the centerpiece of the Square, the Franklin Square Fountain, a marble masterpiece built in 1838 surrounded by wrought iron fences, which is currently still going under cosmetic restoration.
<h3>The History </h3>

Originally named “North East Publick Square,” the 7.5-acre green is one of five original squares that William Penn laid out in his original plan of the city in 1682. The Square was renamed in honor of Benjamin Franklin in 1825.

Over the years, the area has been used as a cattle pasture, a horse and cattle market, a burial ground, a drill and parade ground for the American military during the War of 1812 and, finally, a city park.

In 1837, the city made Franklin Square into a public park and an elegant fountain was constructed in its center, a fountain thought to be the oldest surviving fountain in William Penn&acute;s five historic squares. The others are Rittenhouse, Washington, Logan and Center Square, where City Hall is now located.
<h3>SquareBurger </h3>

Just in time for summer, Franklin Square has opened SquareBurger, a Stephen Starr-run “burger shack” selling summer staples: hot dogs, fries, milkshakes (made with Tasty Kakes) and, of course, hamburgers and cheeseburgers.

SquareBurger is open until October - perfect for a couple bites between rounds of miniature golf!',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Attractions','Feature'),
					"post_tags"		=>	array('Tags','Sample Tags')
					);
////post end///
/// Attractions ////post start 2///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/a6.jpg";
$image_array[] = "dummy/a1.jpg";
$image_array[] = "dummy/a3.jpg";
$image_array[] = "dummy/a4.jpg";
$image_array[] = "dummy/a5.jpg";
$image_array[] = "dummy/a2.jpg";
$image_array[] = "dummy/a7.jpg";
$image_array[] = "dummy/a8.jpg";
$image_array[] = "dummy/a9.jpg";
$image_array[] = "dummy/a10.jpg";
$image_array[] = "dummy/a11.jpg";
$post_meta = array(
				   "video"			=> '',
				   "address"		=> '4231 Avenue of the Republic, Memorial Hall in Fairmount Park, Philadelphia, PA 19131',
					"geo_latitude"	=> '39.976100622540024',
					"geo_longitude"	=> '-75.2053427696228',
					"timing"		=> 'Open today until 1 p.m., Sunday 10 am to 9 pm',
					"contact"		=> '(222) 777-1111',
					"email"			=> 'info@pleasetouchmuseum.com',
					"website"		=> 'http://pleasetouchmuseum.com',
					"twitter"		=> 'http://twitter.com/pleasetouchmuseum',
					"facebook"		=> 'http://facebook.com/pleasetouchmuseum',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Please Touch Museum',
					"post_content"	=>	'<h3>New Location! </h3>

Who doesn&acute;t love the Please Touch Museum? And now, taking kids to the Museum is better than ever. The nation&acute;s premier children&acute;s museum - which has been a beloved landmark since it opened in 1976 - has a new home in Fairmount Park, opening its doors to a world of educational, hands-on fun.

The new location in Memorial Hall - a National Historic Landmark built in 1876 for the Centennial Exhibition celebrating the country&acute;s 100th birthday - will boast three times more space for exhibitions and programs.

Just outside the museum, kids and adults will also delight in riding the meticulously restored 1908 Woodside Park Dentzel Carousel, built in Philadelphia for a now-defunct amusement park 10 blocks from Memorial Hall.

Visit The Please Touch Museum for more info!
<h3>The Experience </h3>

The city&acute;s award-winning children&acute;s museum is fun-filled, totally hands-on, and so delightful that adults are entertained, too. Each nook and cranny has a different theme - from the fantastic to the practical. In Alice&acute;s Adventures in Wonderland, kids can play croquet with the Queen and sip tea with the Mad Hatter; nearby, oversized props bring Maurice Sendak&acute;s classics to life.

Kids can take the wheel of a real bus and sail a boat on a mini-Delaware River; in “Nature&acute;s Pond,” the youngest visitors (age 3 and under) can discover animals nestled among high grass and a lily pond, or enjoy stories and nursery rhymes in “Fairytale Garden.” Please Touch is also a first live theater experience for young children - Please Touch Playhouse performances are original and interactive and take place daily!

Please Touch Museum tends to be busier on rainy days. You may want to schedule your visit on fair weather days. Mornings are also a busy time with most school groups visiting during this time. Afternoons are a great time to visit the museum as well as Mondays when groups are not scheduled.
<h3>History </h3>

One of the lasting museums from the tourist upgrade of Philadelphia that coincided with the 1976 Bicentennial celebration, Please Touch Museum® filled a gap in the city&acute;s cultural scene. Other museums in the area certainly have sections for children, but Please Touch Museum&acute;s new home not only offers three toddler areas, but also exciting exhibit components for older siblings (for ages 7 and up).
<h3>Visiting Tips </h3>

Please Touch Museum tends to be busier on rainy days. You may want to schedule your visit on fair weather days. Mornings are also a busy time with most school groups visiting during this time. Afternoons are a great time to visit the museum as well as Mondays when groups are not scheduled.
<h3>Insider Tip </h3>

The museum has a full schedule of craft activities and music, dance and storytelling performances, which are entertaining for both kids and adults.
<h3>Great Kids’ Stuff </h3>

In The Supermarket, kids take control: They can stock the shelves, load their cart and ring up the order.
Buy Tickets Online In Advance

You can buy admission tickets to the Please Touch Museum online through our partners at the Independence Visitor Center. Just click the button below.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Attractions'),
					"post_tags"		=>	array('Tags','Sample Tags')
					);
////post end///
/// Attractions ////post start 3///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/a9.jpg";
$image_array[] = "dummy/a10.jpg";
$image_array[] = "dummy/a3.jpg";
$image_array[] = "dummy/a4.jpg";
$image_array[] = "dummy/a5.jpg";
$image_array[] = "dummy/a2.jpg";
$image_array[] = "dummy/a7.jpg";
$image_array[] = "dummy/a8.jpg";
$image_array[] = "dummy/a6.jpg";
$image_array[] = "dummy/a1.jpg";
$image_array[] = "dummy/a11.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '1001 Longwood Road, Kennett Square, PA 19348, (610) 388-1000',
					"geo_latitude"	=> '39.976100622540024',
					"geo_longitude"	=> '-75.2053427696228',
					"timing"		=> 'Open today until 10 a.m., Sunday 9 am to 9 pm',
					"contact"		=> '(111) 888-1111',
					"email"			=> 'info@longwoodgardens.com',
					"website"		=> 'http://longwoodgardens.com',
					"twitter"		=> 'http://twitter.com/longwoodgardens',
					"facebook"		=> 'http://facebook.com/longwoodgardens',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Longwood Gardens',
					"post_content"	=>	'<h3>The Experience </h3>

When you&acute;re at Longwood Gardens, it&acute;s easy to imagine that you&acute;re at a giant, royal garden in Europe. Stroll along the many paths through acres of exquisitely maintained grounds featuring 11,000 different types of plants.

Encounter a new vista at each turn: the Italian Water Garden, Flower Garden Walk, aquatic display gardens and many others. Amble through Peirce&acute;s Woods, eight outdoor “rooms” of distinct woodland habitats.

Inside the Conservatory is a lush world of exotic flowers, cacti, bromeliads, ferns and bonsai. Each season brings a different pleasure: spring magnolias and azaleas; summer roses and water lilies; fall foliage and chrysanthemums; and winter camellias, orchids and palms.

On land Quaker settler George Peirce purchased from William Penn, Peirce&acute;s grandsons planted an impressive arboretum. The presence of a sawmill on the property prompted industrialist Pierre Samuel du Pont to buy the land in 1906 to save the trees.

Christmas is spectacularly celebrated with carillon concerts, poinsettias and thousands of lights; summer evenings are embellished with concerts, illuminated fountain displays and occasional fireworks.
<h3>Come Prepared </h3>

Longwood Gardens is open daily, year-round.
<h3>Don&acute;t Miss </h3>

Indoor Children&acute;s Garden - Surrounded by tree-covered seating and Longwood&acute;s famous fountains, the new Indoor Children&acute;s Garden provides a safe and engaging space where children can learn about nature with amazing plants and fun activities around every corner.

The Garden features a Central Cove, a Rain Pavilion and a Bamboo Maze, filled with a jungle of tree-sized bamboos for children to explore.
<h3>Outsider&acute;s Tip </h3>

There are 17 fountains in the Indoor Children&acute;s Garden to enjoy, where children will want to splash and play. An extra shirt or small towel might come in handy!
<h3>Buy Tickets Online In Advance </h3>

You can buy admission tickets to Longwood Gardens online through our partners at the Independence Visitor Center. Just click the button below.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Attractions'),
					"post_tags"		=>	array('wood','garden')
					);
////post end///
/// Attractions ////post start 4///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/a11.jpg";
$image_array[] = "dummy/a10.jpg";
$image_array[] = "dummy/a3.jpg";
$image_array[] = "dummy/a4.jpg";
$image_array[] = "dummy/a5.jpg";
$image_array[] = "dummy/a2.jpg";
$image_array[] = "dummy/a7.jpg";
$image_array[] = "dummy/a8.jpg";
$image_array[] = "dummy/a6.jpg";
$image_array[] = "dummy/a1.jpg";
$image_array[] = "dummy/a9.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '3400 West Girard Avenue, (34th St. and Girard Ave.), Philadelphia, PA 19104',
					"geo_latitude"	=> '39.97494958308448',
					"geo_longitude"	=> '-75.19549369812012',
					"timing"		=> 'Open today until 11.30 a.m., Sunday 11 am to 7 pm',
					"contact"		=> '(211) 143-1900',
					"email"			=> 'info@philadelphiazoo.com',
					"website"		=> 'http://philadelphiazoo.com',
					"twitter"		=> 'http://twitter.com/philadelphiazoo',
					"facebook"		=> 'http://facebook.com/philadelphiazoo',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'The Philadelphia Zoo',
					"post_content"	=>	'<h3>The Zoo 150th Birthday</h3>

The Philadelphia Zoo celebrated its 150th anniversary in 2009. So stop by and celebrate this major achievement at America&acute;s first zoo!

<h3>McNeil Avian Center </h3>

On May 30, 2009 the 17.5-million McNeil Avian Center opened to the public.

This new aviary incorporates lush, walk-through habitats where visitors can discover more than 100 spectacular birds from around the world, many of them rare and endangered. And in the multi-sensory 4-D Migration Theater, viewers can follow Otis the Oriole on his first migration south from where he hatched in Fairmount Park.


<h3>The Experience at the Zoo</h3>

One of the best laid-out and most animal-packed zoos in the country is set among a charming 42-acre Victorian garden with tree-lined walks, formal shrubbery, ornate iron cages and animal sculptures. The zoo has garnered many “firsts” in addition to being the first zoo charted in the United States (1859).

The first orangutan and chimp births in a U.S. zoo (1928), world&acute;s first Children&acute;s Zoo (1957), and the first U.S. exhibit of white lions (1993), among others.

In addition to its animals, the zoo is known for its historic architecture, which includes the country home of William Penn&acute;s grandson, its botanical collections of over 500 plant species, its groundbreaking research and its fine veterinary facilities.
Big Cat Falls

The highly anticipated pride of the Philadelphia Zoo, Bank of America Big Cat Falls, home to felines from around the world, opened in 2006. The lush new exhibition features waterfalls, pools, authentic plantings and a simulated research station for aspiring zoologists.

Lions, leopards, jaguars, pumas, tigers and seven new cubs are the star attractions.
<h3>Visitor Details </h3>

Open daily, year-round. Parking can be tight so public transit is a great option.

Check out the Zoo&acute;s trolley shuttle, available through October, making hourly stops at the Independence Visitor Center and 30th Street Station. Service is available starting at 10 a.m. seven days a week through August 31, 2008, with weekends-only service in September and October.

SEPTA Routes 15 and 32 Buses stop within blocks of the zoo. Find specific stops and schedules here.
<h3>History</h3>

The nation&acute;s oldest zoo was chartered in 1859, but the impending Civil War delayed its opening until 1874. In addition to its animals, the zoo is known for its historic architecture, which includes the country home of William Penn&acute;s grandson; its botanical collections of over 500 plant species; its groundbreaking research and its fine veterinary facilities.

The Primate Reserve, Carnivore Kingdom, and Rare Animal Conservation Center, with its tree kangaroos and blue-eyed lemurs, are brand new, but there&acute;s still fun to be had in the historic, old-style bird, pachyderm and carnivore houses. In the Treehouse, kids can investigate the world from an animal&acute;s perspective; outdoors, the Zoo Balloon lifts passengers 400 feet into the air for a bird&acute;s-eye view of the zoo.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Attractions'),
					"post_tags"		=>	array('wood','garden')
					);
////post end///
/// Attractions ////post start 5///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/a12.jpg";
$image_array[] = "dummy/a13.jpg";
$image_array[] = "dummy/a3.jpg";
$image_array[] = "dummy/a4.jpg";
$image_array[] = "dummy/a5.jpg";
$image_array[] = "dummy/a2.jpg";
$image_array[] = "dummy/a7.jpg";
$image_array[] = "dummy/a8.jpg";
$image_array[] = "dummy/a6.jpg";
$image_array[] = "dummy/a1.jpg";
$image_array[] = "dummy/a9.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '525 Arch Street, Philadelphia, PA 19106',
					"geo_latitude"	=> '39.952730724095574',
					"geo_longitude"	=> '-75.14914512634277',
					"timing"		=> 'Open today until 9.30 a.m., Sunday 11 am to 7 pm',
					"contact"		=> '(111) 111-1111',
					"email"			=> 'info@ncc.com',
					"website"		=> 'http://ncc.com',
					"twitter"		=> 'http://twitter.com/ncc',
					"facebook"		=> 'http://facebook.com/ncc',
					"is_featured"	=> '1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '2',
				);
$post_info[] = array(
					"post_title"	=>	'National Constitution Center',
					"post_content"	=>	'<h3>The Experience</h3>

It only four pages long, but the U.S. Constitution is among the most influential and important documents in the history of the world.

The 160,000-square-foot National Constitution Center explores and explains this amazing document through high-tech exhibits, artifacts, and interactive displays. The Kimmel Theater, a 350-seat star-shaped theater, features Freedom Rising, a multimedia production combining film, a live actor and video projection on a 360° screen to tell the stirring story of We the people.

Then experience it yourself: don judicial robes to render your opinion on key Supreme Court cases, then take the Presidential oath of the office.

In Signers Hall, where life-size bronze figures of the Constitution&acute;s signers and dissenters are displayed, visitors can choose to sign or dissent.

One of the rare original public copies of the Constitution is on display.
<h3>History </h3>

Freedom of speech, protection from unlawful search and seizure, and other individual rights were not part of the original Constitution. Recognizing its imperfections, the authors built in a mechanism to amend the Constitution, making it adaptable for unknown eventualities.

The first ten amendments guaranteeing numerous personal freedoms - The Bill of Rights - were not ratified until 1791.
<h3>Insider Tip </h3>

While the Center hosts amazing evergreen presentations, take a look at the Events Calendar for the latest premiere or traveling exhibit.
<h3>Kids Stuff </h3>

The Center frequently hosts special events with a focus on children that include informative and engaging hands-on activities. For specific information, check out the Center website.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Attractions','Feature'),
					"post_tags"		=>	array('Tag','Center')
					);
////post end///
/// Attractions ////post start 6///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/a14.jpg";
$image_array[] = "dummy/a13.jpg";
$image_array[] = "dummy/a3.jpg";
$image_array[] = "dummy/a4.jpg";
$image_array[] = "dummy/a5.jpg";
$image_array[] = "dummy/a2.jpg";
$image_array[] = "dummy/a7.jpg";
$image_array[] = "dummy/a8.jpg";
$image_array[] = "dummy/a6.jpg";
$image_array[] = "dummy/a1.jpg";
$image_array[] = "dummy/a9.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> 'Debbie and North Wood Drive, Coatesville, PA 19063',
					"geo_latitude"	=> '39.95185892663003',
					"geo_longitude"	=> '-75.84136962890625',
					"timing"		=> 'Open today until 12.30 p.m., Sunday 12 pm to 7 pm',
					"contact"		=> '(222) 999-9999',
					"email"			=> 'info@swp.com',
					"website"		=> 'http://swp.com',
					"twitter"		=> 'http://twitter.com/swp',
					"facebook"		=> 'http://facebook.com/swp',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Sadsbury Woods Preserve',
					"post_content"	=>	'A more than 500-acre nature preserve ideal for walking and hiking, Sadsbury Woods is also an important habitat for interior nesting birds and small mammals. An increasingly rare area of interior woodlands, defined as an area at least 300 feet from any road, lawn or meadow, provides a critical habitat for many species of birds, especially neo-tropical migrant songbirds.

Situated on the western edge of Chester County, the land remains much as it did centuries ago, and now serves as a permanent refuge in an area facing dramatically increasing development pressure.

The colorful birds that breed in the forest during the spring and summer months fly to South America for the winter. To survive here, they need abundant food and protection from the weather and predators, something they&acute;re able to find in Sadsbury Woods. A recent bird count identified more than 40 different species in just one morning.

The preserve has been assembled from more than one dozen parcels, an effort that was made possible thanks to landowners who were willing to sell their land for conservation purposes. One such landowner recalled exploring these woods as a child and wanted to ensure that his grandchildren and great-grandchildren would be able to do the same. Natural Lands Trust is working to expand the preserve, and hopes to eventually protect a total of 600 acres.
Support the Natural Lands Trust

The Natural Lands Trust seeks volunteers and members to help protect and care for Sadsbury Woods and its many other natural areas. Members are invited to dozens of outings each year including canoe trips, bird walks, hikes and much more. 
Come Prepared

The preserve is open from sunrise to sunset. Pets must be leashed. Alcoholic beverages, motorized vehicles and mountain bikes are not permitted. Horseback riders are welcome, but you must ride in, because there nowhere to park a trailer. Maps and other material are available in the kiosk by the parking area.
Outsider Tip

The deep forest is a great place for spotting neo-tropical songbirds in the spring and summer months',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Attractions'),
					"post_tags"		=>	array('sample','tags')
					);
////post end///
/// Attractions ////post start 7///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/a15.jpg";
$image_array[] = "dummy/a16.jpg";
$image_array[] = "dummy/a17.jpg";
$image_array[] = "dummy/a4.jpg";
$image_array[] = "dummy/a5.jpg";
$image_array[] = "dummy/a2.jpg";
$image_array[] = "dummy/a7.jpg";
$image_array[] = "dummy/a8.jpg";
$image_array[] = "dummy/a6.jpg";
$image_array[] = "dummy/a1.jpg";
$image_array[] = "dummy/a9.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '1500 John F Kennedy Blvd., Philadelphia, PA 19102',
					"geo_latitude"	=> '39.953618959141515',
					"geo_longitude"	=> '-75.16541004180908',
					"timing"		=> 'Open today until 10.30 a.m., Sunday 10 am to 7 pm',
					"contact"		=> '(222) 999-9999',
					"email"			=> 'info@mwwalls.com',
					"website"		=> 'http://museumwithoutwallsaudio.org/',
					"twitter"		=> 'http://twitter.com/mwwalls',
					"facebook"		=> 'http://facebook.com/mwwalls',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Museum Without Walls',
					"post_content"	=>	'<h3>The Experience </h3>

Museum Without Walls: AUDIO is a multi-platform, interactive audio tour, designed to allow locals and visitors alike to experience Philadelphia extensive collection of public art and outdoor sculpture along the Benjamin Franklin Parkway and Kelly Drive. This innovative program invites passersby to stop, look, listen and see this city public art in a new way. Discover the untold histories of the 51 outdoor sculptures at 35 stops through these professionally produced three-minute interpretive audio segments. The many narratives have been spoken by more than 100 individuals, all with personal connections to the pieces of art.

Works in Museum Without Walls: AUDIO include the sculpture Jesus Breaking Bread, which is located in front of the Cathedral Basilica of Saints Peter and Paul at 18th and Race Streets. The sculpture&acute;s audio program features the voices of three people who are each intimately, yet distinctly, connected to the piece. Listeners can hear Martha Erlebacher, the wife of the now-deceased sculptor and an artist herself, recall the personal challenge Walter Erlebacher set to humanize the figure. Monsignor John Miller, who oversaw the commission of the sculpture for the Archdiocese of Philadelphia, discusses the artist confrontation with historic interpretation, and Sister Mary Scullion, who runs the renowned program for the homeless in Philadelphia, Project H.O.M.E., and who also attended the sculpture dedication as a student, talks about the importance of placing the figure outside of the church.

In the audio program for the sculpture Iroquois, listeners will hear a first-person account from Mark di Suvero, the artist himself, who discusses the abstract sculpture and its open shapes that invite public interaction and viewing from multiple angles. I think that in order to experience [Iroquois] … you have to walk in through the piece, you have to have it all the way around you and at that moment, you can feel what that sculpture can do, says di Suvero. Lowell McKegney, di Suvero construction manager and longtime friend, compares the sculpture to music and encourages listeners to appreciate it in the same way.
<h3>History </h3>

Philadelphia has more outdoor sculpture than any other American city, yet this extensive collection often goes unnoticed. This program is intended to reveal the distinct stories behind each of these works, that have become visual white noise for so many of the city residents and visitors. ',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Attractions'),
					"post_tags"		=>	array('Museum')
					);
////post end///
/// Attractions ////post start 8///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/a18.jpg";
$image_array[] = "dummy/a10.jpg";
$image_array[] = "dummy/a3.jpg";
$image_array[] = "dummy/a4.jpg";
$image_array[] = "dummy/a5.jpg";
$image_array[] = "dummy/a2.jpg";
$image_array[] = "dummy/a7.jpg";
$image_array[] = "dummy/a8.jpg";
$image_array[] = "dummy/a6.jpg";
$image_array[] = "dummy/a1.jpg";
$image_array[] = "dummy/a9.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '701 Arch Street Philadelphia, PA 19106 ',
					"geo_latitude"	=> '39.952977457209876',
					"geo_longitude"	=> '-75.15156984329224',
					"timing"		=> 'Open today until 11.30 a.m., Sunday 1 pm to 7 pm',
					"contact"		=> '(777) 777-7777',
					"email"			=> 'info@aampmuseum.com',
					"website"		=> 'http://www.aampmuseum.org/',
					"twitter"		=> 'http://twitter.com/aampmuseum',
					"facebook"		=> 'http://facebook.com/aampmuseum',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Audacious Freedom',
					"post_content"	=>	'Audacious Freedom, the major, new exhibit at the African American Museum in Philadelphia , explores the lives of people of African descent living in Philadelphia between 1776 and 1876.

Discover how African Americans in Philadelphia lived and worked while helping to shape the young nation in its formative stages.

Exhibit themes include entrepreneurship, environment, education, religion and family traditions of the African American population, played out through interactive displays, video projections and vivid photography.

The groundbreaking exhibit allows visitors to “walk the streets” of Historic Philadelphia using a large-scale map. Young children can join the action with Children&acute;s Corner, which highlights the daily lives of children during that period.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Attractions'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
/// Attractions ////post start 9///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/a19.jpg";
$image_array[] = "dummy/a20.jpg";
$image_array[] = "dummy/a3.jpg";
$image_array[] = "dummy/a4.jpg";
$image_array[] = "dummy/a5.jpg";
$image_array[] = "dummy/a2.jpg";
$image_array[] = "dummy/a7.jpg";
$image_array[] = "dummy/a8.jpg";
$image_array[] = "dummy/a6.jpg";
$image_array[] = "dummy/a1.jpg";
$image_array[] = "dummy/a9.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '600 Chestnut Street Philadelphia, PA 19106',
					"geo_latitude"	=> '39.94911186949528',
					"geo_longitude"	=> '-75.15075445175171',
					"timing"		=> 'The center is open year round, 9 a.m. – 5 p.m., with extended hours in the summer.',
					"contact"		=> '(777) 666-6666',
					"email"			=> 'info@nps.com',
					"website"		=> 'http://www.nps.gov/inde',
					"twitter"		=> 'http://twitter.com/nps',
					"facebook"		=> 'http://facebook.com/nps',
					"is_featured"	=> '1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '2',
				);
$post_info[] = array(
					"post_title"	=>	'The Liberty Bell Center',
					"post_content"	=>	'<h3>The Experience </h3>

The Liberty Bell has a new home, and it is as powerful and dramatic as the Bell itself. Throughout the expansive, light-filled Center, larger-than-life historic documents and graphic images explore the facts and the myths surrounding the Bell.

X-rays give an insider&acute;s view, literally, of the Bell&acute;s crack and inner-workings. In quiet alcoves, a short History Channel film, available in English and eight other languages, traces how abolitionists, suffragists and other groups adopted the Bell as its symbol of freedom.

Other exhibits show how the Bell&acute;s image was used on everything from ice cream molds to wind chimes. Keep your camera handy. Soaring glass walls offer dramatic and powerful views of both the Liberty Bell and Independence Hall, just a few steps away.
<h3>History</h3>

The bell now called the Liberty Bell was cast in the Whitechapel Foundry in the East End of London and sent to the building currently known as Independence Hall, then the Pennsylvania State House, in 1753.

It was an impressive looking object, 12 feet in circumference around the lip with a 44-pound clapper. Inscribed at the top was part of a Biblical verse from Leviticus, “Proclaim Liberty throughout all the Land unto all the Inhabitants thereof.”

Unfortunately, the clapper cracked the bell on its first use. A couple of local artisans, John Pass and John Stow, recast the bell twice, once adding more copper to make it less brittle and then adding silver to sweeten its tone. No one was quite satisfied, but it was put in the tower of the State House anyway.
<h3>Fast Facts </h3>

The Liberty Bell is composed of approximately 70 percent copper, 25 percent tin and traces of lead, zinc, arsenic, gold and silver.

The Bell is suspended from what is believed to be its original yoke, made of American elm.

The Liberty Bell weighs 2,080 pounds. The yoke weighs about 100 pounds.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Attractions','Feature'),
					"post_tags"		=>	array('')
					);
////post end///
/// Attractions ////post start 10///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/a19.jpg";
$image_array[] = "dummy/a20.jpg";
$image_array[] = "dummy/a3.jpg";
$image_array[] = "dummy/a4.jpg";
$image_array[] = "dummy/a5.jpg";
$image_array[] = "dummy/a2.jpg";
$image_array[] = "dummy/a7.jpg";
$image_array[] = "dummy/a8.jpg";
$image_array[] = "dummy/a6.jpg";
$image_array[] = "dummy/a1.jpg";
$image_array[] = "dummy/a9.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '18th and Walnut Streets Philadelphia, PA 19103',
					"geo_latitude"	=> '39.94911186949528',
					"geo_longitude"	=> '-75.15073299407959',
					"timing"		=> 'The center is open year round, 9 a.m. – 5 p.m., with extended hours in the summer.',
					"contact"		=> '(777) 666-6666',
					"email"			=> 'info@fairmountpark.com',
					"website"		=> 'http://www.fairmountpark.org/rittenhousesquare.asp',
					"twitter"		=> 'http://twitter.com/fairmountpark',
					"facebook"		=> 'http://facebook.com/fairmountpark',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Rittenhouse Square',
					"post_content"	=>	'

Unlike the other squares, the early Southwest Square was never used as a burial ground, although it offered pasturage for local livestock and a convenient dumping spot for “night soil”.
<h3> History </h3>

By the late 1700s the square was surrounded by brickyards as the area&acute;s clay terrain was better suited for kilns than crops. In 1825 the square was renamed in honor of Philadelphian David Rittenhouse, the brilliant astronomer, instrument maker and patriotic leader of the Revolutionary era.

A building boom began by the 1850s, and in the second half of the 19th century the Rittenhouse Square neighborhood became the most fashionable residential section of the city, the home of Philadelphia&acute;s “Victorian aristocracy.” Some mansions from that period still survive on the streets facing the square, although most of the grand homes gave way to apartment buildings after 1913.

In 1816, local residents loaned funds to the city to buy a fence to enclose Rittenhouse Square. In the decade before the Civil War, the Square boasted not only trees and walkways, but also fountains donated by local benefactors – prematurely, it turned out, for the fountains created so much mud that City Council ordered them removed. The square&acute;s present layout dates from 1913, when the newly formed Rittenhouse Square Improvement Association helped fund a redesign by Paul Philippe Cret, a French-born architect who contributed to the design of the Benjamin Franklin Parkway and the Rodin Museum. Although some changes have been made since then, the square still reflects Cret&acute;s original plan.

<h3>Layout </h3>

The main walkways are diagonal, beginning at the corners and meeting at a central oval. The plaza, which contains a large planter bed and a reflecting pool, is surrounded by a balustrade and ringed by a circular walk. Classical urns, many bearing relief figures of ancient Greeks, rest on pedestals at the entrances and elsewhere throughout the square. Ornamental lampposts contribute to an air of old-fashioned gentility. A low fence surrounds the square, and balustrades adorn the corner entrances. Oaks, maples, locusts, plane trees, and others stand within and around the enclosure, and the flowerbeds and blooming shrubs add a splash of color in season.

Rittenhouse Square is the site of annual flower markets and outdoor art exhibitions. More than any of the other squares, it also functions as a neighborhood park. Office workers eat their lunches on the benches; parents bring children to play; and many people stroll through to admire the plants, sculptures, or the fat and saucy squirrels.

<h3>Public Art </h3>

Like Logan Square, you can see several of the city&acute;s best-loved outdoor sculptures in Rittenhouse Square. The dramatic Lion Crushing a Serpent by the French Romantic sculptor Antoine-Louis Barye is in the central plaza. Originally created in 1832, the work is Barye&acute;s allegory of the French Revolution of 1830, symbolizing the power of good (the lion) conquering evil (the serpent). This bronze cast was made about 1890.

At the other end of the central plaza, within the reflecting pool, is Paul Manship&acute;s Duck Girl of 1911, a lyrical bronze of a young girl carrying a duck under one arm – an early work by the same sculptor who designed the Aero Memorial for Logan Square. A favorite of the children is Albert Laessle&acute;s Billy, a two-foot-high bronze billy goat in a small plaza halfway down the southwest walk. Billy&acute;s head, horns, and spine have been worn to a shiny gold color by countless small admirers.

In a similar plaza in the northeast walkway stands the Evelyn Taylor Price Memorial Sundial, a sculpture of two cheerful, naked children who hold aloft a sundial in the form of a giant sunflower head. Created by Philadelphia artist Beatrice Fenton, the sundial memorializes a woman who served as the president of the Rittenhouse Square Improvement Association and Rittenhouse Square Flower Association. In the flower bed between the sundial and the central plaza is Cornelia Van A. Chapin&acute;s Giant Frog, a large and sleek granite amphibian. Continuing the animal theme, two small stone dogs, added in 1988, perch on the balustrades at the southwest corner entrance.

<h3>At Night </h3>

Once predominantly a daytime destination, Rittenhouse Square is now a popular nightspot as well, with a string of restaurants - including Rouge, Devon, Parc and Barclay Prime - that have sprouted up along the east side of the park on 18th Street.

So these days, you can take in the serenity of the natural landscape from a park bench in the sunshine and then sip cocktails under the stars at one of many candlelit outdoor tables.

Meanwhile, several more restaurants, bars and clubs have opened along the surrounding blocks in recent years, like Parc, Tria, Continental Midtown, Alfa, Walnut Room, and Twenty Manning just to name a few.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Attractions'),
					"post_tags"		=>	array('Museum')
					);
////post end///
/// Hotels ////post start 1///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels2.jpg";
$image_array[] = "dummy/hotels3.jpg";
$image_array[] = "dummy/hotels4.jpg";
$image_array[] = "dummy/hotels5.jpg";
$image_array[] = "dummy/hotels6.jpg";
$image_array[] = "dummy/hotels7.jpg";
$image_array[] = "dummy/hotels8.jpg";
$image_array[] = "dummy/hotels9.jpg";
$image_array[] = "dummy/hotels10.jpg";
$image_array[] = "dummy/hotels11.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '1200 Market Street, Philadelphia, PA 19107',
					"geo_latitude"	=> '39.951809579271405',
					"geo_longitude"	=> '-75.16021728515625',
					"timing"		=> 'Daily, 6:30 am – 12:00 pm',
					"contact"		=> '(111) 111-0000',
					"email"			=> 'info@loewshotels.com',
					"website"		=> 'http://www.loewshotels.com/en/hotels/philadelphia-hotel/overview.aspx',
					"twitter"		=> 'http://twitter.com/loewshotels',
					"facebook"		=> 'http://facebook.com/loewshotels',
					"is_featured"	=> '1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '2',
				);
$post_info[] = array(
					"post_title"	=>	'Loews Philadelphia Hotel',
					"post_content"	=>	'

<h3>OVERVIEW </h3>

One of the most important architectural works of the 20th Century, the PSFS (Philadelphia Savings Fund Society) Building has been converted into the new 585-room Loews Philadelphia Hotel. Designed by George Howe and William Lescaze, the building was erected in 1932 and was the first international style, modernist high-rise building.

Today, the building retains period details, such as Cartier clocks, bank vault doors and polished granite, as well as modern amenities such as a full service health spa, business center, spinning room, lap pool and over 40,000 square feet of multi-purpose space, including three ballrooms.

<h3>THE HOTEL </h3>

Loews Hotels is proud to have restored the landmark PSFS Building to its original grandeur, while transforming it into a hotel that people from all over the world can experience and enjoy.

The hotel takes full advantage of the building&acute;s historical features. The three-story former banking room has been preserved as Millennium Hall, a dramatic banquet space. The historic, rooftop boardroom has been converted to a spectacular setting for catered events.

The building retains period details, such as Cartier clocks, bank vault doors and polished granite, as well as modern amenities such as a full service health spa, business center, spinning room, lap pool and over 40,000 square feet of multi-purpose space, including three ballrooms.

Feel the comforts of home in accommodations that perfectly balance the contemporary with the elegant. Where every detail from the lofty ten-foot ceilings to the miles of spectacular views is designed to serve one purpose – yours. Whether you&acute;re working hard or playing hard, you can always rest easy.

The Loews is perfect for families. The hotel offers special kid-friendly programs and features dedicated to the principle: “the family that stays together plays together” (and that includes four-legged family members too).

Learn more about Loews Signature Family Travel Benefits.
DINING AT THE HOTEL

<h3>Solefood </h3>

SoleFood is a fusion of seafood and cutting edge culinary expertise, offering seafood inspired dishes at breakfast, lunch and dinner. Guests can enjoy a cozy table for two or make new friends at one of the communal tables featuring a center display of river rocks and candles.

In order to create a memorable culinary experience in an upscale, hip environment which mixes eclectic cool with classic style, Solefood Restaurant continues to create exciting food and drinks that are mixed with just the right amount of attitude. SoleFood has received local and regional accolades from the media including 2008 Best of Philadelphia Award, Philadelphia City Paper Best Bar and Best Seafood restaurant.

SoleFood features hard to find wines, served by the glass, bottle and half bottle for when a bottle is too much and a glass is too little.

Special Prix Fixe Dinner Offer

SoleFood is offering a special “Diversify your Palate” prix-fixe dinner menu through 2010. For $29, you get to choose an entree and two “investments,” which can be an appetizer, a glass of wine, a cocktail, a dessert or a draft beer.

To make a reservation at SoleFood restaurant please call (215) 231-7300 or visit opentable.com

<h3>Hours: </h3>

Breakfast: Daily, 6:30 am – 11:00 am
Brunch: Saturday & Sunday,11:30 am – 2:00 pm
Lunch: Monday – Friday, 11:30 am – 2:00 pm
Dinner: Daily, 5:30 pm – 10:00 pm

<h3>SoleFood Lounge & Happy Hour </h3>

SoleFood Lounge provides one of the best happy hour options in the city. Gather with your friends and take advantage of some great specials, including hors d’oeuvres, wines by the glass, draft beer, and a wide selection of martinis from 5 to 7 p.m. daily. The lounge is the perfect place to meet up with old friends and make new ones.

SoleFood Lounge has earned recognition for its creative bar menu that includes a wide array of signature drinks and one of the best martinis in Philly.

Solefood Lounge Hours: Daily, 11:30 am – 2:00 am
Lounge Menu is offered daily: 11:00 am – 12:00 am

Solstice and SoleFood Special Events & Private Parties

Solstice and SoleFood provide fabulous settings for receptions, private parties and meetings. Solstice Private Dining Room is a great place to host cocktails receptions, dinners and meetings.

SoleFood is available for private parties and events. The main dining room can accommodate up to 85 people; each of the two communal tables seats 16; The Bar and Lounge at SoleFood with its luxe decor and inviting banquettes and white leather chairs can accommodate 200 for cocktails.

Menus can be customized to meet your needs, including family-style.

<h3>Starbucks Morning Coffee Bar </h3>

Daily, 6:30 am – 10:30 am

SoleFood Restaurant is proud to be serving Starbucks. Come in and enjoy a fresh cup of coffee during your morning rush. The Coffee Bar also offer small breakfast items for your enjoyment.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Hotels','Feature'),
					"post_tags"		=>	array('')
					);
////post end///
/// Hotels ////post start 2///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/hotels5.jpg";
$image_array[] = "dummy/hotels2.jpg";
$image_array[] = "dummy/hotels3.jpg";
$image_array[] = "dummy/hotels4.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels6.jpg";
$image_array[] = "dummy/hotels7.jpg";
$image_array[] = "dummy/hotels8.jpg";
$image_array[] = "dummy/hotels9.jpg";
$image_array[] = "dummy/hotels10.jpg";
$image_array[] = "dummy/hotels11.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '1776 Benjamin Franklin Parkway, Philadelphia, PA 19103',
					"geo_latitude"	=> '39.95646452337266',
					"geo_longitude"	=> '-75.16884326934814',
					"timing"		=> 'Daily, 10:30 am – 10 pm',
					"contact"		=> '(111) 111-0000',
					"email"			=> 'info@embassysuites1.com',
					"website"		=> 'http://embassysuites1.hilton.com/en_US/es/hotel/PHLDTES-Embassy-Suites-Philadelphia-Center-City-Pennsylvania/index.do',
					"twitter"		=> 'http://twitter.com/embassysuites1',
					"facebook"		=> 'http://facebook.com/embassysuites1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Embassy Suites Philadelphia',
					"post_content"	=>	'
The newly renovated Embassy Suites Philadelphia – Center City hotel is conveniently situated in the heart of downtown Philadelphia, Pennsylvania and Philadelphia&acute;s Center City business district. This hotel in Philadelphia is located only eight miles from Philadelphia International Airport and just minutes from top Philadelphia attractions, including:

Philadelphia Museum of Art
Philadelphia City Hall
Philadelphia Zoo
Franklin Institute
Historic landmarks such as the Liberty Bell & Independence Hall
Pennsylvania Convention Center
University of Pennsylvania
Upon entering these suites at the Embassy Suites Philadelphia – Center City hotel, the spaciousness of the living room gives way to the warmth of each of the appointments. All of the newly renovated 288 two-room accommodations feature an entry foyer, queen-size sofa bed, and a range of in-suite amenities, including: well-lit work area, high-speed Internet access, dining area with balcony, kitchen area with microwave, coffee maker, refrigerator, and wet bar.

Guests of the Embassy Suites Philadelphia – Center City hotel in downtown Philadelphia are also welcome to enjoy a range of hotel-wide amenities and services, including: fitness center, hotel business center, and meeting rooms.

A delicious, complimentary cooked-to-order breakfast is offered each morning, and a hotel Manager&acute;s Reception every night – featuring complimentary refreshments and great company.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Hotels'),
					"post_tags"		=>	array('')
					);
////post end///
/// Hotels ////post start 3///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/hotels10.jpg";
$image_array[] = "dummy/hotels11.jpg";
$image_array[] = "dummy/hotels12.jpg";
$image_array[] = "dummy/hotels4.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels6.jpg";
$image_array[] = "dummy/hotels7.jpg";
$image_array[] = "dummy/hotels8.jpg";
$image_array[] = "dummy/hotels9.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '237 S. Broad Street, Philadelphia, PA 19107',
					"geo_latitude"	=> '39.94782877507232',
					"geo_longitude"	=> '-75.16427278518677',
					"timing"		=> 'Daily, 10:30 am – 10 pm',
					"contact"		=> '(111) 111-0000',
					"email"			=> 'info@doubletree1.com',
					"website"		=> 'http://doubletree1.hilton.com/en_US/dt/hotel/PHLBLDT-Doubletree-Hotel-Philadelphia-Pennsylvania/index.do',
					"twitter"		=> 'http://twitter.com/doubletree1',
					"facebook"		=> 'http://facebook.com/doubletree1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Doubletree Hotel Philadelphia',
					"post_content"	=>	'
With 434 rooms, the Doubletree Hotel is a great option for your upcoming stay in Philadelphia.

<h3>Location </h3>

Located right on the Avenue of the Arts at Broad and Locust Streets, this high rise occupies one of the city&acute;s most ideal locations. The Kimmel Center for the Performing Arts, the Academy of Music, and the Merriam and Wilma Theaters are all within a block.

To the west you have great shopping and dining in Rittenhouse Square. To the east are Philadelphia&acute;s famous historic attractions, South Street, Washington Square and Old City.

<h3>Guest Rooms </h3>

Spacious and well-appointed guest rooms offer paroramic views of the city, traditional décor, generous work areas and high-speed internet access. Other amenities include a restaurant, lounge and a health club with an indoor pool.

The Doubletree&acute;s spacious guest rooms are decorated in a warm contemporary style, which includes a Herman Miller ergonomic chair at an oversized desk featuring task lighting and easy-access power source. Work with ease and efficiency from your room, utilizing two dual-line telephones with data port, speakerphone, and private voicemail. High-speed internet access ensures productivity by providing you with quick and convenient access to email and the Internet.

All rooms feature the popular Sweet Dreams by Doubletree bedding, one king or two queens.

<h3>Suites</h3>

If you prefer additional space, try a suite. The Junior Suite is an oversized guest room with a seating area separated from the sleeping space by a half wall. For more privacy, reserve an elegant two-room suite, which offers twice the square footage of a standard guest room, with a door to separate bedroom and sitting areas.

The suites at the Doubletree are perfect for business stays when you need convenient space to conduct a small meeting or the ability to spread out and get the job done. Guest suite living areas also feature a sleeper sofa, great for vacationing families. And closets in both areas ensure you&acute;ll have plenty of wardrobe and hanging space for relocation or extended stays.

<h3>The Standing O Bistro and Bar </h3>

The Doubletree Hotel Philadelphia boasts a great option for enjoying a bite before heading out into the city: The Standing O Bistro.

Stop in the restaurant - which serves lunch and dinner daily - for a drink and some light fare. With its location right on Broad Street, you&acute;re close to everything you could ever want in a night on the town.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Hotels'),
					"post_tags"		=>	array('')
					);
////post end///
/// Hotels ////post start 4///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/hotels15.jpg";
$image_array[] = "dummy/hotels16.jpg";
$image_array[] = "dummy/hotels12.jpg";
$image_array[] = "dummy/hotels4.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels6.jpg";
$image_array[] = "dummy/hotels7.jpg";
$image_array[] = "dummy/hotels8.jpg";
$image_array[] = "dummy/hotels9.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '1201 Market Street Philadelphia, PA 19107',
					"geo_latitude"	=> '39.952188',
					"geo_longitude"	=> '-75.160716',
					"timing"		=> '24 Hours',
					"contact"		=> '(123) 111-2222',
					"email"			=> 'info@marriott.com',
					"website"		=> 'http://www.marriott.com/hotels/travel/phldt-philadelphia-marriott-downtown/',
					"twitter"		=> 'http://twitter.com/marriott',
					"facebook"		=> 'http://facebook.com/marriott',
					"is_featured"	=> '1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '2',
				);
$post_info[] = array(
					"post_title"	=>	'Philadelphia Marriott Downtown',
					"post_content"	=>	'
Get ready to stay and play at the new aloft Philadelphia Airport!

This incredibly modern hotel is located just five minutes from Philadelphia International Airport, offering a great convenience to travelers looking for fresh and fun accommodations.
<h3>Guest Rooms </h3>

The hotel&acute;s spacious guest rooms make you feel right at home with extra large windows, iPod docking stations, high-speed wireless internet, 42” LCD televisions and king- or queen-sized beds. Like the rest of the hotel, the guest rooms feature ultra-modern touches and a fun, energetic design.
<h3>Things to Do </h3>

Want to socialize? That&acute;s easy at aloft - just step into the re:mix lobby to relax and chat, work on your laptop or shoot a few games of pool. Ready for cocktail hour? The w xyz bar has great drink specials and tasty bar fare. Time for a snack? The re:fuel shop offers self-serve bites like sandwiches, salads and fresh fruit.

The Splash indoor pool and re:charge fitness center complete your overnight experience. And lucky for you - self check-in kiosks allow you to print out your next flight&acute;s boarding pass! Talk about convenient.
<h3> Re:Fuel </h3>

Just off the plane and craving something to nibble? Thanks to Aloft Philadelphia Airport&acute;s innovative eating options, you don&acute;t have to make do with bland in-flight meals or unhealthy airport fare. Enticing edibles are here, from sweet treats to healthy eats and more.

There is something to please your palate at any hour. Help yourself at the 24-7 re:fuel by Aloft(SM) for a quick bite whenever hunger strikes. Or mix and mingle with a drink and snack at the w xyz(SM) bar.
<h3>Fun </h3>

For the traveler open to possibilities, Aloft Philadelphia Airport is a fresh, fun, forward-thinking alternative. Breeze into a hotel that offers more than a comfy bed and a friendly smile, and enjoy a whole new travel experience. Energy flows and personalities mingle in a setting that combines urban-influenced design, accessible technology, and a social scene that&acute;s always abuzz.

Energizing public spaces draw you from your room to socialize, or just enjoy the hum of activity as you do your own thing. Sip a drink, read the paper, or work on your laptop in the re:mix(SM) lounge or w xyz(SM) bar, where lighting and music change throughout the day to set the perfect mood.

The hotel&acute;s open flow of features and help-yourself services inspire you to step outside the one-size-fits-all travel routine. Customize your stay and celebrate your style in a place where anything can happen.

Aahh…breathe deep at Aloft. This hotel is smoke-free.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Hotels','Feature'),
					"post_tags"		=>	array('')
					);
////post end///
/// Hotels ////post start 4///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/hotels16.jpg";
$image_array[] = "dummy/hotels15.jpg";
$image_array[] = "dummy/hotels12.jpg";
$image_array[] = "dummy/hotels4.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels6.jpg";
$image_array[] = "dummy/hotels7.jpg";
$image_array[] = "dummy/hotels8.jpg";
$image_array[] = "dummy/hotels9.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '3600 Sansom Street, Philadelphia, PA 19104',
					"geo_latitude"	=> '39.954013',
					"geo_longitude"	=> '-75.1956534',
					"timing"		=> '24 Hours',
					"contact"		=> '(888) 888-8888',
					"email"			=> 'info@theinnatpenn.com',
					"website"		=> 'http://www.theinnatpenn.com/',
					"twitter"		=> 'http://twitter.com/theinnatpenn',
					"facebook"		=> 'http://facebook.com/theinnatpenn',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Loews Philadelphia Hotel',
					"post_content"	=>	'
Located in the heart of Penn&acute;s campus in the beautiful University City neighborhood of Philadelphia, The Hilton Inn at Penn is a great choice for accommodations during your upcoming visit to Philadelphia.

The location puts you right in the middle of the prestigious University of Pennsylvania and its many nearby educational, medical and corporate centers. And Center City Philadelphia is only a short cab ride away. So if you want to get out and explore the city, you are set.

Take in a show at the Annenberg Theater; visit one of the many museums the city has to offer; dine at area restaurants that boast a range of cuisines, from Thai to Indian to Japanese to classic comfort cuisine; peerless boutique shopping along Walnut Street from University City to Old City.

The beautifully appointed guest rooms are equipped for the technologically sophisticated and include two dual-line phones with voice mail, data ports and high speed and wireless Internet access. Each room also offers WEBTV, plush terry cloth robes and luxurious bath amenities provide a touch of indulgence. Additionally, a refreshment center is now located in each guestroom with snacks and refreshments along with an in room safe for valuables and laptops.

The Hilton Inn at Penn is a recipient of the AAA Four Diamond rating. There is also a 24-hour fitness center with a full range of cardiovascular and weight training equipment.
<h3>Penne Restaurant and Wine Bar </h3>

One of University City&acute;s finest Italian restaurants is Penne at the Inn at Penn. Featuring innovative, regional Italian cuisine and hand-made pasta made fresh daily, Penne is a great choice for lunch or dinner.

The pasta is handmade right in front of you and then dished up along side delectable entrées such as grilled veal tenderloin and honey glazed sea scallops. And the wine bar offers more than 30 varieties by the glass and more than 100 by the bottle. 
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Hotels'),
					"post_tags"		=>	array('')
					);
////post end///
/// Hotels ////post start 5///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/hotels10.jpg";
$image_array[] = "dummy/hotels16.jpg";
$image_array[] = "dummy/hotels12.jpg";
$image_array[] = "dummy/hotels4.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels6.jpg";
$image_array[] = "dummy/hotels7.jpg";
$image_array[] = "dummy/hotels8.jpg";
$image_array[] = "dummy/hotels9.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '3600 Sansom Street, Philadelphia, PA 19104',
					"geo_latitude"	=> '39.954013',
					"geo_longitude"	=> '-75.1956534',
					"timing"		=> 'Daily : 11 am to 11 pm',
					"contact"		=> '(888) 888-8888',
					"email"			=> 'info@theinnatpenn.com',
					"website"		=> 'http://www.theinnatpenn.com/',
					"twitter"		=> 'http://twitter.com/theinnatpenn',
					"facebook"		=> 'http://facebook.com/theinnatpenn',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Hilton Inn at Penn',
					"post_content"	=>	'
Located in the heart of Penn&acute;s campus in the beautiful University City neighborhood of Philadelphia, The Hilton Inn at Penn is a great choice for accommodations during your upcoming visit to Philadelphia.

The location puts you right in the middle of the prestigious University of Pennsylvania and its many nearby educational, medical and corporate centers. And Center City Philadelphia is only a short cab ride away. So if you want to get out and explore the city, you are set.

Take in a show at the Annenberg Theater; visit one of the many museums the city has to offer; dine at area restaurants that boast a range of cuisines, from Thai to Indian to Japanese to classic comfort cuisine; peerless boutique shopping along Walnut Street from University City to Old City.

The beautifully appointed guest rooms are equipped for the technologically sophisticated and include two dual-line phones with voice mail, data ports and high speed and wireless Internet access. Each room also offers WEBTV, plush terry cloth robes and luxurious bath amenities provide a touch of indulgence. Additionally, a refreshment center is now located in each guestroom with snacks and refreshments along with an in room safe for valuables and laptops.

The Hilton Inn at Penn is a recipient of the AAA Four Diamond rating. There is also a 24-hour fitness center with a full range of cardiovascular and weight training equipment.
<h3>Penne Restaurant and Wine Bar </h3>

One of University City&acute;s finest Italian restaurants is Penne at the Inn at Penn. Featuring innovative, regional Italian cuisine and hand-made pasta made fresh daily, Penne is a great choice for lunch or dinner.

The pasta is handmade right in front of you and then dished up along side delectable entrées such as grilled veal tenderloin and honey glazed sea scallops. And the wine bar offers more than 30 varieties by the glass and more than 100 by the bottle.  
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Hotels','Food Nightlife'),
					"post_tags"		=>	array('')
					);
////post end///
/// Hotels ////post start 6///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/hotels17.jpg";
$image_array[] = "dummy/hotels18.jpg";
$image_array[] = "dummy/hotels12.jpg";
$image_array[] = "dummy/hotels4.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels6.jpg";
$image_array[] = "dummy/hotels7.jpg";
$image_array[] = "dummy/hotels8.jpg";
$image_array[] = "dummy/hotels9.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '21 N. Juniper Street Philadelphia, PA 19107',
					"geo_latitude"	=> '39.953007',
					"geo_longitude"	=> '-75.1624195',
					"timing"		=> 'Daily : 11 am to 11 pm',
					"contact"		=> '(888) 888-8888',
					"email"			=> 'info@theinnatpenn.com',
					"website"		=> 'http://www.theinnatpenn.com/',
					"twitter"		=> 'http://twitter.com/theinnatpenn',
					"facebook"		=> 'http://facebook.com/theinnatpenn',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Courtyard Philadelphia Downtown',
					"post_content"	=>	'
<h3>Overview </h3>

The Philadelphia Downtown Courtyard opened it&acute;s doors after a grand $75 million restoration, recapturing the grandeur of its 1926 origins while incorporating state of the art systems throughout.

Designed by renowned architect Phillip H. Johnson, the 18-story, 498-room hotel is listed on the “National Register of Historic Places” and stands as a charming testament to time with elegant bronze work, plaster detailing, striking marble finishes and unique architectural details.

Catering to both leisure and business travelers, the historic full-service hotel is ideally located in the “Heart of Center City” across from City Hall, one block to the Pennsylvania Convention Center and within walking distance of the Financial & Historic Districts, Avenue of the Arts and some of the finest restaurants and shopping the city has to offer.


<h3>Guestroom Features </h3>

The hotel features stylishly appointed oversized guestrooms with 11ft-high ceilings, a 42” LCD TV, Refrigerator, I-Pod Docking Station Alarm Clock, complimentary Wireless or Wired internet access, and Marriott&acute;s plush Revive bedding package.

In addition, the property offers 61 suites for those who like additional room and added comfort as well as 50 rooms which include a striking Wall Mural of Philadelphia&acute;s Independence Hall.

<h3>Hotel Services </h3>

As the largest Courtyard by Marriott in the United States, this hotel is truly unique offering all the full-service features and amenities you would expect from a premier hotel.

The Annex Grille & Lounge serves American Cuisine for breakfast, lunch & dinner as well as is a great location for a refreshing beverage or cocktail. Or you can dine in the convenience of your guestroom with the hotel&acute;s evening Room Service.

The hotel&acute;s Lobby Concierge Services and Bellman are ready to assist you with any request as well as information on all Philadelphia has to offer.

Stay in shape in the hotel&acute;s State of the Art Fitness Center, and then unwind in the Indoor Pool and Whirlpool. If you are looking for a quiet place to getaway, visit our Philip H. Johnson Library where you can read all about Historic Philadelphia.

<h3>Meetings & Events </h3>

Recently featured on WE TV&acute;s “My Fair Wedding”, the Courtyard Marriott Philadelphia is one of the city&acute;s leading venues for corporate and social affairs with over 10,000 sq ft of flexible meeting space, including two Grand Ballrooms each with over 3,000 square feet accommodating up to 250 people. In addition, the hotel has a total of 11 meeting rooms making it an ideal home for all occasions. The hotel boasts an experienced full-service Event and Culinary Teams, ready to take care of all the details and ensure your event is not only a success, but a lasting memory. 
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Hotels','Food Nightlife'),
					"post_tags"		=>	array('')
					);
////post end///
/// Hotels ////post start 7//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/hotels11.jpg";
$image_array[] = "dummy/hotels10.jpg";
$image_array[] = "dummy/hotels12.jpg";
$image_array[] = "dummy/hotels4.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels6.jpg";
$image_array[] = "dummy/hotels7.jpg";
$image_array[] = "dummy/hotels8.jpg";
$image_array[] = "dummy/hotels9.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '1 Logan Square, Philadelphia, PA 19103',
					"geo_latitude"	=> '39.9567043',
					"geo_longitude"	=> '-75.1697047',
					"timing"		=> 'Daily : 11 am to 11 pm',
					"contact"		=> '(143) 888-8888',
					"email"			=> 'info@fourseasons.com',
					"website"		=> 'http://www.fourseasons.com/philadelphia/',
					"twitter"		=> 'http://twitter.com/fourseasons',
					"facebook"		=> 'http://facebook.com/fourseasons',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Four Seasons Philadelphia',
					"post_content"	=>	'
<h3>Overview </h3>

The Philadelphia Downtown Courtyard opened it&acute;s doors after a grand $75 million restoration, recapturing the grandeur of its 1926 origins while incorporating state of the art systems throughout.

Designed by renowned architect Phillip H. Johnson, the 18-story, 498-room hotel is listed on the “National Register of Historic Places” and stands as a charming testament to time with elegant bronze work, plaster detailing, striking marble finishes and unique architectural details.

Catering to both leisure and business travelers, the historic full-service hotel is ideally located in the “Heart of Center City” across from City Hall, one block to the Pennsylvania Convention Center and within walking distance of the Financial & Historic Districts, Avenue of the Arts and some of the finest restaurants and shopping the city has to offer.


<h3>Guestroom Features </h3>

The hotel features stylishly appointed oversized guestrooms with 11ft-high ceilings, a 42” LCD TV, Refrigerator, I-Pod Docking Station Alarm Clock, complimentary Wireless or Wired internet access, and Marriott&acute;s plush Revive bedding package.

In addition, the property offers 61 suites for those who like additional room and added comfort as well as 50 rooms which include a striking Wall Mural of Philadelphia&acute;s Independence Hall.

<h3>Hotel Services </h3>

As the largest Courtyard by Marriott in the United States, this hotel is truly unique offering all the full-service features and amenities you would expect from a premier hotel.

The Annex Grille & Lounge serves American Cuisine for breakfast, lunch & dinner as well as is a great location for a refreshing beverage or cocktail. Or you can dine in the convenience of your guestroom with the hotel&acute;s evening Room Service.

The hotel&acute;s Lobby Concierge Services and Bellman are ready to assist you with any request as well as information on all Philadelphia has to offer.

Stay in shape in the hotel&acute;s State of the Art Fitness Center, and then unwind in the Indoor Pool and Whirlpool. If you are looking for a quiet place to getaway, visit our Philip H. Johnson Library where you can read all about Historic Philadelphia.

<h3>Meetings & Events </h3>

Recently featured on WE TV&acute;s “My Fair Wedding”, the Courtyard Marriott Philadelphia is one of the city&acute;s leading venues for corporate and social affairs with over 10,000 sq ft of flexible meeting space, including two Grand Ballrooms each with over 3,000 square feet accommodating up to 250 people. In addition, the hotel has a total of 11 meeting rooms making it an ideal home for all occasions. The hotel boasts an experienced full-service Event and Culinary Teams, ready to take care of all the details and ensure your event is not only a success, but a lasting memory. 
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Hotels','Food Nightlife'),
					"post_tags"		=>	array('')
					);
////post end///
/// Hotels ////post start 8//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/hotels11.jpg";
$image_array[] = "dummy/hotels10.jpg";
$image_array[] = "dummy/hotels12.jpg";
$image_array[] = "dummy/hotels4.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels6.jpg";
$image_array[] = "dummy/hotels7.jpg";
$image_array[] = "dummy/hotels8.jpg";
$image_array[] = "dummy/hotels9.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '12th and Spruce Streets, Philadelphia, PA 19107',
					"geo_latitude"	=> '39.9567043',
					"geo_longitude"	=> '-75.1697047',
					"timing"		=> 'Daily : 11 am to 11 pm',
					"contact"		=> '(143) 888-8888',
					"email"			=> 'info@alexanderinn.com',
					"website"		=> 'http://www.alexanderinn.com/',
					"twitter"		=> 'http://twitter.com/alexanderinn',
					"facebook"		=> 'http://facebook.com/alexanderinn',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Alexander Inn',
					"post_content"	=>	'
The Alexander Inn is one of Philadelphia&acute;s most popular and reasonably priced small hotels.

Conveniently located in the heart of the Washington Square West neighborhood in Center City Philadelphia, the Alexander Inn is a great place to base your stay in Philadelphia.

The décor of the hotel&acute;s 48 designer rooms is inspired by the style of the grand cruise ships of the 1930s, which is reflected in the rooms’ hand selected furnishings, fabrics and accessories. Beautiful artwork adorns the walls of each rooms, which all include private baths with plush towels.

Rooms are also fitted with DirecTV (including many complimentary channels like CNN, ESPN, eight movie channels, etc.) and telephones with modem ports and direct dial. You will also have access to the hotel&acute;s free 24-hour fitness and e-mail centers.  
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Hotels'),
					"post_tags"		=>	array('')
					);
////post end///
/// Hotels ////post start 9//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/hotels5.jpg";
$image_array[] = "dummy/hotels10.jpg";
$image_array[] = "dummy/hotels12.jpg";
$image_array[] = "dummy/hotels4.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels6.jpg";
$image_array[] = "dummy/hotels7.jpg";
$image_array[] = "dummy/hotels8.jpg";
$image_array[] = "dummy/hotels9.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '501 N. 22nd Street, Philadelphia, PA 19130 ',
					"geo_latitude"	=> '39.963091',
					"geo_longitude"	=> '-75.173804',
					"timing"		=> 'Daily : 10 am to 11 pm',
					"contact"		=> '(243) 222-12344',
					"email"			=> 'info@alexanderinn.com',
					"website"		=> 'http://book.bestwestern.com/bestwestern/productInfo.do?propertyCode=39087',
					"twitter"		=> 'http://twitter.com/bestwestern',
					"facebook"		=> 'http://facebook.com/bestwestern',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Best Western Center City Hotel',
					"post_content"	=>	'
The Alexander Inn is one of Philadelphia&acute;s most popular and reasonably priced small hotels.

Conveniently located in the heart of the Washington Square West neighborhood in Center City Philadelphia, the Alexander Inn is a great place to base your stay in Philadelphia.

The décor of the hotel&acute;s 48 designer rooms is inspired by the style of the grand cruise ships of the 1930s, which is reflected in the rooms’ hand selected furnishings, fabrics and accessories. Beautiful artwork adorns the walls of each rooms, which all include private baths with plush towels.

Rooms are also fitted with DirecTV (including many complimentary channels like CNN, ESPN, eight movie channels, etc.) and telephones with modem ports and direct dial. You will also have access to the hotel&acute;s free 24-hour fitness and e-mail centers.  
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Hotels','Food Nightlife'),
					"post_tags"		=>	array('')
					);
////post end///
/// Hotels ////post start 10//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/hotels7.jpg";
$image_array[] = "dummy/hotels10.jpg";
$image_array[] = "dummy/hotels12.jpg";
$image_array[] = "dummy/hotels4.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels6.jpg";
$image_array[] = "dummy/hotels12.jpg";
$image_array[] = "dummy/hotels8.jpg";
$image_array[] = "dummy/hotels9.jpg";
$image_array[] = "dummy/hotels1.jpg";
$image_array[] = "dummy/hotels2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '8229 Germantown Avenue, Philadelphia, PA 19118',
					"geo_latitude"	=> '40.073899',
					"geo_longitude"	=> '-75.2029419',
					"timing"		=> 'Daily : 10 am to 11 pm',
					"contact"		=> '(243) 222-12344',
					"email"			=> 'info@chestnuthillhotel.com',
					"website"		=> 'http://www.chestnuthillhotel.com/',
					"twitter"		=> 'http://twitter.com/chestnuthillhotel',
					"facebook"		=> 'http://facebook.com/chestnuthillhotel',
					"is_featured"	=> '1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '2',
				);
$post_info[] = array(
					"post_title"	=>	'Chestnut Hill Hotel',
					"post_content"	=>	'
The Chestnut Hill Hotel is located in the historic community of Chestnut Hill, approximately nine miles northwest from Center City Philadelphia. Although Chestnut Hill is close to Center City by today&acute;s standards, it was originally a distant “suburb” on the outskirts of the Philadelphia countryside.

Today, it is one of the region&acute;s most charming neighborhoods. Tree-lined streets and grand estates surround its main street, Germantown Avenue, where you can stroll and shop at more than 200 specialty shops and restaurants, along with trendy salons and other modern boutiques.

The Chestnut Hill Hotel fits perfectly in this setting - the hotel&acute;s 36 rooms and suites, decorated in an 18th-century style, hold the hotel to its boutique roots. It&acute;s a perfect place at which to enjoy a romantic getaway in Philadelphia. 
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Hotels','Feature'),
					"post_tags"		=>	array('')
					);
////post end///
/// Restaurants ////post start 1//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/restaurants1.jpg";
$image_array[] = "dummy/restaurants2.jpg";
$image_array[] = "dummy/restaurants3.jpg";
$image_array[] = "dummy/restaurants4.jpg";
$image_array[] = "dummy/restaurants5.jpg";
$image_array[] = "dummy/restaurants6.jpg";
$image_array[] = "dummy/restaurants7.jpg";
$image_array[] = "dummy/restaurants8.jpg";
$image_array[] = "dummy/restaurants9.jpg";
$image_array[] = "dummy/restaurants10.jpg";
$image_array[] = "dummy/restaurants11.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '118 S. 20th Street, Philadelphia, PA 19103',
					"geo_latitude"	=> '39.951401',
					"geo_longitude"	=> '-75.173862',
					"timing"		=> 'Daily : 10 am to 11 pm',
					"contact"		=> '(243) 222-12344',
					"email"			=> 'info@villagewhiskey.com',
					"website"		=> 'http://www.villagewhiskey.com/',
					"twitter"		=> 'http://twitter.com/villagewhiskey',
					"facebook"		=> 'http://facebook.com/villagewhiskey',
					"is_featured"	=> '1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '2',
				);
$post_info[] = array(
					"post_title"	=>	'Village Whiskey',
					"post_content"	=>	'


Located in a Rittenhouse Square space evoking the free-wheeling spirit of a speakeasy, Village Whiskey is prolific Chef Jose Garces’ intimate, 30-seat tribute to the time-honored liquor.

In fact, Village Whiskey features a veritable library of 80-100 varieties of whiskey, bourbon, rye and scotch from Scotland, Canada, Ireland, United States and even Japan.

Much as Village Whiskey could be a scene for toasting and roasting, it also comes from the culinary imagination of Jose Garces (of Amada, Tinto, Distrito and Chifa fame), meaning the food is no less than outstanding.
<h3>Cuisine </h3>

Village Whiskey&acute;s specialty from the kitchen is “bar snacks,” but that doesn&acute;t mean a bowl of cashews. Rather, it means deviled eggs, spicy popcorn shrimp, soft pretzels and an à la carte raw bar, all treated with the culinary care that made Jose Garces a finalist on The Next Iron Chef.

Perhaps you seek something heartier. The lobster roll, raw bar selections and Kentucky fried quail are standouts, but you’d really ought to order the Whiskey King: a 10 oz patty of ground-to-order sustainable angus topped with maple bourbon glazed cipollini, Rogue blue cheese, applewood smoked bacon and foie gras. Bring your appetite.
<h3>Cocktails </h3>

Whiskey-based cocktails are divided into two categories: Prohibition (classic cocktails) and Repeal (more contemporary, modern takes). Meanwhile, the venerable Manhattan is a mainstay, mixed using house-made bitters.

Prohibition cocktails include: Old Fashioned (Bottle in Bond Bourbon and house bitters); Aviation (Creme de Violette and gin); and Philadelphia Fish House Punch (dark rum, peach brandy and tea). Repeal cocktails include: APA (hops-infused vodka, ginger and egg white); De Riguer (rye, aperol, grapefruit and mint); and Horse With No Name (scotch, Stone Pine Liqueur and pineapple).
<h3>Atmosphere </h3>

The speakeasy atmosphere is accomplished through dim lighting, posters for various alcohols, a tin ceiling and antique mirrors. Black-and-white white tiled floors, marble topped tables and wooden drink rails add to the traditional bar decor.

Behind the pewter bar, whiskies are proudly displayed like leather-bound books.

During the warmer months, diners can sit at large, wooden tables placed along Sansom Street for whiskey alfresco.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Restaurants','Feature'),
					"post_tags"		=>	array('Sample Tag1')
					);
////post end///
/// Restaurants ////post start 2//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/restaurants4.jpg";
$image_array[] = "dummy/restaurants2.jpg";
$image_array[] = "dummy/restaurants3.jpg";
$image_array[] = "dummy/restaurants1.jpg";
$image_array[] = "dummy/restaurants5.jpg";
$image_array[] = "dummy/restaurants6.jpg";
$image_array[] = "dummy/restaurants7.jpg";
$image_array[] = "dummy/restaurants8.jpg";
$image_array[] = "dummy/restaurants9.jpg";
$image_array[] = "dummy/restaurants10.jpg";
$image_array[] = "dummy/restaurants11.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '112 S. 13th Street Philadelphia, PA',
					"geo_latitude"	=> '39.949945',
					"geo_longitude"	=> '-75.162178',
					"timing"		=> 'Daily : 10 am to 11 pm',
					"contact"		=> '(243) 222-12344',
					"email"			=> 'info@zavino.com',
					"website"		=> 'http://www.zavino.com/',
					"twitter"		=> 'http://twitter.com/zavino',
					"facebook"		=> 'http://facebook.com/zavino',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Zavino Pizzeria and Wine Bar',
					"post_content"	=>	'
Zavino is a new pizzeria and wine bar located at the epicenter of the city&acute;s trendy Midtown Village neighborhood. The restaurant features a seasonal menu, classic cocktails, an approachable selection of wine and beer and some of the best late night menu offerings in the area.

The restaurant&acute;s interior looks great - it has a simple, rustic feel with an original brick wall, large picture windows, a long bar and a large outdoor cafe coming this spring.

And the menu is great too - it boasts affordable snacks ranging from pizza to pasta to charcuterie to satisfy diners’ hunger, and then cocktails, including Italy&acute;s venerable Negroni and Bellini, and an ever-evolving assortment of wine and beer offerings, to quench their thirst.

Menu items vary seasonally, as is customary in Italy, and may include: House-Made Beef Ravioli with brown butter and sage; Roasted Red and Golden Beets with pistachios and goat cheese; Roasted Lamb with fried eggplant and mint; a delicious house-made gnocchi; and traditional Panzanella, a tomato and bread salad. There is also a nice selection of cheese and charcuterie available a la carte.

<h3>The Pizza </h3>

The gourmet pizzas are baked in a special wood-burning oven that reaches temperatures of up to 900 degrees. The pizzas are approximately 12 inches in diameter. And Chef Gonzalez describes the crust as neither too thin or too thick, but rather somewhere right between Neapolitan and Sicilian, “crunchy and tender, and just exactly right.”

Three classic pizzas will be available year-round: Rosa, with tomato sauce and roasted garlic; Margherita, with tomato sauce and buffalo mozzarella, topped with fresh basil; and Polpettini, tomato sauce and provolone cheese with veal mini-meatballs.

The specialty pizzas that are on the opening winter menu include: Philly, with bechamel, provolone, roasted onions and bresaola; Kennett, with bechamel, claudio&acute;s mozzarella, roasted onions with oyster, cremini and shitake mushrooms; Sopressata, with tomato sauce, claudio&acute;s mozzarella, sopressata olives, pickled red onion and pecorino; and Fratello, with bechamel, broccoli, roasted garlic and claudio&acute;s mozzarella.

Pizzas vary in price from $8 to $12.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Restaurants'),
					"post_tags"		=>	array('Sample Tag1')
					);
////post end///
/// Restaurants ////post start 2//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/restaurants4.jpg";
$image_array[] = "dummy/restaurants2.jpg";
$image_array[] = "dummy/restaurants3.jpg";
$image_array[] = "dummy/restaurants1.jpg";
$image_array[] = "dummy/restaurants5.jpg";
$image_array[] = "dummy/restaurants6.jpg";
$image_array[] = "dummy/restaurants7.jpg";
$image_array[] = "dummy/restaurants8.jpg";
$image_array[] = "dummy/restaurants9.jpg";
$image_array[] = "dummy/restaurants10.jpg";
$image_array[] = "dummy/restaurants11.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '112 S. 13th Street Philadelphia, PA',
					"geo_latitude"	=> '39.951401',
					"geo_longitude"	=> '-75.173862',
					"timing"		=> 'Daily : 10 am to 11 pm',
					"contact"		=> '(243) 222-12344',
					"email"			=> 'info@chestnuthillhotel.com',
					"website"		=> 'http://www.villagewhiskey.com/',
					"twitter"		=> 'http://twitter.com/villagewhiskey',
					"facebook"		=> 'http://facebook.com/villagewhiskey',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Zavino Pizzeria and Wine Bar',
					"post_content"	=>	'
Zavino is a new pizzeria and wine bar located at the epicenter of the city&acute;s trendy Midtown Village neighborhood. The restaurant features a seasonal menu, classic cocktails, an approachable selection of wine and beer and some of the best late night menu offerings in the area.

The restaurant&acute;s interior looks great - it has a simple, rustic feel with an original brick wall, large picture windows, a long bar and a large outdoor cafe coming this spring.

And the menu is great too - it boasts affordable snacks ranging from pizza to pasta to charcuterie to satisfy diners’ hunger, and then cocktails, including Italy&acute;s venerable Negroni and Bellini, and an ever-evolving assortment of wine and beer offerings, to quench their thirst.

Menu items vary seasonally, as is customary in Italy, and may include: House-Made Beef Ravioli with brown butter and sage; Roasted Red and Golden Beets with pistachios and goat cheese; Roasted Lamb with fried eggplant and mint; a delicious house-made gnocchi; and traditional Panzanella, a tomato and bread salad. There is also a nice selection of cheese and charcuterie available a la carte.

<h3>The Pizza </h3>

The gourmet pizzas are baked in a special wood-burning oven that reaches temperatures of up to 900 degrees. The pizzas are approximately 12 inches in diameter. And Chef Gonzalez describes the crust as neither too thin or too thick, but rather somewhere right between Neapolitan and Sicilian, “crunchy and tender, and just exactly right.”

Three classic pizzas will be available year-round: Rosa, with tomato sauce and roasted garlic; Margherita, with tomato sauce and buffalo mozzarella, topped with fresh basil; and Polpettini, tomato sauce and provolone cheese with veal mini-meatballs.

The specialty pizzas that are on the opening winter menu include: Philly, with bechamel, provolone, roasted onions and bresaola; Kennett, with bechamel, claudio&acute;s mozzarella, roasted onions with oyster, cremini and shitake mushrooms; Sopressata, with tomato sauce, claudio&acute;s mozzarella, sopressata olives, pickled red onion and pecorino; and Fratello, with bechamel, broccoli, roasted garlic and claudio&acute;s mozzarella.

Pizzas vary in price from $8 to $12.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Restaurants'),
					"post_tags"		=>	array('Sample Tag1')
					);
////post end///
/// Restaurants ////post start 3//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/restaurants5.jpg";
$image_array[] = "dummy/restaurants6.jpg";
$image_array[] = "dummy/restaurants7.jpg";
$image_array[] = "dummy/restaurants1.jpg";
$image_array[] = "dummy/restaurants2.jpg";
$image_array[] = "dummy/restaurants3.jpg";
$image_array[] = "dummy/restaurants4.jpg";
$image_array[] = "dummy/restaurants8.jpg";
$image_array[] = "dummy/restaurants9.jpg";
$image_array[] = "dummy/restaurants10.jpg";
$image_array[] = "dummy/restaurants11.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '227 S. 18th Street, Philadelphia, PA 19103',
					"geo_latitude"	=> '39.9489408',
					"geo_longitude"	=> '-75.1708782',
					"timing"		=> 'Daily : 10 am to 12 pm',
					"contact"		=> '(143) 222-12344',
					"email"			=> 'info@parc-restaurant.com',
					"website"		=> 'http://www.parc-restaurant.com/',
					"twitter"		=> 'http://twitter.com/parc-restaurant',
					"facebook"		=> 'http://facebook.com/parc-restaurant',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Parc',
					"post_content"	=>	'
If you love Paris in the springtime, Parc is a veritable grand cru.

With Parc, famed restaurateur Stephen Starr brings a certain je ne sais quoi to Rittenhouse Square. Parc offers an authentic French bistro experience, fully equipped with a chic Parisian ambiance and gorgeous sidewalk seating overlooking the Square.
<h3>Cuisine </h3>

Parc menu encourages a joyful dining experience, where croissants, champagne and conversation are enjoyed in equal measure.

Sample hors d’oeuvres include salade lyonnaise with warm bacon vinaigrette and poached egg, escargots served in their shells with hazelnut butter and a crispy duck confit with frisée salad and pickled chanterelles.

Outstanding entrées include boeuf bourguignon with fresh buttered pasta and steak frites with peppercorn sauce. A variety of plats du jour are also offered, including a seafood-rich bouillabaisse on Fridays and a sumptuous coq au vin, perfect for Sunday night suppers.

And what&acute;s an authentic French meal without wine? More than 160 expertly chosen varietals are offered by the bottle, with more than 20 available by the glass.
<h3>See and Be Seen </h3>

With seating for more than 75 at its sidewalk and window seating, Parc has instantly become one of the best places in Philadelphia for alfresco drinking and dining.

The awning-covered seating wraps around the restaurant&acute;s two sides and overlooks Rittenhouse Square, one of Philadelphia&acute;s most popular public spaces.
<h3>Atmosphere </h3>

The aroma of freshly baked breads fills the air as one enters Parc&acute;s casual front room, which is clad in hand-laid Parisian tiles in shades of ecru and green.

Red leather banquettes flanked by frosted glass offer subtle intimacy, while well-worn wooden chairs, reclaimed bistro tables and mahogany paneled walls give the room a sense of place.

The more formal dining room provides a slightly more sophisticated experience while maintaining the energy and emotion of a bustling brasserie.

To put it simply, Parc is nothing short of an authentic Parisian dining experience - right here in the heart of Rittenhouse Square.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Restaurants'),
					"post_tags"		=>	array('Sample Tag2')
					);
////post end///
/// Restaurants ////post start 4//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/restaurants9.jpg";
$image_array[] = "dummy/restaurants10.jpg";
$image_array[] = "dummy/restaurants3.jpg";
$image_array[] = "dummy/restaurants1.jpg";
$image_array[] = "dummy/restaurants5.jpg";
$image_array[] = "dummy/restaurants6.jpg";
$image_array[] = "dummy/restaurants7.jpg";
$image_array[] = "dummy/restaurants8.jpg";
$image_array[] = "dummy/restaurants9.jpg";
$image_array[] = "dummy/restaurants2.jpg";
$image_array[] = "dummy/restaurants4.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '900 South Street Philadelphia, PA 19147',
					"geo_latitude"	=> '39.9425802',
					"geo_longitude"	=> '-75.1573677',
					"timing"		=> 'Percy Street is closed on Mondays. The restaurant is also open for weekend lunch/brunch from 11:30 a.m. to 2:30 p.m.',
					"contact"		=> '(143) 222-12344',
					"email"			=> 'info@percystreet.com',
					"website"		=> 'http://www.percystreet.com/',
					"twitter"		=> 'http://twitter.com/percystreet',
					"facebook"		=> 'http://facebook.com/percystreet',
					"is_featured"	=> '1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '2',
				);
$post_info[] = array(
					"post_title"	=>	'Percy Street Barbecue',
					"post_content"	=>	'
Percy Street Barbecue sees the South Street debut of restaurateurs Steven Cook and Michael Solomonov (Zahav, Xochitl).

Serving a straightforward selection of slowly smoked meats and homey side dishes alongside craft beers and tasty cocktails, Percy Street is an ideal venue for Chef Erin OShea much-lauded Southern cooking, and is on its way to become the city top spot for barbecue.

Working with J&R smokers sourced from Texas, Chef O&acute;shea and her crack team of barbecue wizards headed down to Texas - tested no fewer than 20 beef briskets - as they perfected the ideal balance of salt, smoke and seasoning. Check out this video about their culinary field trip to the Lone Star State.

<h3>The Eats </h3>

That Brisket which is Percy Street&acute;s signature dish, served - as is the custom in Texas - by the half pound or pound, in three distinct cuts: Moist, Lean and Burnt Ends.

Other menu items include: Spare Ribs; house-made Sausage; half or whole Chicken; and Pork Belly, all slowly smoked and served with white bread and pickles. Sides, available small or large, include: Pinto Beans; Green Bean Casserole, Root beer Chili, Coleslaw; Collard Greens; Macaroni and Cheese; and Vegan Chili.
<h3>The Drinks </h3>

In keeping with their bare-bones, Texas-frontier aesthetic, Percy Street&acute;s craft beers are served exclusively on draft at the poured concrete bar, lit from above by illuminated green glass beer growlers. Beers include Sly Fox Rauchbier (available in Pennsylvania exclusively at the restaurant) as well as a hand-crafted Root Beer from Yard&acute;s Brewing Company.

Cocktails include: FM 423, with Tito handmade vodka, peach juice and sweet tea; Jack & Ginger, with Jack Daniels, Canton ginger liqueur, lime cordial and ginger ale; and Cherry Cola, with Beam rye, cherry Heering, DiSaronno and cola.

<h3>Atmosphere </h3>

Percy Street&acute;s simple, rustic decor was created by Elisabeth Knapp, who also designed Cook and Solomonov Xochitl and Zahav restaurants.

Her frontier-influenced design focuses on the fire engine red smokers, visible through a window in the dining room and bar area. The restaurant features light wood floors, weathered red paint, a working jukebox and custom “blackboard walls,” large panels of schoolhouse blackboards that can be rearranged to create private dining areas throughout the 80-seat space.

Seating in the form of repurposed church pews, and bare light bulbs overhead in the dining room lend to the restaurant Texas-esque aesthetic.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Restaurants','Feature'),
					"post_tags"		=>	array('Sample Tag3')
					);
////post end///
/// Restaurants ////post start 5//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/restaurants4.jpg";
$image_array[] = "dummy/restaurants10.jpg";
$image_array[] = "dummy/restaurants3.jpg";
$image_array[] = "dummy/restaurants1.jpg";
$image_array[] = "dummy/restaurants5.jpg";
$image_array[] = "dummy/restaurants6.jpg";
$image_array[] = "dummy/restaurants7.jpg";
$image_array[] = "dummy/restaurants8.jpg";
$image_array[] = "dummy/restaurants9.jpg";
$image_array[] = "dummy/restaurants2.jpg";
$image_array[] = "dummy/restaurants4.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '1 Logan Square, Philadelphia, PA 19103',
					"geo_latitude"	=> '39.9567043',
					"geo_longitude"	=> '-75.1697047',
					"timing"		=> 'The restaurant is also open for weekend lunch/brunch from 11:30 a.m. to 2:30 p.m.',
					"contact"		=> '(103) 100-12344',
					"email"			=> 'info@fourseasons.com',
					"website"		=> 'http://www.fourseasons.com/philadelphia/dining',
					"twitter"		=> 'http://twitter.com/fourseasons',
					"facebook"		=> 'http://facebook.com/fourseasons',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'The Fountain Restaurant',
					"post_content"	=>	'
The Fountain Restaurant in the Four Seasons Hotel Philadelphia has received seemingly every type of accolade there is, from top honors in Gourmet magazine to Forbes Travel Guide&acute;s 2010 Five Star award to a perfect Five Diamond rating from AAA. It&acute;s been a Philadelphia favorite for special occasion meals for decades.

Additionally rated as the best restaurant in Philadelphia by Zagat&acute;s, the Fountain Restaurant overlooks the majestic Swann Memorial Fountain sculpture by Alexander Stirling Calder in the center of Logan Square. You&acute;ll also enjoy sweeping views of the grand Benjamin Franklin Parkway and its gorgeous Beaux Arts architecture.

Fountain is definitely an incredibly romantic restaurant, so if you&acute;re visiting with a special someone, you will surely impress them with a meal at Fountain.

You can order a la carte or select the prix fix option to enjoy the “spontaneous tastes” menu which gives the chef control of a few courses. The menu changes regularly, but you can expect to see globaly influenced items like Pan-fried Veal Sweetbreads, Braised Dover Sole Roulade, Sautéed Venison Medallions and Roasted Australian Lamb Saddle.

',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Restaurants'),
					"post_tags"		=>	array('food')
					);
////post end///
/// Restaurants ////post start 6//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/restaurants11.jpg";
$image_array[] = "dummy/restaurants10.jpg";
$image_array[] = "dummy/restaurants3.jpg";
$image_array[] = "dummy/restaurants1.jpg";
$image_array[] = "dummy/restaurants5.jpg";
$image_array[] = "dummy/restaurants6.jpg";
$image_array[] = "dummy/restaurants7.jpg";
$image_array[] = "dummy/restaurants8.jpg";
$image_array[] = "dummy/restaurants9.jpg";
$image_array[] = "dummy/restaurants2.jpg";
$image_array[] = "dummy/restaurants4.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '210 W. Rittenhouse Square, Philadelphia, PA 19103',
					"geo_latitude"	=> '39.949872',
					"geo_longitude"	=> '-75.173404',
					"timing"		=> 'The restaurant is also open for weekend lunch/brunch from 10:30 a.m. to 6:30 p.m.',
					"contact"		=> '(113) 121-12344',
					"email"			=> 'info@rittenhousehotel.com',
					"website"		=> 'http://www.rittenhousehotel.com/lacroix.cfm',
					"twitter"		=> 'http://twitter.com/rittenhousehotel',
					"facebook"		=> 'http://facebook.com/rittenhousehotel',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Lacroix at The Rittenhouse',
					"post_content"	=>	'
A deluxe hotel like The Rittenhouse deserves a deluxe restaurant, a fitting description for Lacroix, named “Restaurant of the Year” in 2003 by Esquire magazine.

Located on the second floor of the Rittenhouse Hotel, Lacroix features elegant décor and a broad view of Rittenhouse Square, which combine to make the ambiance at Lacroix as enjoyable as the meal itself.

The creative French menu changes with the season and in the past has included favorites like pumpkin soup with fried shallots and tuna steak with salmis sauce. The wine list is excellent and extensive - thanks to the 4,000-bottle wine cellar .

The tasting menus can be catered to your preference - three-, four- and five-course selections are offered at set prices during lunch and dinner.

Sunday Brunch at Lacroix - which features such delectable dishes as baby lamb chops with garlic crust and banyuls sauce, niman ranch smoked bacon, quail eggs with artichoke, golden beet and shiitakes, and french baguette toast with apple, raspberry and rosemary jam - is also highly recommended.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Restaurants'),
					"post_tags"		=>	array('food')
					);
////post end///
/// Restaurants ////post start 7//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/restaurants12.jpg";
$image_array[] = "dummy/restaurants13.jpg";
$image_array[] = "dummy/restaurants14.jpg";
$image_array[] = "dummy/restaurants15.jpg";
$image_array[] = "dummy/restaurants5.jpg";
$image_array[] = "dummy/restaurants6.jpg";
$image_array[] = "dummy/restaurants7.jpg";
$image_array[] = "dummy/restaurants8.jpg";
$image_array[] = "dummy/restaurants9.jpg";
$image_array[] = "dummy/restaurants2.jpg";
$image_array[] = "dummy/restaurants4.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '128 S. 19th Street Philadelphia, PA 19103 ',
					"geo_latitude"	=> '39.950897',
					"geo_longitude"	=> '-75.1724',
					"timing"		=> 'The restaurant is also open for weekend lunch/brunch from 10:30 a.m. to 6:30 p.m.',
					"contact"		=> '(113) 121-12344',
					"email"			=> 'info@zamarestaurant.com',
					"website"		=> 'http://www.zamarestaurant.com/',
					"twitter"		=> 'http://twitter.com/zamarestaurant',
					"facebook"		=> 'http://facebook.com/zamarestaurant',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Lacroix at The Rittenhouse',
					"post_content"	=>	'
A deluxe hotel like The Rittenhouse deserves a deluxe restaurant, a fitting description for Lacroix, named “Restaurant of the Year” in 2003 by Esquire magazine.

Located on the second floor of the Rittenhouse Hotel, Lacroix features elegant décor and a broad view of Rittenhouse Square, which combine to make the ambiance at Lacroix as enjoyable as the meal itself.

The creative French menu changes with the season and in the past has included favorites like pumpkin soup with fried shallots and tuna steak with salmis sauce. The wine list is excellent and extensive - thanks to the 4,000-bottle wine cellar .

The tasting menus can be catered to your preference - three-, four- and five-course selections are offered at set prices during lunch and dinner.

Sunday Brunch at Lacroix - which features such delectable dishes as baby lamb chops with garlic crust and banyuls sauce, niman ranch smoked bacon, quail eggs with artichoke, golden beet and shiitakes, and french baguette toast with apple, raspberry and rosemary jam - is also highly recommended.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Restaurants','Food Nightlife'),
					"post_tags"		=>	array('food')
					);
////post end///
/// Restaurants ////post start 8//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/restaurants16.jpg";
$image_array[] = "dummy/restaurants17.jpg";
$image_array[] = "dummy/restaurants18.jpg";
$image_array[] = "dummy/restaurants19.jpg";
$image_array[] = "dummy/restaurants5.jpg";
$image_array[] = "dummy/restaurants6.jpg";
$image_array[] = "dummy/restaurants7.jpg";
$image_array[] = "dummy/restaurants8.jpg";
$image_array[] = "dummy/restaurants9.jpg";
$image_array[] = "dummy/restaurants2.jpg";
$image_array[] = "dummy/restaurants4.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '122 S. 13th Street Philadelphia, PA 19107',
					"geo_latitude"	=> '39.949532',
					"geo_longitude"	=> '-75.162284',
					"timing"		=> 'The restaurant is also open for weekend lunch/brunch from 10:30 a.m. to 6:30 p.m.',
					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@sampanphilly.com',
					"website"		=> 'http://www.sampanphilly.com/',
					"twitter"		=> 'http://twitter.com/sampanphilly',
					"facebook"		=> 'http://facebook.com/sampanphilly',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Sampan',
					"post_content"	=>	'
Chef and charismatic television star Michael Schulson returns to Philadelphia with the opening of Sampan, a modern Asian restaurant where he serves the acclaimed cuisine that has made him one of the country&acute;s highly sought-after culinary talents.

Schulson returns to Philadelphia after having opened Buddakan in New York City for Stephen Starr and Izakaya at the Borgata in Atlantic City and then having gone on to star in Style network&acute;s popular series Pantry Raid and TLC Ultimate Cake Off.

Chef Schulson has been looking forward to a time when he could come back to Philadelphia and cook in a small, personal space, which he has now achieved with Sampan. To him, Sampan is a place where he can prepare serious food from across Asia while interacting with guests and sharing his love of the cuisine with them.

<h3>Design </h3>

Designed by Philadelphia&acute;s Sparks Design, Sampan features distressed metals, reclaimed timber and a rustic, natural aesthetic anchored by a custom-crafted, color washed painting that lends a warm ambiance to the space. In contrast to the large scale restaurants such as Manhattan&acute;s Buddakan and West Philadelphia&acute;s Pod, where Chef Schulson served as executive chef, this 80-seat gem is a cozy setting that allows his passion for Asian flavors, thoughtfully prepared, to shine.

<h3>Cuisine </h3>

Schulson&acute;s says his mission at Sampan is to make the more exotic and unfamiliar flavors of Asian cuisine accessible and inviting to American palates.

Sampan menu is composed of a variety of small plates - Chef Schulson&acute;s preferred way to cook because it is ideal for sampling and sharing. Tempting dishes include: his signature Edamame Dumplings, with truffles, shoots and sake broth; Thai Chicken Wings with pickles, mint and basil; Pekin Duck with tamarind pancakes, scallions and cucumbers; Lamb Satay with yakitori, penko and ginger; Crispy Chili Crab with Hong Kong noodles, black beans and ginger chips; Mao Pao Tofu with pork, ginger and garlic; and Wild Mushroom Salad with goat cheese, puffed rice and truffles.

Prices range from $5 to $19.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Restaurants','Food Nightlife'),
					"post_tags"		=>	array('restaurant')
					);
////post end///
/// Restaurants ////post start 9//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/restaurants17.jpg";
$image_array[] = "dummy/restaurants16.jpg";
$image_array[] = "dummy/restaurants18.jpg";
$image_array[] = "dummy/restaurants19.jpg";
$image_array[] = "dummy/restaurants5.jpg";
$image_array[] = "dummy/restaurants6.jpg";
$image_array[] = "dummy/restaurants7.jpg";
$image_array[] = "dummy/restaurants8.jpg";
$image_array[] = "dummy/restaurants9.jpg";
$image_array[] = "dummy/restaurants2.jpg";
$image_array[] = "dummy/restaurants4.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '723 Chestnut Street, Philadelphia, PA 19106',
					"geo_latitude"	=> '39.9497313',
					"geo_longitude"	=> '-75.1547377',
					"timing"		=> 'The restaurant is also open for weekend lunch/brunch from 10:30 a.m. to 6:30 p.m.',
					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@morimotorestaurant.com',
					"website"		=> 'http://www.morimotorestaurant.com/',
					"twitter"		=> 'http://twitter.com/morimotorestaurant',
					"facebook"		=> 'http://facebook.com/morimotorestaurant',
					"is_featured"	=> '1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '2',
				);
$post_info[] = array(
					"post_title"	=>	'Morimoto',
					"post_content"	=>	'
Stephen Starr creative Japanese restaurant has garnered all kinds of national and international attention since opening a few years back. Located a block from Independence Hall on Chestnut Street, Morimoto has an interior - awash in glass and colors - that is both striking and serene in its design.

The restaurant&acute;s namesake and head chef, Morimoto (of Food Network&acute;s Iron Chef fame), has created a menu offering the very best in contemporary Japanese cusine. While regulars flock here for the exquisitely prepared sushi, Morimoto offers diners a broad spectrum of flavors that delve beyond nigiri and sashimi.

In recent years, the restaurant has made it onto Gourmet magazine&acute;s “Best Restaurants in America” list and Conde Nast Traveler magazine 50 Hot Tables in America. Today Morimoto remains one of the hottest spots to dine in Center City and continues to receive rave reviews from regulars and first-timers alike.

That said, be sure to call ahead for reservations.

<h3>Insider Tip </h3>

The mezzanine level lounge is a great spot to have a pre-meal cocktail while waiting for your table. You can enjoy a sake or try a “Sakura” - a cosmo made with Sake - in the sleek space that overlooks the brilliant restaurant below.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Restaurants','Food Nightlife','Feature'),
					"post_tags"		=>	array('America')
					);
////post end///
/// Restaurants ////post start 10//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/restaurants19.jpg";
$image_array[] = "dummy/restaurants17.jpg";
$image_array[] = "dummy/restaurants18.jpg";
$image_array[] = "dummy/restaurants16.jpg";
$image_array[] = "dummy/restaurants5.jpg";
$image_array[] = "dummy/restaurants6.jpg";
$image_array[] = "dummy/restaurants7.jpg";
$image_array[] = "dummy/restaurants8.jpg";
$image_array[] = "dummy/restaurants9.jpg";
$image_array[] = "dummy/restaurants2.jpg";
$image_array[] = "dummy/restaurants4.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '325 Chestnut Street Philadelphia, PA 19106',
					"geo_latitude"	=> '39.9488152',
					"geo_longitude"	=> '-75.147207',
					"timing"		=> 'The restaurant is also open for weekend lunch/brunch from 10:30 a.m. to 6:30 p.m.',
					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@buddakan.com',
					"website"		=> 'http://www.buddakan.com/',
					"twitter"		=> 'http://twitter.com/buddakan',
					"facebook"		=> 'http://facebook.com/buddakan',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Buddakan',
					"post_content"	=>	'
<h3>The Experience </h3>

A towering gilded statue of the Buddha generates elegant calm in this 175-seat, Pan Asian restaurant with sleek, modern decor. Immensely popular, Buddakan is a restaurant that is great for both large parties and intimate dinners.

Located in the heart of the bustling Old City neighborhood, Buddakan features two full bars as well as a popular (and hard to reserve) 20-person, lit-from-within, community table for sharing food and conversation.

The fare is top notch - appetizers include seared kobe beef carpaccio, endamme ravioli, miso tuna tartare and tea smoked spareribs. For the main course, delve into delicious dishes like Japanese black cod, wasabi crusted filet mignon, roasted ponzu chicken and collosal tempura shrimp. For dessert, the chocolate bento box will please just about anyone.

Be sure to make your reservation before coming to town as Buddakan fills up quickly especially on weekends. Better yet, make your reservation right now .
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Restaurants','Food Nightlife'),
					"post_tags"		=>	array('America')
					);
////post end///
/// Festival ////post start 1//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$image_array[] = "dummy/festival3.jpg";
$image_array[] = "dummy/festival4.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival6.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival10.jpg";
$image_array[] = "dummy/festival11.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '2600 Benjamin Franklin Parkway, Philadelphia, PA 19130',
					"geo_latitude"	=> '39.9363719',
					"geo_longitude"	=> '-75.158405',
					"timing"		=> 'Date - May 15-16, 2010',
					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@italianmarketfestival.com',
					"website"		=> 'http://www.italianmarketfestival.com/',
					"twitter"		=> 'http://twitter.com/italianmarketfestival',
					"facebook"		=> 'http://facebook.com/italianmarketfestival',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Street Italian Market Festival',
					"post_content"	=>	'
<h3>The Experience </h3>

For one weekend each May, 9th Street - in the heart of South Philadelphia - closes down traffic and a huge, multi-block festival takes over the neighborhood.

It all starts with the great sights, sounds and aromas of America&acute;s oldest continuously operating open-air market: South Philadelphia&acute;s famous Italian Market. And the most important thing for you to bring with you is your appetite.

In addition to the blocks of curb vendors and specialty butcher, cheese, gift and cookware shops that line the market, there will also be street-side merchants selling specially prepared foods just for the Festival.

Expect to see stands offering a display of fresh sausage and peppers, antipasto salads, roast pork sandwiches, cheeses, cured meats, an infinite array of pastries, famous mango roses and so much more.

Many nearby restaurants will extend their table service to the sidewalk so you can dine alfresco and enjoy the festival atmosphere.

A stunning smorgasbord of flavors will be on full display during the Festival, as vendors line the street, musicians roam the crowds and top chefs show off some of their best techniques at live cooking demonstrations.

For a full schedule and lineup of musicians, performances and demonstrations, be sure to visit the Festival&acute;s official website.
<h3>Insider Tip </h3>

Belying its name, the Italian Market is not just Italian anymore. In fact, it&acute;s a veritable melting pot of international cultures and cuisines.

You can choose from several excellent Asian restaurants serving delicious Vietnamese banh mi sandwiches and piping hot bowls of pho.

Or savor amazingly flavorful tacos, spicy tamales and several other authentic Mexican favorites from La Lupe and Taqueria La Veracruzanas. And that&acute;s just the beginning.

There is so much great eating in and around the Italian Market that you&acute;ll want to return again and again. 
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival'),
					"post_tags"		=>	array('')
					);
////post end///
/// Festival ////post start 2//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival6.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival10.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '2600 Benjamin Franklin Parkway, Philadelphia, PA 19130',
					"geo_latitude"	=> '39.9661855',
					"geo_longitude"	=> '-75.1796512',
					"timing"		=> 'July 4, 2010 | 11 a.m. – 11 p.m.',
					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@italianmarketfestival.com',
					"website"		=> 'http://www.italianmarketfestival.com/',
					"twitter"		=> 'http://twitter.com/italianmarketfestival',
					"facebook"		=> 'http://facebook.com/italianmarketfestival',
					"is_featured"	=> '1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '2',
				);
$post_info[] = array(
					"post_title"	=>	'Festival, Concert and Fireworks',
					"post_content"	=>	'
This Fourth of July, celebrate America independence with incredible fireworks in Philadelphia during the annual Wawa Welcome America! festival!
THE MAIN EVENT

<h3>Concert & Fireworks Display </h3>

8:30 – 11:00 p.m., July 4, 2010

CONCERT BEGINS AT 8:30 – FIREWORKS BEGIN AROUND 10:30

FIREWORKS LOCATION: Philadelphia Museum of Art, Benjamin Franklin Parkway
Where to Watch the Fireworks on the 4th:

There are several great places to watch the fireworks.

- Lemon Hill
– Benjamin Franklin Parkway
– Boathouse Row
– Kelly Drive
– Martin Luther King Drive
– Schuylkill River Park

Time: The fireworks display is estimated to begin around 10:30 p.m

<h3> Where to Watch the Concert: </h3>

The best place from which to watch the concert is on the Benjamin Franklin Parkway. Giant screens and speakers will broadcast the concert all along the Parkway.
<h3>Viewing Tips: </h3>

Arrive early. Bring lawn chairs, a blanket and a picnic. If you get to the Parkway early, you will be able to grab a great location for viewing the concert and the fireworks.

<h3>Concert Details & Performers </h3>

Concert begins at 8:30 p.m., July 4, 2010

The Goo Goo Dolls will headline this year&acute;s concert, which features performances by Philly favorites: The Roots, R&B singer Chrisette Michelle and Washington D.C.&acute;s Chuck Brown.
July 4th Parade in Historic Philadelphia, 11:00 a.m., July 4, 2010

This year, Philadelphia&acute;s main parade fittingly takes place in Historic Philadelphia. Do not miss it!
Party on the Parkway Festival, 1:00 – 7:00 p.m., July 4, 2010

Bring your appetite and your red, white and blue apparel as an exciting, family-friendly festival stretches along Benjamin Franklin Parkway from The Franklin to the steps of the Philadelphia Museum of Art.

<h3>Insider Tip </h3>

Bring lawn chairs, a blanket and a picnic while you watch the parade. Then stay for the concert and fireworks. If you arrive early, you&acute;ll be able to grab a great location for viewing all three.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival','Feature'),
					"post_tags"		=>	array('Fireworks')
					);
////post end///
/// Festival ////post start 3//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival6.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival10.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '121 N. Columbus Boulevard The Great Plaza at Penn&acute;s Landing, Philadelphia, PA 19106',
					"geo_latitude"	=> '39.9464558',
					"geo_longitude"	=> '-75.1414196',
					"timing"		=> 'August 22, 2010; 2-8 p.m.',
					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@pennslandingcorp.com',
					"website"		=> 'http://www.pennslandingcorp.com/',
					"twitter"		=> 'http://twitter.com/pennslandingcorp',
					"facebook"		=> 'http://facebook.com/pennslandingcorp',
					"is_featured"	=> '1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '2',
				);
$post_info[] = array(
					"post_title"	=>	'Caribbean Festival',
					"post_content"	=>	'
<h3>The Experience</h3>

Travel to the Islands without leaving Philadelphia for the 25th annual Caribbean Festival at Penn&acute;s Landing Great Plaza. This free festival of Caribbean traditions, music and food is a culturally rich celebration of 14 Caribbean Islands featuring a collage of sights, sounds, aromas and tastes.

With entertainment as the focal point of the event, you&acute;ll be surrounded by the authentic island sounds of reggae, soca/calypso, hip-hop and gospel. There will also be creative dances, ethnic poetry and educational activities.

Fragrant aromas will fill the Great Plaza as the vendors prepare a variety of tempting island cuisine for visitors to enjoy. At the Caribbean marketplace, visitors can browse displays of island fashions, souvenirs and arts and crafts.

In addition, the Caribbean Culture booth will complement this year&acute;s event with featured topics about Caribbean history, fashion and religion. For the youngest attendees, the Festival offers a Caribbean Children&acute;s Village to teach children about the African-Caribbean culture awareness.
Additional Information

Admission is free for all PECO Multicultural Series events. PECO presents a series of free Multicultural festivals throughout the summer season at the Great Plaza at Penn&acute;s Landing.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival','Feature'),
					"post_tags"		=>	array('Fireworks')
					);
////post end///
/// Festival ////post start 3//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival11.jpg";
$image_array[] = "dummy/festival6.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '121 N. Columbus Boulevard The Great Plaza at Penn&acute;s Landing, Philadelphia, PA 19106',
					"geo_latitude"	=> '39.9464558',
					"geo_longitude"	=> '-75.1414196',
					"timing"		=> 'August 22, 2010; 2-8 p.m.',
					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@pennslandingcorp.com',
					"website"		=> 'http://www.pennslandingcorp.com/',
					"twitter"		=> 'http://twitter.com/pennslandingcorp',
					"facebook"		=> 'http://facebook.com/pennslandingcorp',
					"is_featured"	=> '1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '2',
				);
$post_info[] = array(
					"post_title"	=>	'Caribbean Festival',
					"post_content"	=>	'
<h3>The Experience</h3>

Travel to the Islands without leaving Philadelphia for the 25th annual Caribbean Festival at Penn&acute;s Landing Great Plaza. This free festival of Caribbean traditions, music and food is a culturally rich celebration of 14 Caribbean Islands featuring a collage of sights, sounds, aromas and tastes.

With entertainment as the focal point of the event, you&acute;ll be surrounded by the authentic island sounds of reggae, soca/calypso, hip-hop and gospel. There will also be creative dances, ethnic poetry and educational activities.

Fragrant aromas will fill the Great Plaza as the vendors prepare a variety of tempting island cuisine for visitors to enjoy. At the Caribbean marketplace, visitors can browse displays of island fashions, souvenirs and arts and crafts.

In addition, the Caribbean Culture booth will complement this year&acute;s event with featured topics about Caribbean history, fashion and religion. For the youngest attendees, the Festival offers a Caribbean Children&acute;s Village to teach children about the African-Caribbean culture awareness.
Additional Information

Admission is free for all PECO Multicultural Series events. PECO presents a series of free Multicultural festivals throughout the summer season at the Great Plaza at Penn&acute;s Landing.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival','Feature'),
					"post_tags"		=>	array('')
					);
////post end///
/// Festival ////post start 3//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival12.jpg";
$image_array[] = "dummy/festival13.jpg";
$image_array[] = "dummy/festival14.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '114 W. State Street Kennett Square, PA 19348',
					"geo_latitude"	=> '39.8466433',
					"geo_longitude"	=> '-75.7119121',
					"timing"		=> 'September 11 and 12, 2010.',
					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@pennslandingcorp.com',
					"website"		=> 'http://www.pennslandingcorp.com/',
					"twitter"		=> 'http://twitter.com/pennslandingcorp',
					"facebook"		=> 'http://facebook.com/pennslandingcorp',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Kennett Square Mushroom Festival',
					"post_content"	=>	'
<h3>The Experience</h3>

Travel to the Islands without leaving Philadelphia for the 25th annual Caribbean Festival at Penn&acute;s Landing Great Plaza. This free festival of Caribbean traditions, music and food is a culturally rich celebration of 14 Caribbean Islands featuring a collage of sights, sounds, aromas and tastes.

With entertainment as the focal point of the event, you&acute;ll be surrounded by the authentic island sounds of reggae, soca/calypso, hip-hop and gospel. There will also be creative dances, ethnic poetry and educational activities.

Fragrant aromas will fill the Great Plaza as the vendors prepare a variety of tempting island cuisine for visitors to enjoy. At the Caribbean marketplace, visitors can browse displays of island fashions, souvenirs and arts and crafts.

In addition, the Caribbean Culture booth will complement this year&acute;s event with featured topics about Caribbean history, fashion and religion. For the youngest attendees, the Festival offers a Caribbean Children&acute;s Village to teach children about the African-Caribbean culture awareness.
Additional Information

Admission is free for all PECO Multicultural Series events. PECO presents a series of free Multicultural festivals throughout the summer season at the Great Plaza at Penn&acute;s Landing.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival'),
					"post_tags"		=>	array('Mushroom')
					);
////post end///
/// Festival ////post start 4//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival15.jpg";
$image_array[] = "dummy/festival13.jpg";
$image_array[] = "dummy/festival14.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '12th and Arch Streets Reading Terminal Market Philadelphia, PA 19107',
					"geo_latitude"	=> '39.953109',
					"geo_longitude"	=> '-75.159589',
					"timing"		=> 'September 11 and 12, 2010.',
					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@readingterminalmarket.com',
					"website"		=> 'http://www.readingterminalmarket.org/',
					"twitter"		=> 'http://twitter.com/readingterminalmarket',
					"facebook"		=> 'http://facebook.com/readingterminalmarket',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Reading Terminal Market&acute;s Pennsylvania Dutch Festival',
					"post_content"	=>	'
Celebrate the traditions, foods and crafts of the Pennsylvania Dutch at the 21st annual Pennsylvania Dutch Festival at the historic Reading Terminal Market.

The three-day festival will take place in the Market&acute;s center court seating area and will feature handmade crafts including quilts, woodcrafts, paintings, hand braided rugs, wooden toys and cedar chests.

Traditional foods including chicken pot pie, donuts, ice cream, pies and canned fruits and vegetables will be available to taste and purchase.

On Saturday, August 13, the festival moves outdoors to create a country fair in the city. The 1100 block of Arch Street will be closed to traffic and a petting zoo with sheep, goats, chickens, donkeys, calves, horses and pigs will fill the street.

Amish buggy rides and horse drawn wagon rides around the Market, as well as country and bluegrass bands, round out the entertainment for this great, family-friendly event.

',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival'),
					"post_tags"		=>	array('Dutch')
					);
////post end///
/// Festival ////post start 4//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival16.jpg";
$image_array[] = "dummy/festival13.jpg";
$image_array[] = "dummy/festival14.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '40 N. 2nd Street The Arden Theatre Company Philadelphia, PA 19106',
					"geo_latitude"	=> '39.9493624',
					"geo_longitude"	=> '-75.1457327',
					"timing"		=> 'September 11 and 12, 2010.',
					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@pgltf.com',
					"website"		=> 'http://www.pgltf.org/',
					"twitter"		=> 'http://twitter.com/pgltf',
					"facebook"		=> 'http://facebook.com/pgltf',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Philadelphia Gay and Lesbian Theatre Festival',
					"post_content"	=>	'
The Philadelphia Gay and Lesbian Theatre Festival has been canceled for 2010.

The Seventh Annual Philadelphia Gay and Lesbian Theatre Festival (PGLTF) begins its loud and proud two-week run on June 11, 2009. Several theater productions celebrate the gay, lesbian, bisexual and transgender experience through the art of theater.

The festival typically included both local and international premieres of critically acclaimed dramas, comedies, musicals and one-person shows. All productions aim to entertain, educate, empower, enlighten, challenge and delight audiences.

Topics of previous productions included a musical review of favorite Broadway tunes coming to life with a decidedly gay perspective; dealing with one inner burdens while on a pilgrimage to India; turning the damages of sexual abuse to that which gives rise to transformation; intertwined lives of gay men and the women who love them; delving into whether Shakespeare was bi-sexual and if the subject of his love sonnets was a young boy; as well as two productions specifically presented as a part of our Young Audience Presentations.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival'),
					"post_tags"		=>	array('Market')
					);
////post end///
/// Festival ////post start 5//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival17.jpg";
$image_array[] = "dummy/festival13.jpg";
$image_array[] = "dummy/festival14.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> 'Walnut Street and Columbus Boulevard, Philadelphia, PA 19106',
					"geo_latitude"	=> '39.945345',
					"geo_longitude"	=> '-75.141415',
					"timing"		=> 'July 3-5 (12 noon – 5 p.m.; 6-9 p.m. again on July 3)',
					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@welcomeamerica.com',
					"website"		=> 'http://www.welcomeamerica.com/',
					"twitter"		=> 'http://twitter.com/welcomeamerica',
					"facebook"		=> 'http://facebook.com/welcomeamerica',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Super Scooper All-You-Can-Eat Ice Cream Festival',
					"post_content"	=>	'
<h3>The Experience</h3>

What better way to raise money for children with leukemia than to eat your favorite kind of ice cream?

At Wawa Welcome America!‘s annual Super Scooper All-You-Can-Eat Ice Cream Festival, you can do just that - as well as enjoy free music, live entertainment and games for the whole family!

At this annual celebration of sweetness, more than 20 ice cream and water ice companies will serve up their cool, creamy treats. After paying the $5 admission, ice cream lovers are given a spoon and unlimited access to their favorites. Clearly, this is no time to count calories.

All proceeds from the event will benefit the Joshua Kahan Fund and the fight to cure pediatric leukemia.
<h3>Additional Information </h3>

Pavilion hours will be 12 to 5 p.m. each day, and again from 6 to 9 p.m. on July 3.

A $5 donation is required to enter the pavilion.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival'),
					"post_tags"		=>	array('')
					);
////post end///
/// Festival ////post start 5//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival18.jpg";
$image_array[] = "dummy/festival19.jpg";
$image_array[] = "dummy/festival20.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> 'Columbus Boulevard at Spring Garden Street, Festival Pier at Penn&acute;s Landing, Philadelphia, PA 19123',
					"geo_latitude"	=> '39.9644549',
					"geo_longitude"	=> '-75.1457893',
					"timing"		=> 'June 5, 2010 (Saturday) Event starts at 2 p.m.',
					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@okayplayer.com',
					"website"		=> 'http://www.okayplayer.com/rootspicnic/',
					"twitter"		=> 'http://twitter.com/okayplayer',
					"facebook"		=> 'http://facebook.com/okayplayer',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'The Roots Picnic',
					"post_content"	=>	'
<h3>Location </h3>

Festival Pier at Penn&acute;s Landing
Columbus Boulevard at Spring Garden Street
<h3>The Festival </h3>

The Roots - the Philly natives also known as the Legendary Roots Crew - have gathered a diverse lineup of talent for this third annual music festival, including: Vampire Weekend, Mayer Hawthorne, The Very Best, Clipse, Nneka, Jay Electronica, Tune-Yards, Das Racist and more - including a performance by Wu-Tang members Raekwon, Method Man and Ghostface.

Of course, The Roots couldn&acute;t just throw a music festival with their favorite acts and not grace the stage. The hometown heroes will be performing two sets of their unique, high-energy live sound.

Live music will be playing from two stages during this all-day event.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival'),
					"post_tags"		=>	array('Picnic')
					);
////post end///
/// Festival ////post start 6//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival21.jpg";
$image_array[] = "dummy/festival19.jpg";
$image_array[] = "dummy/festival20.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '4601 N. 18th Street Philadelphia, PA 19140',
					"geo_latitude"	=> '40.023817',
					"geo_longitude"	=> '-75.1545658',
					"timing"		=> 'June 5, 2010 (Saturday) Event starts at 2 p.m.',
					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@revolutionarygermantown.com',
					"website"		=> 'http://www.revolutionarygermantown.org/',
					"twitter"		=> 'http://twitter.com/revolutionarygermantown',
					"facebook"		=> 'http://facebook.com/revolutionarygermantown',
					"is_featured"	=> '1',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '2',
				);
$post_info[] = array(
					"post_title"	=>	'Revolutionary Germantown Festival',
					"post_content"	=>	'
You are never far from history when in Germantown, one of Philadelphia&acute;s most historic neighborhoods. However, it is on full display during the Revolutionary Germantown Festival, a day-long festival that celebrates the rich history of Germantown and features the annual reenactment of the Battle of Germantown, the only military battle ever fought within the borders of Philadelphia.

Escorted bus and walking tours make getting around simple while special programs at ten historic sites throughout the community provide something for every size and taste.

Learn the inside stories of some of Philadelphia&acute;s most important colonial landmarks: put your hand to colonial paper-making techniques at Historic Rittenhouse Town; try out some early American toys at Upsala; and “meet” British General Howe at the Deshler-Morris House, his one-time war headquarters. The historic re-enactment of the 1777 Battle of Germantown takes place at Cliveden.

In addition to Rittenhouse Town, Upsala, the Deschler-Morris House and Clivedon, you&acute;ll visit the Concord School and Upper Burying Ground, where solider and officers are buried; Grumblethorpe, site of one of the battles legendary death scenes; the Johnson House, which showcase the role of African-Americans in the Revolutionary War; and two of the cities most famous colonial houses, Stenton and Wyck.
<h3>Come Prepared </h3>

There is fee for entry and parking may be limited. It is recommended that visitors consider taking public transportation to Germantown Avenue for the festivities.
<h3>Don&acute;t Miss </h3>

The battle reenactments at Cliveden are absolute must-sees.
<h3>Outsider&acute;s Tip</h3>

Make the most of Revolutionary Germantown Festival by purchasing a Passport that covers the cost of admission to all participating sites for the day. The Passport contains a list of the timed events throughout the day along with a map for self guided walking tours of the Germantown area. Passports can be pre-ordered or purchased the day of the event. An individual pass is $15 and the family pass is $25.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival','Feature'),
					"post_tags"		=>	array('Market')
					);
////post end///
/// Festival ////post start 7//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival22.jpg";
$image_array[] = "dummy/festival19.jpg";
$image_array[] = "dummy/festival20.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '41 Peddler Village Road Peddler Village, Lahaska, PA 18931',
					"geo_latitude"	=> '40.3467149',
					"geo_longitude"	=> '-75.0351143',
					"timing"		=> 'May 1-2, 2010',
					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@peddlersvillage.com',
					"website"		=> 'http://www.peddlersvillage.com/',
					"twitter"		=> 'http://twitter.com/peddlersvillage',
					"facebook"		=> 'http://facebook.com/peddlersvillage',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Strawberry Festival at Peddler Village',
					"post_content"	=>	'
<h3>The Experience </h3>

Celebrate spring at Peddler&acute;s Village&acute;s celebrated Strawberry Festival, where festive foods, children&acute;s activities, pie-eating contests and a lively lineup of family entertainment are just some of the weekend&acute;s exciting attractions.

Culinary highlights include strawberries served fresh and unadorned, dipped in chocolate and deep-fried in fritters or simply in shortcake, assorted pastries and fruit smoothies. More than 30 craftspeople will exhibit and sell their original handcrafted works.

Artisans show their wares and demonstrate their skills at the Street Road Green Artisan Area, while live entertainment and pie-eating contests add to the festivities of this traditional Spring celebration.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival'),
					"post_tags"		=>	array('')
					);
////post end///
/// Festival ////post start 8//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival23.jpg";
$image_array[] = "dummy/festival24.jpg";
$image_array[] = "dummy/festival25.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> 'Great Plaza at Penn Landing Columbus Boulevard and Chestnut Street Philadelphia, PA 19106',
					"geo_latitude"	=> '39.9488133',
					"geo_longitude"	=> '-75.1471936',
					"timing"		=> 'Friday, June 25 - 5 p.m.',
					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@welcomeamerica.com',
					"website"		=> 'http://www.welcomeamerica.com/',
					"twitter"		=> 'http://twitter.com/welcomeamerica',
					"facebook"		=> 'http://facebook.com/welcomeamerica',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Taste of Philadelphia',
					"post_content"	=>	'
A favorite of foodies, Taste of Philadelphia - the official kick-off to Wawa Welcome America! - returns for the fifth year, with more restaurants than ever joining the gastronomical festivities. Some of the city&acute;s most popular eateries serve up their specialties, and entertainment by Morris Day and the Time & to the festive atmosphere.

Admission to Penn&acute;s Landing is free and the “tastes” from participating restaurants are just a few dollars - a fraction of regular entrée-sized prices.
Dates & Times

Friday, June 25
5 p.m.

Interested in sampling cuisine from the region&acute;s best chefs? Check out the opening of three days of Taste of Philadelphia. Come and try amazing dishes from some of the most popular restaurants in the city and find new favorite menu items! Stroll the waterfront while you&acute;re “dining” and listen to local musical performers.

Saturday, June 26
11 a.m.

Taste of Philadelphia continues with its first full day of music, food and fun! Sample some of the best cuisine in the city. There&acute;s music all day to enjoy and help you keep your appetite up. Stay for the evening concert (8 p.m.)starring Morris Day & The Time, followed by the first of three fireworks displays during Wawa Welcome America!.

Sunday, June 27
11 a.m.

Don&acute;t miss the final day to sample delicious bites from Philadelphia&acute;s many restaurants. There&acute;s more music and fun to be had, so bring your family and friends!
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival'),
					"post_tags"		=>	array('Taste')
					);
////post end///
/// Festival ////post start 9//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival26.jpg";
$image_array[] = "dummy/festival24.jpg";
$image_array[] = "dummy/festival25.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> 'Market Street and W. Delaware Avenue, Market Square Memorial Park (Site of the largest festival), Marcus Hook, PA 19061',
					"geo_latitude"	=> '39.8192734',
					"geo_longitude"	=> '-75.4185221',
					"timing"		=> 'September 18-20, 2010',
					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@riverfrontramble.com',
					"website"		=> 'http://www.riverfrontramble.org/',
					"twitter"		=> 'http://twitter.com/riverfrontramble',
					"facebook"		=> 'http://facebook.com/riverfrontramble',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Riverfront Ramble',
					"post_content"	=>	'
<h3>The Experience </h3>

The Riverfront Ramble, a massive, 14-mile-long party and festival celebrating Delaware County&acute;s waterfront communities, caps off your summer with a day of fun.

Towns from Marcus Hook to Tinicum Township roll out the welcome mat for visitors with a September festival of food, crafts, music, boats, contests, fireworks and much more.

Nibbling is easy along the entire river route, but it&acute;s in Marcus Hook&acute;s Market Square Memorial Park where more than 20 restaurants and caterers put on a serious festival of food.

There will be free concerts, hot air balloon rides, craft shows, boating and family-friendly activities to enjoy all weekend long. Don&acute;t miss it!

Enjoy a family day on the Delaware River that mingles old memories with beautiful new recreational areas. Boating is encouraged, whether it&acute;s under sail, paddle or motor. Boat shows, tall ships, car shows and sports clinics are included, as is a wildlife tour at the John Heinz Wildlife Refuge in Tinicum Township - fun for birdwatchers, butterfly watchers, or anyone with a camera.

Through it all, you can witness the changing face of Brandywine&acute;s waterfront, a region rich in history and brimming with the development of beautiful new parks. The 14-mile trail will be included in the coastal zone bike trail, which will allow bikers to pedal the entire eastern coastline.
Come Prepared

Bring a sweater, blanket or beach chair for concerts and fireworks, which are spread out over three towns. There will be food and beverage vendors at all locations.
<h3>Don&acute;t Miss </h3>

Three riverfront fireworks displays at 8:45, for a full, 14-mile display
<h3>Outsider  Tip</h3>

The Ramble is capped off each year with a string of evening concerts from three separate locations along the river, Barry Bridge Park in Chester, Market Square Memorial Park in Marcus Hook and Governor Printz Park in Tinicum. The concerts are followed by dazzling fireworks displays launched from all three locations!
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival'),
					"post_tags"		=>	array('')
					);
////post end///
/// Festival ////post start 10//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival27.jpg";
$image_array[] = "dummy/festival24.jpg";
$image_array[] = "dummy/festival25.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> 'Market Street and W. Delaware Avenue, Market Square Memorial Park (Site of the largest festival), Marcus Hook, PA 19061',
					"geo_latitude"	=> '39.8192734',
					"geo_longitude"	=> '-75.4185221',
					"timing"		=> 'August 14-16, 2010',
					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@folkfest.com',
					"website"		=> 'http://www.folkfest.org/',
					"twitter"		=> 'http://twitter.com/folkfest',
					"facebook"		=> 'http://facebook.com/folkfest',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Philadelphia Folk Festival',
					"post_content"	=>	'
The hills of Schwenksville, Pennsylvania come alive every summer when music legends like Arlo Guthrie, Pete Seeger and Richie Havens share the sunlight at this festival of folk music and dance in the green valley of Schwenksville&acute;s Old Poole Farm.

This year&acute;s 48th annual festival features such notable acts as Adrien Reju, the Del McCoury Band and Iron and Wine, among others. All told, the festival features more than 75 hours of great folk music and more than 60 talented musicians.

Join thousands of people sprawled out on the hillside as you sing along, clap or just enjoy the music that fills the pastoral landscape. Five stages operate simultaneously, and daytime showcase concerts feature an array of exciting new performers.

Music is everywhere - from late-night singalongs, to bonfires in the festival campgrounds, to parking lot pickers having their own impromptu jam sessions. Don&acute;t miss it!
<h3> History </h3>

The festival, which is produced and run by volunteers and sponsored by the non-profit Philadelphia Folksong Society, has been bringing world-class folk music to the area for nearly 50 years, and many music fans plan their vacations around the event.

The Philadelphia Folksong Society, the premiere folk organization in the greater Philadelphia region, is known nationally and internationally for producing the famous festival. It offers a wealth of member benefits, including Free House Concerts and Workshops and Sings as well as discounts to many other events.
<h3>COME PREPARED </h3>

Tickets range in price according to length of stay at the event, and you get a discount if you buy them in advance.
<h3>DON&acute;t MISS </h3>

A mind-boggling craft show, which offer demonstrations as well as merchandise. And if you&acute;re up for a fun weekend of camping, check out the special free concert in the campground Thursday night, which is only open to Festival Camping ticket holders.
Outsider Tip

Prominent artists like Bob Dylan, Tommy Smothers and Bonnie Raitt have shown up unannounced at the festival so look out for familiar stars. 
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Festival'),
					"post_tags"		=>	array('')
					);
////post end///
//====================================================================================//
////post start 1///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "video"	=> '<iframe width="300" height="233" src="http://www.youtube.com/embed/WK3eH8kZQVQ?rel=0" frameborder="0" ></iframe>',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'BP debt rating is cut as gulf oil leak costs mount',
					"post_content"	=>	'Moodys Investors Service and Fitch Ratings reduce their credit ratings for the oil giant, which estimates the cleanup and containment could cost it $3 billion.Some oil industry analysts say BP might have to sell assets to pay for efforts to stop the Gulf of Mexico oil leak, including the drilling of a relief well, above, and clean up the mess. Others say the company has enough cash to foot the bill. BP is becoming the new pariah of the oil industry and faces the possibility of having to sell assets if it cant show some success in the coming weeks at stemming the flow of crude into the Gulf of Mexico, Wall Street analysts and energy experts say.

The fallout from the deadly Deepwater Horizon drilling rig explosion in April continued Thursday, when credit rating firms Moodys Investors Service and Fitch Ratings reduced their assessments of BPs long-term debt.Fitch cut the oil giant to AA from AA-plus, citing the potential for civil and criminal charges and saying "risks to both BPs business and financial profile continue to increase.Fitch estimated that the company could spend as much as $3 billion on cleanup and containment this year. The federal government Thursday sent BP its first bill covering oil-spill response costs so far, totaling $69 million.

Moodys lowered BP to AA2 from AA1 and put it on review, which might lead to another downgrade. Moodys said costs related to the protracted oil leak will "weigh significantly" on BPs cash and "constrain its ability to focus on other key areas of the company business. ',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Videos'),
					"post_tags"		=>	array('Tags','Sample Tags')
					);
////post end///
////post start 2 ///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/zUM-mR_VbBA&hl=en_GB&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/zUM-mR_VbBA&hl=en_GB&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Chasing musical legends in Joshua Tree National Park',
					"post_content"	=>	'The wide opens spaces, accommodating inns and restaurants, and the echoes of Gram Parsons draw them to the desert each year. But during this visit, a lively 3-year-old is in the mix.

Reporting from Twentynine Palms — Typically, we go to the desert at least once a year. We love the expansive space, several of the inns and restaurants and, of course, the otherworldly foliage of Joshua Tree National Park. We also enjoy the musical legacy of Gram Parsons, the former Byrd who overdosed in Joshua Tree in 1973, at age 26, after virtually inventing the alt-country movement that would blossom two decades later. We feel these echoes and others — the twangy music, the lands natural contours, the local cuisine — when were there.
But this year, my wife, Sara — a former music journalist — and I had one complication: our eager but mischievous son. Ian is no more difficult than the typical 3-year-old boy, but he loves life so unambiguously that he can be hard to corral. Traveling with a toddler is a whole different ballgame: We figured some things would be better, some things worse, but we did know quite how it would all work out.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Videos'),
					"post_tags"		=>	array('New','Popular')
					);
////post end///
////post start 3 ///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/tBb4cjjj1gI&hl=en_GB&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/tBb4cjjj1gI&hl=en_GB&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Auto-Tune the News',
					"post_content"	=>	' The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.

	<blockquote> The river was not high, so there was not more than a two or three mile current. Hardly a word was
said during the next three-quarters of an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the vague vast sweep of star-gemmed water, unconscious of the tremendous event that was happening. </blockquote>
	<ul>
     <li>The Black Avenger stood still with folded arms, "looking his last" upon </li>
    <li>the scene of his former joys and his later sufferings, and wishing</li>
     <li>"she" could see him now, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson Island</li>
     <li>beyond eyeshot of the village, and so he "looked his last" with a</li>
     <li> broken and satisfied heart. The other pirates were looking their last </li>
     <li> too; and they all looked so long that they came near letting the</li>
	 </ul>

current drift them out of the range of the island. But they discovered the danger in time, and made shift to avert it. About two oclock in the morning the raft grounded on the bar two hundred yards above the head of the island, and they waded back and forth until they had landed their freight.

Part of the little raft belongings consisted of an old sail, and this they spread over a nook in the bushes for a tent to shelter their provisions; but they themselves would sleep in the open air in good weather, as became outlaws.

<ol>
   <li> They built a fire against the side of a great log twenty or thirty</li>
   <li> steps within the sombre depths of the forest, and then cooked some</li>
   <li> bacon in the frying-pan for supper, and used up half of the corn "pone"</li>
   <li>  stock they had brought. It seemed glorious sport to be feasting in that</li>
   <li> wild, free way in the virgin forest of an unexplored and uninhabited</li>
   <li> island, far from the haunts of men, and they said they never would</li>
   <li> return to civilization. The climbing fire lit up their faces and threw</li>
   <li> its ruddy glare upon the pillared tree-trunks of their forest temple,</li>
   <li> and upon the varnished foliage and festooning vines.</li>
 </ol>

When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Videos'),
					"post_tags"		=>	array('Sample Tag')
					);
////post end///
////post start 4 ///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/i_f3SkxTWxc&hl=en_GB&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/i_f3SkxTWxc&hl=en_GB&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Top 10 quirky science tricks for parties',
					"post_content"	=>	'Presently she stepped into the kitchen, and Sid, happy in his immunity, reached for the sugar-bowl–a sort of glorying over Tom which
was wellnigh unbearable. But Sid fingers slipped and the bowl dropped and broke. Tom was in ecstasies. In such ecstasies that he even controlled his tongue and was silent. He said to himself that he would not speak a word, even when his aunt came in, but would sit perfectly
still till she asked who did the mischief; and then he would tell, and there would be nothing so good in the world as to see that pet model "catch it." He was so brimful of exultation that he could hardly hold himself when the old lady came back and stood above the wreck discharging lightnings of wrath from over her spectacles. He said to himself, "Now it coming!" And the next instant he was sprawling on the floor! The potent palm was uplifted to strike again when Tom cried out',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Videos'),
					"post_tags"		=>	array('Tag 1')
					);
////post end///
////post start 5 ///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/X4zd4Qpsbs8&hl=en_GB&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/X4zd4Qpsbs8&hl=en_GB&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'The river was not high, so there was not more',
					"post_content"	=>	'
					The river was not high, so there was not more than a two or three mile current. Hardly a word was
said during the next three-quarters of an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the vague vast sweep of star-gemmed water, unconscious of the tremendous event that was happening. 

					<blockquote> The river was not high, so there was not more than a two or three mile current. Hardly a word was
said during the next three-quarters of an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the vague vast sweep of star-gemmed water, unconscious of the tremendous event that was happening. </blockquote>
	<ul>
     <li>The Black Avenger stood still with folded arms, "looking his last" upon </li>
    <li>the scene of his former joys and his later sufferings, and wishing</li>
     <li>"she" could see him now, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson Island</li>
     <li>beyond eyeshot of the village, and so he "looked his last" with a</li>
     <li> broken and satisfied heart. The other pirates were looking their last </li>
     <li> too; and they all looked so long that they came near letting the</li>
	 </ul>

current drift them out of the range of the island. But they discovered the danger in time, and made shift to avert it. About two oclock in the morning the raft grounded on the bar two hundred yards above the head of the island, and they waded back and forth until they had landed their freight.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Videos'),
					"post_tags"		=>	array('Beauty')
					);
////post end///
////post start 6 ///
$image_array = array();
$post_meta = array();
$post_meta = array(
				   "video"	=> '<object height="319" width="480" type="application/x-shockwave-flash" data="http://c.brightcove.com/services/viewer/federated_f9?&amp;width=480&amp;height=319&amp;flashID=bc_player&amp;bgcolor=%23FFFFFF&amp;publisherID=1749339200&amp;isVid=true&amp;wmode=transparent&amp;playerID=53548472001&amp;%40videoPlayer=ref%3A1247468020452&amp;autoStart=" id="bc_player" class="BrightcoveExperience"><param name="allowScriptAccess" value="always"><param name="allowFullScreen" value="true"><param name="seamlessTabbing" value="false"><param name="swliveconnect" value="true"><param name="wmode" value="transparent"><param name="quality" value="high"><param name="bgcolor" value="#FFFFFF"></object>',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
					"package_pid"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'New Video Shows Haiti Earthquake',
					"post_content"	=>	'
					The river was not high, so there was not more than a two or three mile current. Hardly a word was
said during the next three-quarters of an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the vague vast sweep of star-gemmed water, unconscious of the tremendous event that was happening. 

					<blockquote> The river was not high, so there was not more than a two or three mile current. Hardly a word was
said during the next three-quarters of an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the vague vast sweep of star-gemmed water, unconscious of the tremendous event that was happening. </blockquote>
	<ul>
     <li>The Black Avenger stood still with folded arms, "looking his last" upon </li>
    <li>the scene of his former joys and his later sufferings, and wishing</li>
     <li>"she" could see him now, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson Island</li>
     <li>beyond eyeshot of the village, and so he "looked his last" with a</li>
     <li> broken and satisfied heart. The other pirates were looking their last </li>
     <li> too; and they all looked so long that they came near letting the</li>
	 </ul>

current drift them out of the range of the island. But they discovered the danger in time, and made shift to avert it. About two oclock in the morning the raft grounded on the bar two hundred yards above the head of the island, and they waded back and forth until they had landed their freight.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Videos'),
					"post_tags"		=>	array('Beauty')
					);
////post end///


insert_posts($post_info);
function insert_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='place' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			/*if($post_info_arr['post_category'])
			{
				for($c=0;$c<count($post_info_arr['post_category']);$c++)
				{
					$catids_arr[] = get_cat_ID($post_info_arr['post_category'][$c]);
				}
			}else
			{
				$catids_arr[] = 1;
			}*/
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = 'place';
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $catids_arr;
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			wp_set_object_terms($last_postid, $post_info_arr['post_tags'], $taxonomy='place_tags');
			wp_set_object_terms($last_postid,$post_info_arr['post_category'], $taxonomy='placecategory');
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'inherit';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}
############ insert blog posts ####################
insert_blog_posts($blog_info);
function insert_blog_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='post' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			/*if($post_info_arr['post_category'])
			{
				for($c=0;$c<count($post_info_arr['post_category']);$c++)
				{
					$catids_arr[] = get_cat_ID($post_info_arr['post_category'][$c]);
				}
			}else
			{
				$catids_arr[] = 1;
			}*/
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = 'post';
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $catids_arr;
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			wp_set_object_terms($last_postid, $post_info_arr['post_tags'], $taxonomy='post_tag');
			wp_set_object_terms($last_postid,$post_info_arr['post_category'], $taxonomy='category');
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'inherit';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}
//====================================================================================//
/////////////////////////////////////////////////

$pages_array = array(array('About','Sub Page 1','Sub Page 2'),'FAQs','Terms',array('Archive Pages','Sub Page in 1','Sub Page in 2','Site Map'));
$page_info_arr = array();
$page_info_arr['About'] = '
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
<p>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
';
$page_info_arr['Sub Page 1'] = '
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
<p>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
<p>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
';
$page_info_arr['Sub Page 2'] = '
<pLorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<P>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<p>Justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>

<p>Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>
';
$page_info_arr['Advertise'] = '
<pLorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<P>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<p>Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>
';
$page_info_arr['FAQs'] = '
<pLorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<P>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<p>Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>
';
$page_info_arr['Terms'] = '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

The river was not high, so there was not more <a href="http://skeevisarts.com">than a two or three mile current</a>. Hardly a word was
said<strong> during the next three-quarters of</strong> an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the <em>vague vast sweep</em> of star-gemmed water, unconscious of the <span style="text-decoration: underline;">tremendous</span> event that was happening.
<ul>
	<li>The <strong>Black Avenger</strong> stood still with folded arms, "looking his last" upon</li>
	<li>the scene of his former joys and his later sufferings, and wishing</li>
	<li>"she" <em>could see him now</em>, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jacksons Island</li>
	<li>beyond eyeshot of the village, and so he "looked his last" with a</li>
	<li>broken and satisfied heart. <span style="text-decoration: underline;">The other pirates</span> were looking their last,</li>
	<li>too; and they all <a href="#">looked</a> so long that they came near letting the</li>
</ul> 

current drift them out of the range of the island. But they discovered the danger in time, and made shift to avert it. About two oclock in the morning the raft grounded on the bar two hundred yards above the head of the island, and they waded back and forth until they had landed their freight.
<p style="text-align: center;">Part of the little rafts belongings consisted of an old sail, and this they spread over a nook in the bushes for a tent to shelter their provisions; but they themselves would sleep in the open air in good weather, as became outlaws.
<ol>
	<li>They built a fire against the side of a great log twenty or thirty</li>
	<li>steps within the sombre depths of the forest, and then cooked some</li>
	<li>bacon in the frying-pan for supper, and used up half of the corn "pone"</li>
	<li>stock they had brought. It seemed glorious sport to be feasting in that</li>
	<li>wild, free way in the virgin forest of an unexplored and uninhabited</li>
	<li>island, far from the haunts of men, and they said they never would</li>
	<li>return to civilization. The climbing fire lit up their faces and threw</li>
	<li>its ruddy glare upon the pillared tree-trunks of their forest temple,</li>
	<li>and upon the varnished foliage and festooning vines.</li>
</ol>
When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.
';
$page_info_arr['Archive Pages'] = '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

<ul>
	<li>The <strong>Black Avenger</strong> stood still with folded arms, "looking his last" upon</li>
	<li>the scene of his former joys and his later sufferings, and wishing</li>
	<li>"she" <em>could see him now</em>, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson&acute;s Island</li>
	<li>beyond eyeshot of the village, and so he "looked his last" with a</li>
	<li>broken and satisfied heart. <span style="text-decoration: underline;">The other pirates</span> were looking their last,</li>
	<li>too; and they all <a href="#">looked</a> so long that they came near letting the</li>
</ul> 

<ol>
	<li>They built a fire against the side of a great log twenty or thirty</li>
	<li>steps within the sombre depths of the forest, and then cooked some</li>
	<li>bacon in the frying-pan for supper, and used up half of the corn "pone"</li>
	<li>stock they had brought. It seemed glorious sport to be feasting in that</li>
	<li>wild, free way in the virgin forest of an unexplored and uninhabited</li>
	<li>island, far from the haunts of men, and they said they never would</li>
	<li>return to civilization. The climbing fire lit up their faces and threw</li>
	<li>its ruddy glare upon the pillared tree-trunks of their forest temple,</li>
	<li>and upon the varnished foliage and festooning vines.</li>
</ol>
';
$page_info_arr['Sub Page in 1'] = '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

current drift them out of the range of the island. But they discovered the danger in time, and made shift to avert it. About two o&acute;clock in the morning the raft grounded on the bar two hundred yards above the head of the island, and they waded back and forth until they had landed their freight.
<p style="text-align: center;">Part of the little raft&acute;s belongings consisted of an old sail, and this they spread over a nook in the bushes for a tent to shelter their provisions; but they themselves would sleep in the open air in good weather, as became outlaws.
<ol>
	<li>They built a fire against the side of a great log twenty or thirty</li>
	<li>steps within the sombre depths of the forest, and then cooked some</li>
	<li>bacon in the frying-pan for supper, and used up half of the corn "pone"</li>
	<li>stock they had brought. It seemed glorious sport to be feasting in that</li>
	<li>wild, free way in the virgin forest of an unexplored and uninhabited</li>
	<li>island, far from the haunts of men, and they said they never would</li>
	<li>return to civilization. The climbing fire lit up their faces and threw</li>
	<li>its ruddy glare upon the pillared tree-trunks of their forest temple,</li>
	<li>and upon the varnished foliage and festooning vines.</li>
</ol>
When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.
';
$page_info_arr['Sub Page in 2'] = '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

The river was not high, so there was not more <a href="http://skeevisarts.com">than a two or three mile current</a>. Hardly a word was
said<strong> during the next three-quarters of</strong> an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the <em>vague vast sweep</em> of star-gemmed water, unconscious of the <span style="text-decoration: underline;">tremendous</span> event that was happening.
<ol>
	<li>They built a fire against the side of a great log twenty or thirty</li>
	<li>steps within the sombre depths of the forest, and then cooked some</li>
	<li>bacon in the frying-pan for supper, and used up half of the corn "pone"</li>
	<li>stock they had brought. It seemed glorious sport to be feasting in that</li>
	<li>wild, free way in the virgin forest of an unexplored and uninhabited</li>
	<li>island, far from the haunts of men, and they said they never would</li>
	<li>return to civilization. The climbing fire lit up their faces and threw</li>
	<li>its ruddy glare upon the pillared tree-trunks of their forest temple,</li>
	<li>and upon the varnished foliage and festooning vines.</li>
</ol>
When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.
';
$page_info_arr['Press'] =  '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

The river was not high, so there was not more <a href="http://skeevisarts.com">than a two or three mile current</a>. Hardly a word was
said<strong> during the next three-quarters of</strong> an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the <em>vague vast sweep</em> of star-gemmed water, unconscious of the <span style="text-decoration: underline;">tremendous</span> event that was happening.
<ul>
	<li>The <strong>Black Avenger</strong> stood still with folded arms, "looking his last" upon</li>
	<li>the scene of his former joys and his later sufferings, and wishing</li>
	<li>"she" <em>could see him now</em>, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson&acute;s Island</li>
	<li>beyond eyeshot of the village, and so he "looked his last" with a</li>
	<li>broken and satisfied heart. <span style="text-decoration: underline;">The other pirates</span> were looking their last,</li>
	<li>too; and they all <a href="#">looked</a> so long that they came near letting the</li>
</ul> 
When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.
';
$page_info_arr['Site Map'] =  '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

The river was not high, so there was not more <a href="http://skeevisarts.com">than a two or three mile current</a>. Hardly a word was
said<strong> during the next three-quarters of</strong> an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the <em>vague vast sweep</em> of star-gemmed water, unconscious of the <span style="text-decoration: underline;">tremendous</span> event that was happening.
<ul>
	<li>The <strong>Black Avenger</strong> stood still with folded arms, "looking his last" upon</li>
	<li>the scene of his former joys and his later sufferings, and wishing</li>
	<li>"she" <em>could see him now</em>, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson&acute;s Island</li>
	<li>beyond eyeshot of the village, and so he "looked his last" with a</li>
	<li>broken and satisfied heart. <span style="text-decoration: underline;">The other pirates</span> were looking their last,</li>
	<li>too; and they all <a href="#">looked</a> so long that they came near letting the</li>
</ul> 
When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.
';
$page_info_arr['Privacy Policy'] =  '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

The river was not high, so there was not more <a href="http://skeevisarts.com">than a two or three mile current</a>. Hardly a word was
said<strong> during the next three-quarters of</strong> an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the <em>vague vast sweep</em> of star-gemmed water, unconscious of the <span style="text-decoration: underline;">tremendous</span> event that was happening.
<ul>
	<li>The <strong>Black Avenger</strong> stood still with folded arms, "looking his last" upon</li>
	<li>the scene of his former joys and his later sufferings, and wishing</li>
	<li>"she" <em>could see him now</em>, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson&acute;s Island</li>
	<li>beyond eyeshot of the village, and so he "looked his last" with a</li>
	<li>broken and satisfied heart. <span style="text-decoration: underline;">The other pirates</span> were looking their last,</li>
	<li>too; and they all <a href="#">looked</a> so long that they came near letting the</li>
</ul> 
When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.
';
set_page_info_autorun($pages_array,$page_info_arr);
function set_page_info_autorun($pages_array,$page_info_arr_arg)
{
	global $post_author,$wpdb;
	$last_tt_id = 1;
	if(count($pages_array)>0)
	{
		$page_info_arr = array();
		for($p=0;$p<count($pages_array);$p++)
		{
			if(is_array($pages_array[$p]))
			{
				for($i=0;$i<count($pages_array[$p]);$i++)
				{
					$page_info_arr1 = array();
					$page_info_arr1['post_title'] = $pages_array[$p][$i];
					$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p][$i]];
					$page_info_arr1['post_parent'] = $pages_array[$p][0];
					$page_info_arr[] = $page_info_arr1;
				}
			}
			else
			{
				$page_info_arr1 = array();
				$page_info_arr1['post_title'] = $pages_array[$p];
				$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p]];
				$page_info_arr1['post_parent'] = '';
				$page_info_arr[] = $page_info_arr1;
			}
		}

		if($page_info_arr)
		{
			for($j=0;$j<count($page_info_arr);$j++)
			{
				$post_title = $page_info_arr[$j]['post_title'];
				$post_content = addslashes($page_info_arr[$j]['post_content']);
				$post_parent = $page_info_arr[$j]['post_parent'];
				if($post_parent!='')
				{
					$post_parent_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like \"$post_parent\" and post_type='page'");
				}else
				{
					$post_parent_id = 0;
				}
				$post_date = date('Y-m-d H:s:i');
				$post_name = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-'),$post_title));
				$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='page'");
				if($post_name_count>0)
				{
					echo '';
				}else
				{
					$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_title,post_content,post_name,post_parent,post_type) values (\"$post_author\", \"$post_date\", \"$post_date\",  \"$post_title\", \"$post_content\", \"$post_name\",\"$post_parent_id\",'page')";
					$wpdb->query($post_sql);
					$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
					$guid = site_url()."/?p=$last_post_id";
					$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
					$wpdb->query($guid_sql);
					$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
					$wpdb->query($ter_relation_sql);
					update_post_meta( $last_post_id, 'pt_dummy_content', 1 );
				}
			}
		}
	}
}
//====================================================EVENTS START======================================================================================================
$category_array = array('Events');
insert_taxonomy_category($category_array);
function insert_taxonomy_category($category_array)
{ global $wpdb;
	for($i=0;$i<count($category_array);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))
		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				$last_catid = wp_insert_term( $catname, 'eventcategory', $args = array('parent'=>$parent_catid) );
				if($j==0)
				{
					$parent_catid = $last_catid;
				}
			}
			
		}else
		{
			$catname = $category_array[$i];
			$last_catid = wp_insert_term( $catname, 'eventcategory', $args = array('parent'=>$parent_catid) );
			$dummy_image_path = get_template_directory_uri().'/images/dummy/';
			if(is_wp_error($last_catid)){}else{
			if($last_catid['term_id']){update_tax_meta($last_catid['term_id'],'ct_cat_icon',array( 'id' => 'icon', 'src' => $dummy_image_path.'events.png'));}}
		}
	}
}


/// Festival ////post start 1//
$post_info = array();
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$image_array[] = "dummy/festival3.jpg";
$image_array[] = "dummy/festival4.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival6.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival10.jpg";
$image_array[] = "dummy/festival11.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '2600 Benjamin Franklin Parkway, Philadelphia, PA 19130',
					"geo_latitude"	=> '39.9363719',
					"geo_longitude"	=> '-75.158405',
					"timing"		=> 'Date - May 15-16, 2010',
					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@italianmarketfestival.com',
					"website"		=> 'http://www.italianmarketfestival.com/',
					"twitter"		=> 'http://twitter.com/italianmarketfestival',
					"facebook"		=> 'http://facebook.com/italianmarketfestival',
					"is_featured"	=> '1',
					"st_date"	=> '2010-10-21',
					"st_time"	=> '10:00 AM',
					"end_date"	=> '2010-10-23',
					"end_time"	=> '12:00 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$30',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '4',
				);
$post_info[] = array(
					"post_title"	=>	'Street Italian Market Festival',
					"post_content"	=>	'
<h3>The Experience </h3>

For one weekend each May, 9th Street - in the heart of South Philadelphia - closes down traffic and a huge, multi-block festival takes over the neighborhood.

It all starts with the great sights, sounds and aromas of America&acute;s oldest continuously operating open-air market: South Philadelphia&acute;s famous Italian Market. And the most important thing for you to bring with you is your appetite.

In addition to the blocks of curb vendors and specialty butcher, cheese, gift and cookware shops that line the market, there will also be street-side merchants selling specially prepared foods just for the Festival.

Expect to see stands offering a display of fresh sausage and peppers, antipasto salads, roast pork sandwiches, cheeses, cured meats, an infinite array of pastries, famous mango roses and so much more.

Many nearby restaurants will extend their table service to the sidewalk so you can dine alfresco and enjoy the festival atmosphere.

A stunning smorgasbord of flavors will be on full display during the Festival, as vendors line the street, musicians roam the crowds and top chefs show off some of their best techniques at live cooking demonstrations.

For a full schedule and lineup of musicians, performances and demonstrations, be sure to visit the Festival&acute;s official website.
<h3>Insider Tip </h3>

Belying its name, the Italian Market is not just Italian anymore. In fact, it&acute;s a veritable melting pot of international cultures and cuisines.

You can choose from several excellent Asian restaurants serving delicious Vietnamese banh mi sandwiches and piping hot bowls of pho.

Or savor amazingly flavorful tacos, spicy tamales and several other authentic Mexican favorites from La Lupe and Taqueria La Veracruzanas. And that&acute;s just the beginning.

There is so much great eating in and around the Italian Market that you&acute;ll want to return again and again. 
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('')
					);
////post end///
/// Festival ////post start 2//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival10.jpg";
$image_array[] = "dummy/festival6.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival10.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '2600 Benjamin Franklin Parkway, Philadelphia, PA 19130',
					"geo_latitude"	=> '39.9661855',
					"geo_longitude"	=> '-75.1796512',
					"timing"		=> 'July 4, 2010 | 11 a.m. – 11 p.m.',
					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@italianmarketfestival.com',
					"website"		=> 'http://www.italianmarketfestival.com/',
					"twitter"		=> 'http://twitter.com/italianmarketfestival',
					"facebook"		=> 'http://facebook.com/italianmarketfestival',
					"is_featured"	=> '1',
					"st_date"	=> '2010-9-21',
					"st_time"	=> '11:00 AM',
					"end_date"	=> '2010-9-23',
					"end_time"	=> '3:00 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$30',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '4',
				);
$post_info[] = array(
					"post_title"	=>	'Festival, Concert and Fireworks',
					"post_content"	=>	'
This Fourth of July, celebrate America independence with incredible fireworks in Philadelphia during the annual Wawa Welcome America! festival!
THE MAIN EVENT

<h3>Concert & Fireworks Display </h3>

8:30 – 11:00 p.m., July 4, 2010

CONCERT BEGINS AT 8:30 – FIREWORKS BEGIN AROUND 10:30

FIREWORKS LOCATION: Philadelphia Museum of Art, Benjamin Franklin Parkway
Where to Watch the Fireworks on the 4th:

There are several great places to watch the fireworks.

- Lemon Hill
– Benjamin Franklin Parkway
– Boathouse Row
– Kelly Drive
– Martin Luther King Drive
– Schuylkill River Park

Time: The fireworks display is estimated to begin around 10:30 p.m

<h3> Where to Watch the Concert: </h3>

The best place from which to watch the concert is on the Benjamin Franklin Parkway. Giant screens and speakers will broadcast the concert all along the Parkway.
<h3>Viewing Tips: </h3>

Arrive early. Bring lawn chairs, a blanket and a picnic. If you get to the Parkway early, you will be able to grab a great location for viewing the concert and the fireworks.

<h3>Concert Details & Performers </h3>

Concert begins at 8:30 p.m., July 4, 2010

The Goo Goo Dolls will headline this year&acute;s concert, which features performances by Philly favorites: The Roots, R&B singer Chrisette Michelle and Washington D.C.&acute;s Chuck Brown.
July 4th Parade in Historic Philadelphia, 11:00 a.m., July 4, 2010

This year, Philadelphia&acute;s main parade fittingly takes place in Historic Philadelphia. Do not miss it!
Party on the Parkway Festival, 1:00 – 7:00 p.m., July 4, 2010

Bring your appetite and your red, white and blue apparel as an exciting, family-friendly festival stretches along Benjamin Franklin Parkway from The Franklin to the steps of the Philadelphia Museum of Art.

<h3>Insider Tip </h3>

Bring lawn chairs, a blanket and a picnic while you watch the parade. Then stay for the concert and fireworks. If you arrive early, you&acute;ll be able to grab a great location for viewing all three.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('Fireworks')
					);
////post end///
/// Festival ////post start 3//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival6.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival10.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '121 N. Columbus Boulevard The Great Plaza at Penn&acute;s Landing, Philadelphia, PA 19106',
					"geo_latitude"	=> '39.9464558',
					"geo_longitude"	=> '-75.1414196',
					"timing"		=> 'August 22, 2010; 2-8 p.m.',
						"contact"		=> '(000) 111-2222',
					"email"			=> 'info@pennslandingcorp.com',
						"website"		=> 'http://www.pennslandingcorp.com/',
					"twitter"		=> 'http://twitter.com/pennslandingcorp',
					"facebook"		=> 'http://facebook.com/pennslandingcorp',
					"is_featured"	=> '1',
					"st_date"	=> '2010-10-25',
					"st_time"	=> '12:00 PM',
					"end_date"	=> '2010-10-27',
					"end_time"	=> '6:00 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$70',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '4',
				);
$post_info[] = array(
					"post_title"	=>	'Caribbean Festival',
					"post_content"	=>	'
<h3>The Experience</h3>

Travel to the Islands without leaving Philadelphia for the 25th annual Caribbean Festival at Penn&acute;s Landing Great Plaza. This free festival of Caribbean traditions, music and food is a culturally rich celebration of 14 Caribbean Islands featuring a collage of sights, sounds, aromas and tastes.

With entertainment as the focal point of the event, you&acute;ll be surrounded by the authentic island sounds of reggae, soca/calypso, hip-hop and gospel. There will also be creative dances, ethnic poetry and educational activities.

Fragrant aromas will fill the Great Plaza as the vendors prepare a variety of tempting island cuisine for visitors to enjoy. At the Caribbean marketplace, visitors can browse displays of island fashions, souvenirs and arts and crafts.

In addition, the Caribbean Culture booth will complement this year&acute;s event with featured topics about Caribbean history, fashion and religion. For the youngest attendees, the Festival offers a Caribbean Children&acute;s Village to teach children about the African-Caribbean culture awareness.
Additional Information

Admission is free for all PECO Multicultural Series events. PECO presents a series of free Multicultural festivals throughout the summer season at the Great Plaza at Penn&acute;s Landing.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('Fireworks')
					);
////post end///
/// Festival ////post start 3//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival11.jpg";
$image_array[] = "dummy/festival6.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '121 N. Columbus Boulevard The Great Plaza at Penn&acute;s Landing, Philadelphia, PA 19106',
					"geo_latitude"	=> '39.9464558',
					"geo_longitude"	=> '-75.1414196',
					"timing"		=> 'August 22, 2010; 2-8 p.m.',
					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@pennslandingcorp.com',
					"website"		=> 'http://www.pennslandingcorp.com/',
					"twitter"		=> 'http://twitter.com/pennslandingcorp',
					"facebook"		=> 'http://facebook.com/pennslandingcorp',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '4',
					"is_featured"	=> '1',
					"st_date"	=> '2010-9-5',
					"st_time"	=> '8:00 AM',
					"end_date"	=> '2010-9-6',
					"end_time"	=> '9:00 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$120',
				);
$post_info[] = array(
					"post_title"	=>	'Caribbean New',
					"post_content"	=>	'
<h3>The Experience</h3>

Travel to the Islands without leaving Philadelphia for the 25th annual Caribbean Festival at Penn&acute;s Landing Great Plaza. This free festival of Caribbean traditions, music and food is a culturally rich celebration of 14 Caribbean Islands featuring a collage of sights, sounds, aromas and tastes.

With entertainment as the focal point of the event, you&acute;ll be surrounded by the authentic island sounds of reggae, soca/calypso, hip-hop and gospel. There will also be creative dances, ethnic poetry and educational activities.

Fragrant aromas will fill the Great Plaza as the vendors prepare a variety of tempting island cuisine for visitors to enjoy. At the Caribbean marketplace, visitors can browse displays of island fashions, souvenirs and arts and crafts.

In addition, the Caribbean Culture booth will complement this year&acute;s event with featured topics about Caribbean history, fashion and religion. For the youngest attendees, the Festival offers a Caribbean Children&acute;s Village to teach children about the African-Caribbean culture awareness.
Additional Information

Admission is free for all PECO Multicultural Series events. PECO presents a series of free Multicultural festivals throughout the summer season at the Great Plaza at Penn&acute;s Landing.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('')
					);
////post end///
/// Festival ////post start 3//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival12.jpg";
$image_array[] = "dummy/festival13.jpg";
$image_array[] = "dummy/festival14.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '114 W. State Street Kennett Square, PA 19348',
					"geo_latitude"	=> '39.8466433',
					"geo_longitude"	=> '-75.7119121',
 					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@pennslandingcorp.com',
					"website"		=> 'http://www.pennslandingcorp.com/',
					"twitter"		=> 'http://twitter.com/pennslandingcorp',
					"facebook"		=> 'http://facebook.com/pennslandingcorp',
 					"st_date"	=> '2010-10-5',
					"st_time"	=> '10:00 AM',
					"end_date"	=> '2010-10-7',
					"end_time"	=> '12:00 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$110',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '3',
				);
$post_info[] = array(
					"post_title"	=>	'Kennett Square Mushroom Festival',
					"post_content"	=>	'
<h3>The Experience</h3>

Travel to the Islands without leaving Philadelphia for the 25th annual Caribbean Festival at Penn&acute;s Landing Great Plaza. This free festival of Caribbean traditions, music and food is a culturally rich celebration of 14 Caribbean Islands featuring a collage of sights, sounds, aromas and tastes.

With entertainment as the focal point of the event, you&acute;ll be surrounded by the authentic island sounds of reggae, soca/calypso, hip-hop and gospel. There will also be creative dances, ethnic poetry and educational activities.

Fragrant aromas will fill the Great Plaza as the vendors prepare a variety of tempting island cuisine for visitors to enjoy. At the Caribbean marketplace, visitors can browse displays of island fashions, souvenirs and arts and crafts.

In addition, the Caribbean Culture booth will complement this year&acute;s event with featured topics about Caribbean history, fashion and religion. For the youngest attendees, the Festival offers a Caribbean Children&acute;s Village to teach children about the African-Caribbean culture awareness.
Additional Information

Admission is free for all PECO Multicultural Series events. PECO presents a series of free Multicultural festivals throughout the summer season at the Great Plaza at Penn&acute;s Landing.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('Mushroom')
					);
////post end///
/// Festival ////post start 4//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival15.jpg";
$image_array[] = "dummy/festival13.jpg";
$image_array[] = "dummy/festival14.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '12th and Arch Streets Reading Terminal Market Philadelphia, PA 19107',
					"geo_latitude"	=> '39.953109',
					"geo_longitude"	=> '-75.159589',
 					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@readingterminalmarket.com',
					"website"		=> 'http://www.readingterminalmarket.org/',
					"twitter"		=> 'http://twitter.com/readingterminalmarket',
					"facebook"		=> 'http://facebook.com/readingterminalmarket',
					"st_date"	=> '2010-10-7',
					"st_time"	=> '10:30 AM',
					"end_date"	=> '2010-10-12',
					"end_time"	=> '12:30 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$110',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '3',
				);
$post_info[] = array(
					"post_title"	=>	'Reading Terminal Market&acute;s Pennsylvania Dutch Festival',
					"post_content"	=>	'
Celebrate the traditions, foods and crafts of the Pennsylvania Dutch at the 21st annual Pennsylvania Dutch Festival at the historic Reading Terminal Market.

The three-day festival will take place in the Market&acute;s center court seating area and will feature handmade crafts including quilts, woodcrafts, paintings, hand braided rugs, wooden toys and cedar chests.

Traditional foods including chicken pot pie, donuts, ice cream, pies and canned fruits and vegetables will be available to taste and purchase.

On Saturday, August 13, the festival moves outdoors to create a country fair in the city. The 1100 block of Arch Street will be closed to traffic and a petting zoo with sheep, goats, chickens, donkeys, calves, horses and pigs will fill the street.

Amish buggy rides and horse drawn wagon rides around the Market, as well as country and bluegrass bands, round out the entertainment for this great, family-friendly event.

',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('Dutch')
					);
////post end///
/// Festival ////post start 4//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival16.jpg";
$image_array[] = "dummy/festival13.jpg";
$image_array[] = "dummy/festival14.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '40 N. 2nd Street The Arden Theatre Company Philadelphia, PA 19106',
					"geo_latitude"	=> '39.9493624',
					"geo_longitude"	=> '-75.1457327',
 					"contact"		=> '(000) 111-2222',
					"email"			=> 'info@pgltf.com',
					"website"		=> 'http://www.pgltf.org/',
					"twitter"		=> 'http://twitter.com/pgltf',
					"facebook"		=> 'http://facebook.com/pgltf',
					"st_date"	=> '2010-10-11',
					"st_time"	=> '11:30 AM',
					"end_date"	=> '2010-10-12',
					"end_time"	=> '3:00 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$90',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '3',
				);
$post_info[] = array(
					"post_title"	=>	'Philadelphia Gay and Lesbian Theatre Festival',
					"post_content"	=>	'
The Philadelphia Gay and Lesbian Theatre Festival has been canceled for 2010.

The Seventh Annual Philadelphia Gay and Lesbian Theatre Festival (PGLTF) begins its loud and proud two-week run on June 11, 2009. Several theater productions celebrate the gay, lesbian, bisexual and transgender experience through the art of theater.

The festival typically included both local and international premieres of critically acclaimed dramas, comedies, musicals and one-person shows. All productions aim to entertain, educate, empower, enlighten, challenge and delight audiences.

Topics of previous productions included a musical review of favorite Broadway tunes coming to life with a decidedly gay perspective; dealing with one inner burdens while on a pilgrimage to India; turning the damages of sexual abuse to that which gives rise to transformation; intertwined lives of gay men and the women who love them; delving into whether Shakespeare was bi-sexual and if the subject of his love sonnets was a young boy; as well as two productions specifically presented as a part of our Young Audience Presentations.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('Market')
					);
////post end///
/// Festival ////post start 5//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival17.jpg";
$image_array[] = "dummy/festival13.jpg";
$image_array[] = "dummy/festival14.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> 'Walnut Street and Columbus Boulevard, Philadelphia, PA 19106',
					"geo_latitude"	=> '39.945345',
					"geo_longitude"	=> '-75.141415',
					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@welcomeamerica.com',
					"website"		=> 'http://www.welcomeamerica.com/',
					"twitter"		=> 'http://twitter.com/welcomeamerica',
					"facebook"		=> 'http://facebook.com/welcomeamerica',
					"st_date"	=> '2010-10-4',
					"st_time"	=> '10:15 AM',
					"end_date"	=> '2010-10-6',
					"end_time"	=> '12:15 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$105',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '3',
				);
$post_info[] = array(
					"post_title"	=>	'Super Scooper All-You-Can-Eat Ice Cream Festival',
					"post_content"	=>	'
<h3>The Experience</h3>

What better way to raise money for children with leukemia than to eat your favorite kind of ice cream?

At Wawa Welcome America!‘s annual Super Scooper All-You-Can-Eat Ice Cream Festival, you can do just that - as well as enjoy free music, live entertainment and games for the whole family!

At this annual celebration of sweetness, more than 20 ice cream and water ice companies will serve up their cool, creamy treats. After paying the $5 admission, ice cream lovers are given a spoon and unlimited access to their favorites. Clearly, this is no time to count calories.

All proceeds from the event will benefit the Joshua Kahan Fund and the fight to cure pediatric leukemia.
<h3>Additional Information </h3>

  
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('')
					);
////post end///
/// Festival ////post start 5//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival18.jpg";
$image_array[] = "dummy/festival19.jpg";
$image_array[] = "dummy/festival20.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> 'Columbus Boulevard at Spring Garden Street, Festival Pier at Penn&acute;s Landing, Philadelphia, PA 19123',
					"geo_latitude"	=> '39.9644549',
					"geo_longitude"	=> '-75.1457893',
 					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@okayplayer.com',
					"website"		=> 'http://www.okayplayer.com/rootspicnic/',
					"twitter"		=> 'http://twitter.com/okayplayer',
					"facebook"		=> 'http://facebook.com/okayplayer',
					"st_date"	=> '2010-10-7',
					"st_time"	=> '10:10 AM',
					"end_date"	=> '2010-10-9',
					"end_time"	=> '12:10 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$110',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '3',
				);
$post_info[] = array(
					"post_title"	=>	'The Roots Picnic',
					"post_content"	=>	'
<h3>Location </h3>

Festival Pier at Penn&acute;s Landing
Columbus Boulevard at Spring Garden Street
<h3>The Festival </h3>

The Roots - the Philly natives also known as the Legendary Roots Crew - have gathered a diverse lineup of talent for this third annual music festival, including: Vampire Weekend, Mayer Hawthorne, The Very Best, Clipse, Nneka, Jay Electronica, Tune-Yards, Das Racist and more - including a performance by Wu-Tang members Raekwon, Method Man and Ghostface.

Of course, The Roots couldn&acute;t just throw a music festival with their favorite acts and not grace the stage. The hometown heroes will be performing two sets of their unique, high-energy live sound.

Live music will be playing from two stages during this all-day event.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('Picnic')
					);
////post end///
/// Festival ////post start 6//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival21.jpg";
$image_array[] = "dummy/festival19.jpg";
$image_array[] = "dummy/festival20.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '4601 N. 18th Street Philadelphia, PA 19140',
					"geo_latitude"	=> '40.023817',
					"geo_longitude"	=> '-75.1545658',
 					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@revolutionarygermantown.com',
					"website"		=> 'http://www.revolutionarygermantown.org/',
					"twitter"		=> 'http://twitter.com/revolutionarygermantown',
					"facebook"		=> 'http://facebook.com/revolutionarygermantown',
					"st_date"	=> '2010-10-9',
					"st_time"	=> '10:00 AM',
					"end_date"	=> '2010-10-11',
					"end_time"	=> '12:00 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$110',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '3',
				);
$post_info[] = array(
					"post_title"	=>	'Revolutionary Germantown Festival',
					"post_content"	=>	'
You are never far from history when in Germantown, one of Philadelphia&acute;s most historic neighborhoods. However, it is on full display during the Revolutionary Germantown Festival, a day-long festival that celebrates the rich history of Germantown and features the annual reenactment of the Battle of Germantown, the only military battle ever fought within the borders of Philadelphia.

Escorted bus and walking tours make getting around simple while special programs at ten historic sites throughout the community provide something for every size and taste.

Learn the inside stories of some of Philadelphia&acute;s most important colonial landmarks: put your hand to colonial paper-making techniques at Historic Rittenhouse Town; try out some early American toys at Upsala; and “meet” British General Howe at the Deshler-Morris House, his one-time war headquarters. The historic re-enactment of the 1777 Battle of Germantown takes place at Cliveden.

In addition to Rittenhouse Town, Upsala, the Deschler-Morris House and Clivedon, you&acute;ll visit the Concord School and Upper Burying Ground, where solider and officers are buried; Grumblethorpe, site of one of the battles legendary death scenes; the Johnson House, which showcase the role of African-Americans in the Revolutionary War; and two of the cities most famous colonial houses, Stenton and Wyck.
<h3>Come Prepared </h3>

There is fee for entry and parking may be limited. It is recommended that visitors consider taking public transportation to Germantown Avenue for the festivities.
<h3>Don&acute;t Miss </h3>

The battle reenactments at Cliveden are absolute must-sees.
<h3>Outsider&acute;s Tip</h3>

Make the most of Revolutionary Germantown Festival by purchasing a Passport that covers the cost of admission to all participating sites for the day. The Passport contains a list of the timed events throughout the day along with a map for self guided walking tours of the Germantown area. Passports can be pre-ordered or purchased the day of the event. An individual pass is $15 and the family pass is $25.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('Market')
					);
////post end///
/// Festival ////post start 7//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival22.jpg";
$image_array[] = "dummy/festival19.jpg";
$image_array[] = "dummy/festival20.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> '41 Peddler Village Road Peddler Village, Lahaska, PA 18931',
					"geo_latitude"	=> '40.3467149',
					"geo_longitude"	=> '-75.0351143',
 					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@peddlersvillage.com',
					"website"		=> 'http://www.peddlersvillage.com/',
					"twitter"		=> 'http://twitter.com/peddlersvillage',
					"facebook"		=> 'http://facebook.com/peddlersvillage',
					"st_date"	=> '2010-10-2',
					"st_time"	=> '9:00 AM',
					"end_date"	=> '2010-10-4',
					"end_time"	=> '4:00 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$111',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '3',
				);
$post_info[] = array(
					"post_title"	=>	'Strawberry Festival at Peddler Village',
					"post_content"	=>	'
<h3>The Experience </h3>

Celebrate spring at Peddler&acute;s Village&acute;s celebrated Strawberry Festival, where festive foods, children&acute;s activities, pie-eating contests and a lively lineup of family entertainment are just some of the weekend&acute;s exciting attractions.

Culinary highlights include strawberries served fresh and unadorned, dipped in chocolate and deep-fried in fritters or simply in shortcake, assorted pastries and fruit smoothies. More than 30 craftspeople will exhibit and sell their original handcrafted works.

Artisans show their wares and demonstrate their skills at the Street Road Green Artisan Area, while live entertainment and pie-eating contests add to the festivities of this traditional Spring celebration.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('')
					);
////post end///
/// Festival ////post start 8//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival23.jpg";
$image_array[] = "dummy/festival24.jpg";
$image_array[] = "dummy/festival25.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> 'Great Plaza at Penn Landing Columbus Boulevard and Chestnut Street Philadelphia, PA 19106',
					"geo_latitude"	=> '39.9488133',
					"geo_longitude"	=> '-75.1471936',
 					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@welcomeamerica.com',
					"website"		=> 'http://www.welcomeamerica.com/',
					"twitter"		=> 'http://twitter.com/welcomeamerica',
					"facebook"		=> 'http://facebook.com/welcomeamerica',
					"st_date"	=> '2010-10-15',
					"st_time"	=> '10:00 AM',
					"end_date"	=> '2010-10-17',
					"end_time"	=> '12:00 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$112',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '3',
				);
$post_info[] = array(
					"post_title"	=>	'Taste of Philadelphia',
					"post_content"	=>	'
A favorite of foodies, Taste of Philadelphia - the official kick-off to Wawa Welcome America! - returns for the fifth year, with more restaurants than ever joining the gastronomical festivities. Some of the city&acute;s most popular eateries serve up their specialties, and entertainment by Morris Day and the Time & to the festive atmosphere.

Admission to Penn&acute;s Landing is free and the “tastes” from participating restaurants are just a few dollars - a fraction of regular entrée-sized prices.
Dates & Times

Friday, June 25
5 p.m.

Interested in sampling cuisine from the region&acute;s best chefs? Check out the opening of three days of Taste of Philadelphia. Come and try amazing dishes from some of the most popular restaurants in the city and find new favorite menu items! Stroll the waterfront while you&acute;re “dining” and listen to local musical performers.

Saturday, June 26
11 a.m.

Taste of Philadelphia continues with its first full day of music, food and fun! Sample some of the best cuisine in the city. There&acute;s music all day to enjoy and help you keep your appetite up. Stay for the evening concert (8 p.m.)starring Morris Day & The Time, followed by the first of three fireworks displays during Wawa Welcome America!.

Sunday, June 27
11 a.m.

Don&acute;t miss the final day to sample delicious bites from Philadelphia&acute;s many restaurants. There&acute;s more music and fun to be had, so bring your family and friends!
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('Taste')
					);
////post end///
/// Festival ////post start 9//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival26.jpg";
$image_array[] = "dummy/festival24.jpg";
$image_array[] = "dummy/festival25.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> 'Market Street and W. Delaware Avenue, Market Square Memorial Park (Site of the largest festival), Marcus Hook, PA 19061',
					"geo_latitude"	=> '39.8192734',
					"geo_longitude"	=> '-75.4185221',
 					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@riverfrontramble.com',
					"website"		=> 'http://www.riverfrontramble.org/',
					"twitter"		=> 'http://twitter.com/riverfrontramble',
					"facebook"		=> 'http://facebook.com/riverfrontramble',
					"st_date"	=> '2010-10-13',
					"st_time"	=> '10:00 AM',
					"end_date"	=> '2010-10-15',
					"end_time"	=> '12:00 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$112',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '3',
				);
$post_info[] = array(
					"post_title"	=>	'Riverfront Ramble',
					"post_content"	=>	'
<h3>The Experience </h3>

The Riverfront Ramble, a massive, 14-mile-long party and festival celebrating Delaware County&acute;s waterfront communities, caps off your summer with a day of fun.

Towns from Marcus Hook to Tinicum Township roll out the welcome mat for visitors with a September festival of food, crafts, music, boats, contests, fireworks and much more.

Nibbling is easy along the entire river route, but it&acute;s in Marcus Hook&acute;s Market Square Memorial Park where more than 20 restaurants and caterers put on a serious festival of food.

There will be free concerts, hot air balloon rides, craft shows, boating and family-friendly activities to enjoy all weekend long. Don&acute;t miss it!

Enjoy a family day on the Delaware River that mingles old memories with beautiful new recreational areas. Boating is encouraged, whether it&acute;s under sail, paddle or motor. Boat shows, tall ships, car shows and sports clinics are included, as is a wildlife tour at the John Heinz Wildlife Refuge in Tinicum Township - fun for birdwatchers, butterfly watchers, or anyone with a camera.

Through it all, you can witness the changing face of Brandywine&acute;s waterfront, a region rich in history and brimming with the development of beautiful new parks. The 14-mile trail will be included in the coastal zone bike trail, which will allow bikers to pedal the entire eastern coastline.
Come Prepared

Bring a sweater, blanket or beach chair for concerts and fireworks, which are spread out over three towns. There will be food and beverage vendors at all locations.
<h3>Don&acute;t Miss </h3>

Three riverfront fireworks displays at 8:45, for a full, 14-mile display
<h3>Outsider  Tip</h3>

The Ramble is capped off each year with a string of evening concerts from three separate locations along the river, Barry Bridge Park in Chester, Market Square Memorial Park in Marcus Hook and Governor Printz Park in Tinicum. The concerts are followed by dazzling fireworks displays launched from all three locations!
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('')
					);
////post end///
/// Festival ////post start 10//
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/festival27.jpg";
$image_array[] = "dummy/festival24.jpg";
$image_array[] = "dummy/festival25.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival5.jpg";
$image_array[] = "dummy/festival7.jpg";
$image_array[] = "dummy/festival8.jpg";
$image_array[] = "dummy/festival9.jpg";
$image_array[] = "dummy/festival1.jpg";
$image_array[] = "dummy/festival2.jpg";
$post_meta = array(
				   "video"			=> '',
				    "address"		=> 'Market Street and W. Delaware Avenue, Market Square Memorial Park (Site of the largest festival), Marcus Hook, PA 19061',
					"geo_latitude"	=> '39.8192734',
					"geo_longitude"	=> '-75.4185221',
					"contact"		=> '(215) 922-2386 ',
					"email"			=> 'info@folkfest.com',
					"website"		=> 'http://www.folkfest.org/',
					"twitter"		=> 'http://twitter.com/folkfest',
					"facebook"		=> 'http://facebook.com/folkfest',
					"st_date"	=> '2010-10-18',
					"st_time"	=> '10:00 AM',
					"end_date"	=> '2010-10-19',
					"end_time"	=> '12:50 PM',
					"reg_desc"	=> '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>',
					"reg_fees"	=> '$119',
					"tl_dummy_content"	=> '1',
					"post_city_id"	=> '1',
"package_pid"	=> '3',
				);
$post_info[] = array(
					"post_title"	=>	'Philadelphia Folk Festival',
					"post_content"	=>	'
The hills of Schwenksville, Pennsylvania come alive every summer when music legends like Arlo Guthrie, Pete Seeger and Richie Havens share the sunlight at this festival of folk music and dance in the green valley of Schwenksville&acute;s Old Poole Farm.

This year&acute;s 48th annual festival features such notable acts as Adrien Reju, the Del McCoury Band and Iron and Wine, among others. All told, the festival features more than 75 hours of great folk music and more than 60 talented musicians.

Join thousands of people sprawled out on the hillside as you sing along, clap or just enjoy the music that fills the pastoral landscape. Five stages operate simultaneously, and daytime showcase concerts feature an array of exciting new performers.

Music is everywhere - from late-night singalongs, to bonfires in the festival campgrounds, to parking lot pickers having their own impromptu jam sessions. Don&acute;t miss it!
<h3> History </h3>

The festival, which is produced and run by volunteers and sponsored by the non-profit Philadelphia Folksong Society, has been bringing world-class folk music to the area for nearly 50 years, and many music fans plan their vacations around the event.

The Philadelphia Folksong Society, the premiere folk organization in the greater Philadelphia region, is known nationally and internationally for producing the famous festival. It offers a wealth of member benefits, including Free House Concerts and Workshops and Sings as well as discounts to many other events.
<h3>COME PREPARED </h3>

Tickets range in price according to length of stay at the event, and you get a discount if you buy them in advance.
<h3>DON&acute;t MISS </h3>

A mind-boggling craft show, which offer demonstrations as well as merchandise. And if you&acute;re up for a fun weekend of camping, check out the special free concert in the campground Thursday night, which is only open to Festival Camping ticket holders.
Outsider Tip

Prominent artists like Bob Dylan, Tommy Smothers and Bonnie Raitt have shown up unannounced at the festival so look out for familiar stars. 
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Events'),
					"post_tags"		=>	array('')
					);
////post end///
insert_taxonomy_posts($post_info);
function insert_taxonomy_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='event' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = 'event';
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $post_info_arr['post_category'];
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			wp_set_object_terms($last_postid, $post_info_arr['post_tags'], $taxonomy='event_tags');
			wp_set_object_terms($last_postid,$post_info_arr['post_category'], $taxonomy='eventcategory');
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'inherit';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}
//====================================================================================//
//====================================================EVENTS END======================================================================================================
///////////////////////////////////////////////////////////////////////////////////
//====================================================================================//
/*echo "<pre>";
print_r(get_option('sidebars_widgets'));
print_r(get_option('widget_widget_subscribewidget'));
exit;*/
$googlemmap = array();
$googlemmap[1] = array(
					"title"			=>	'',
					);
$googlemmap['_multiwidget'] = '1';
update_option('widget_googlemmapwidget',$googlemmap);
$googlemmap = get_option('widget_googlemmapwidget');
krsort($googlemmap);
foreach($googlemmap as $key1=>$val1)
{
	$googlemmap_key = $key1;
	if(is_int($googlemmap_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-1"] = array("googlemmapwidget-$googlemmap_key");
$categorylist = array();
$category = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like 'Attractions'");
$categorylist[1] = array(
					"title"			=>	'Attractions',
					"category"		=>	$category,
					"post_number"	=>	'5',
					"character_cout"=>	'10',
					);
$categorylist['_multiwidget'] = '1';
update_option('widget_categorylist',$categorylist);
$categorylist = get_option('widget_categorylist');
krsort($categorylist);
foreach($categorylist as $key1=>$val1)
{
	$categorylist_key = $key1;
	if(is_int($categorylist_key))
	{
		break;
	}
}
$categorylist2 = array();
$category = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like 'Restaurants'");
$categorylist2 = get_option('widget_categorylist');
$categorylist2[2] = array(
					"title"			=>	'Restaurants',
					"category"		=>	$category,
					"post_number"	=>	'5',
					"character_cout"=>	'10',
					);
$categorylist2['_multiwidget'] = '1';
update_option('widget_categorylist',$categorylist2);
$categorylist2 = get_option('widget_categorylist');
krsort($categorylist2);
foreach($categorylist2 as $key1=>$val1)
{
	$categorylist2_key = $key1;
	if(is_int($categorylist2_key))
	{
		break;
	}
}
$news2columns = array();
$category = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like 'Hotels'");
$news2columns[1] = array(
					"title"			=>	'Hotels',
					"category"		=>	$category,
					"post_number"	=>	'5',
					"character_cout"=>	'12',
					);
$news2columns['_multiwidget'] = '1';
update_option('widget_news2columns',$news2columns);
$news2columns = get_option('widget_news2columns');
krsort($news2columns);
foreach($news2columns as $key1=>$val1)
{
	$news2columns_key = $key1;
	if(is_int($news2columns_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-2"] = array("categorylist-$categorylist_key","categorylist-$categorylist2_key","news2columns-$news2columns_key");
$advtwidget = array();
$advtwidget[1] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="#" ><img src="'.$dummy_image_path.'advt300x250px.jpg" alt="" /> </a>',
					);
$advtwidget['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget);
$advtwidget = get_option('widget_advtwidget');
krsort($advtwidget);
foreach($advtwidget as $key1=>$val1)
{
	$advtwidget_key = $key1;
	if(is_int($advtwidget_key))
	{
		break;
	}
}
$comment = array();
$comment[1] = array(
					"title"			=>	'Recent Reviews',
					"count"			=>	'3',
					);
$comment['_multiwidget'] = '1';
update_option('widget_widget_comment',$comment);
$comment = get_option('widget_widget_comment');
krsort($comment);
foreach($comment as $key1=>$val1)
{
	$comment_key = $key1;
	if(is_int($comment_key))
	{
		break;
	}
}
$werecommend = array();
$werecommend[1] = array(
					"title"			=>	'We Recommend',
					"s1"			=>	$dummy_image_path.'s1.jpg',
					"s1link"		=>	'#',
					"s2"			=>	$dummy_image_path.'s2.jpg',
					"s2link"		=>	'#',
					"s3"			=>	$dummy_image_path.'s3.jpg',
					"s3link"		=>	'#',
					"s4"			=>	$dummy_image_path.'s4.jpg',
					"s4link"		=>	'#',
					"s5"			=>	$dummy_image_path.'s5.jpg',
					"s5link"		=>	'#',
					"effect"		=>	'random',
					"slices"		=>	'15',
					"animSpeed"		=>	'700',
					"pauseTime"		=>	'3000',
					"width"			=>	'295',
					"height"		=>	'235',				
					);
$werecommend['_multiwidget'] = '1';
update_option('widget_widget_werecommend',$werecommend);
$werecommend = get_option('widget_widget_werecommend');
krsort($werecommend);
foreach($werecommend as $key1=>$val1)
{
	$werecommend_key = $key1;
	if(is_int($werecommend_key))
	{
		break;
	}
}

$spotlight_post = array();
$category = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like 'Videos'");
$spotlight_post[1] = array(
					"title"			=>	'Featured Video',
					"category"		=>	$category,
					"post_number"	=>	1
					);
$spotlight_post['_multiwidget'] = '1';
update_option('widget_spotlight_post',$spotlight_post);
$spotlight_post = get_option('widget_spotlight_post');
krsort($spotlight_post);
foreach($spotlight_post as $key1=>$val1)
{
	$spotlight_post_key = $key1;
	if(is_int($spotlight_post_key))
	{
		break;
	}
}

$sidebars_widgets["sidebar-3"] = array("advtwidget-$advtwidget_key","widget_comment-$comment_key","widget_werecommend-$werecommend_key","spotlight_post-$spotlight_post_key");
$recent_posts = array();
$recent_posts[1] = array(
					"title"			=>	'',
					"number"		=>	5,
					);
$recent_posts['_multiwidget'] = '1';
update_option('widget_recent_posts',$recent_posts);
$recent_posts = get_option('widget_recent_posts');
krsort($recent_posts);
foreach($recent_posts as $key1=>$val1)
{
	$recent_posts_key = $key1;
	if(is_int($recent_posts_key))
	{
		break;
	}
}
$categories = array();
$categories[1] = array(
					"title"		=>	'',
					"count"		=>	0,
					"hierarchical"		=>	0,
					"dropdown"		=>	0,
					);
$categories['_multiwidget'] = '1';
update_option('widget_categories',$categories);
$categories = get_option('widget_categories');
krsort($categories);
foreach($categories as $key1=>$val1)
{
	$categories_key = $key1;
	if(is_int($categories_key))
	{
		break;
	}
}
$archives = array();
$archives[1] = array(
					"title"		=>	'Archives',
					"count"		=>	0,
					"dropdown"		=>	0,
					);
$archives['_multiwidget'] = '1';
update_option('widget_archives',$archives);
$archives = get_option('widget_archives');
krsort($archives);
foreach($archives as $key1=>$val1)
{
	$archives_key = $key1;
	if(is_int($archives_key))
	{
		break;
	}
}
$twidget = array();
$twidget[1] = array(
					"title"		=>	'Twitter Updates',
					"account"		=>	'GeoTheme',
					"follow"		=>	'',
					"show"		=>	'3',
					);
$twidget['_multiwidget'] = '1';
update_option('widget_widget_twidget',$twidget);
$twidget = get_option('widget_widget_twidget');
krsort($twidget);
foreach($twidget as $key1=>$val1)
{
	$twidget_key = $key1;
	if(is_int($twidget_key))
	{
		break;
	}
}

$sidebars_widgets["sidebar-4"] = array("recent-posts-$recent_posts_key","categories-$categories_key","archives-$archives_key","widget_twidget-$twidget_key");

$advtwidget = array();
$advtwidget = get_option('widget_advtwidget');
$advtwidget[2] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="#" ><img src="'.$dummy_image_path.'advt300x250px.jpg" alt="" /> </a>',
					);
$advtwidget['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget);
$advtwidget = get_option('widget_advtwidget');
krsort($advtwidget);
foreach($advtwidget as $key1=>$val1)
{
	$advtwidget_key = $key1;
	if(is_int($advtwidget_key))
	{
		break;
	}
}

$advtwidget2 = array();
$advtwidget2 = get_option('widget_advtwidget');
$advtwidget2[3] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="#" ><img src="'.$dummy_image_path.'advt300x150px.jpg" alt="" /> </a>',
					);
$advtwidget2['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget2);
$advtwidget2 = get_option('widget_advtwidget');
krsort($advtwidget2);
foreach($advtwidget2 as $key1=>$val1)
{
	$advtwidget2_key = $key1;
	if(is_int($advtwidget2_key))
	{
		break;
	}
}
$comment = array();
$comment = get_option('widget_widget_comment');
$comment[2] = array(
					"title"			=>	'Recent Reviews',
					"count"			=>	'4',
					);
$comment['_multiwidget'] = '1';
update_option('widget_widget_comment',$comment);
$comment = get_option('widget_widget_comment');
krsort($comment);
foreach($comment as $key1=>$val1)
{
	$comment_key = $key1;
	if(is_int($comment_key))
	{
		break;
	}
}
$googlemmapwidget_sidebar = array();
$googlemmapwidget_sidebar[1] = array(
					"title"			=>	'',
					);
$googlemmapwidget_sidebar['_multiwidget'] = '1';
update_option('widget_googlemmapwidget_sidebar',$googlemmapwidget_sidebar);
$googlemmapwidget_sidebar = get_option('widget_googlemmapwidget_sidebar');
krsort($googlemmapwidget_sidebar);
foreach($googlemmapwidget_sidebar as $key1=>$val1)
{
	$googlemmapwidget_sidebar_key = $key1;
	if(is_int($googlemmapwidget_sidebar_key))
	{
		break;
	}
}

$sidebars_widgets["sidebar-5"] = array("googlemmapwidget_sidebar-$googlemmapwidget_sidebar_key","advtwidget-$advtwidget_key","widget_comment-$comment_key","advtwidget-$advtwidget2_key");
$text = array();
$text[1] = array(
					"title"			=>	'100% Satisfaction Guaranteed',
					"text"			=>	'<p> If you&acute;re not 100% satisfied with the results from your listing, request a full refund within 30 days after your listing expires. No questions asked. Promise.</p><p>See also our <a href="#"> frequently asked questions</a>.</p>',
					);
$text['_multiwidget'] = '1';
update_option('widget_text',$text);
$text = get_option('widget_text');
krsort($text);
foreach($text as $key1=>$val1)
{
	$text_key = $key1;
	if(is_int($text_key))
	{
		break;
	}
}
$text1 = array();
$text1 = get_option('widget_text');
$text1[2] = array(
					"title"			=>	'Payment Info',
					"text"			=>	'<p> $250 Full-time listing (60 days) </p><p>$75 Freelance listing (30 days) </p><p>Visa, Mastercard, American Express, and Discover cards accepted  </p><p><img src="'.$dummy_image_path.'cards.gif" alt="" /> </p><p> All major credit cards  accepted. Payments are processed by PayPal, but you do not need an account with PayPal to complete your transaction. (Contact us with any questions.) </p>',
					);
$text1['_multiwidget'] = '1';
update_option('widget_text',$text1);
$text1 = get_option('widget_text');
krsort($text1);
foreach($text1 as $key1=>$val1)
{
	$text1_key = $key1;
	if(is_int($text1_key))
	{
		break;
	}
}
$text2 = array();
$text2 = get_option('widget_text');
$text2[3] = array(
					"title"			=>	'Need Help?',
					"text"			=>	'<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. </p>',
					);
$text2['_multiwidget'] = '1';
update_option('widget_text',$text2);
$text2 = get_option('widget_text');
krsort($text2);
foreach($text2 as $key1=>$val1)
{
	$text2_key = $key1;
	if(is_int($text2_key))
	{
		break;
	}
}
$loginwidget = array();
$loginwidget[1] = array(
					"title"			=>	'Member Login',
					);
$loginwidget['_multiwidget'] = '1';
update_option('widget_widget_loginwidget',$loginwidget);
$loginwidget = get_option('widget_widget_loginwidget');
krsort($loginwidget);
foreach($loginwidget as $key1=>$val1)
{
	$loginwidget_key = $key1;
	if(is_int($loginwidget_key))
	{
		break;
	}
}

$sidebars_widgets["sidebar-6"] = array("widget_loginwidget-$loginwidget_key","text-$text_key","text-$text1_key","text-$text2_key");


$loginwidget['_multiwidget'] = '2';
update_option('widget_widget_loginwidget',$loginwidget);
$loginwidget = get_option('widget_widget_loginwidget');
krsort($loginwidget);
foreach($loginwidget as $key1=>$val1)
{
	$loginwidget_key = $key1;
	if(is_int($loginwidget_key))
	{
		break;
	}
}

$sidebars_widgets["sidebar-24"] = array("widget_loginwidget-$loginwidget_key");


$advtwidget2 = array();
$advtwidget2 = get_option('widget_advtwidget');
$advtwidget2[4] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="#" ><img src="'.$dummy_image_path.'advt468x60px.jpg" alt="" /> </a>',
					);
$advtwidget2['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget2);
$advtwidget2 = get_option('widget_advtwidget');
krsort($advtwidget2);
foreach($advtwidget2 as $key1=>$val1)
{
	$advtwidget2_key = $key1;
	if(is_int($advtwidget2_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-7"] = array("advtwidget-$advtwidget2_key");
$advtwidget2 = array();
$advtwidget2 = get_option('widget_advtwidget');
$advtwidget2[5] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="#" ><img src="'.$dummy_image_path.'advt300x150px.jpg" alt="" /> </a>',
					);
$advtwidget2['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget2);
$advtwidget2 = get_option('widget_advtwidget');
krsort($advtwidget2);
foreach($advtwidget2 as $key1=>$val1)
{
	$advtwidget2_key = $key1;
	if(is_int($advtwidget2_key))
	{
		break;
	}
}
$comment = array();
$comment = get_option('widget_widget_comment');
$comment[3] = array(
					"title"			=>	'Recent Reviews',
					"count"			=>	'4',
					);
$comment['_multiwidget'] = '1';
update_option('widget_widget_comment',$comment);
$comment = get_option('widget_widget_comment');
krsort($comment);
foreach($comment as $key1=>$val1)
{
	$comment_key = $key1;
	if(is_int($comment_key))
	{
		break;
	}
}
$googlemmapwidget_sidebar = array();
$googlemmapwidget_sidebar = get_option('widget_googlemmapwidget_sidebar');
$googlemmapwidget_sidebar[2] = array(
					"title"			=>	'',
					);
$googlemmapwidget_sidebar['_multiwidget'] = '1';
update_option('widget_googlemmapwidget_sidebar',$googlemmapwidget_sidebar);
$googlemmapwidget_sidebar = get_option('widget_googlemmapwidget_sidebar');
krsort($googlemmapwidget_sidebar);
foreach($googlemmapwidget_sidebar as $key1=>$val1)
{
	$googlemmapwidget_sidebar_key = $key1;
	if(is_int($googlemmapwidget_sidebar_key))
	{
		break;
	}
}
$neighborhood = array();
$neighborhood[1] = array(
					"title"			=>	'In the neighborhood',
					"category"			=>	'',
					"post_number"			=>	'4',
					"post_link"			=>	'',
					);
$neighborhood['_multiwidget'] = '1';
update_option('widget_neighborhood',$neighborhood);
$neighborhood = get_option('widget_neighborhood');
krsort($neighborhood);
foreach($neighborhood as $key1=>$val1)
{
	$neighborhood_key = $key1;
	if(is_int($neighborhood_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-8"] = array("googlemmapwidget_sidebar-$googlemmapwidget_sidebar_key","neighborhood-$neighborhood_key","widget_comment-$comment_key","advtwidget-$advtwidget2_key");
$advtwidget2 = array();
$advtwidget2 = get_option('widget_advtwidget');
$advtwidget2[6] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="#" ><img src="'.$dummy_image_path.'advt300x150px.jpg" alt="" /> </a>',
					);
$advtwidget2['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget2);
$advtwidget2 = get_option('widget_advtwidget');
krsort($advtwidget2);
foreach($advtwidget2 as $key1=>$val1)
{
	$advtwidget2_key = $key1;
	if(is_int($advtwidget2_key))
	{
		break;
	}
}
$categories = array();
$categories = get_option('widget_categories');
$categories[2] = array(
					"title"		=>	'',
					"count"		=>	0,
					"hierarchical"		=>	0,
					"dropdown"		=>	0,
					);
$categories['_multiwidget'] = '1';
update_option('widget_categories',$categories);
$categories = get_option('widget_categories');
krsort($categories);
foreach($categories as $key1=>$val1)
{
	$categories_key = $key1;
	if(is_int($categories_key))
	{
		break;
	}
}
$archives = array();
$archives = get_option('widget_archives');
$archives[2] = array(
					"title"		=>	'Archives',
					"count"		=>	0,
					"dropdown"		=>	0,
					);
$archives['_multiwidget'] = '1';
update_option('widget_archives',$archives);
$archives = get_option('widget_archives');
krsort($archives);
foreach($archives as $key1=>$val1)
{
	$archives_key = $key1;
	if(is_int($archives_key))
	{
		break;
	}
}
$search = array();
$search[1] = array(
					"title"		=>	'',
					);
$search['_multiwidget'] = '1';
update_option('widget_search',$search);
$search = get_option('widget_search');
krsort($search);
foreach($search as $key1=>$val1)
{
	$search_key = $key1;
	if(is_int($search_key))
	{
		break;
	}
}
$comments = array();
$comments[1] = array(
					"title"		=>	'Recent Comments',
					"number"	=>	'5',
					);
$comments['_multiwidget'] = '1';
update_option('widget_recent-comments',$comments);
$comments = get_option('widget_recent-comments');
krsort($comments);
foreach($comments as $key1=>$val1)
{
	$comments_key = $key1;
	if(is_int($comments_key))
	{
		break;
	}
}
$links = array();
$links[1] = array(
					"images"	=>	'1',
					"name"	=>	'1',
					"description"	=>	'0',
					"rating"	=>	'0',
					"category"	=>	'0',
					);
$links['_multiwidget'] = '1';
update_option('widget_links',$links);
$links = get_option('widget_links');
krsort($links);
foreach($links as $key1=>$val1)
{
	$links_key = $key1;
	if(is_int($links_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-9"] = array("search-$search_key","advtwidget-$advtwidget2_key","categories-$categories_key","archives-$archives_key","recent-comments-$comments_key","links-$links_key");
$advtwidget2 = array();
$advtwidget2 = get_option('widget_advtwidget');
$advtwidget2[7] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="#" ><img src="'.$dummy_image_path.'advt300x150px.jpg" alt="" /> </a>',
					);
$advtwidget2['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget2);
$advtwidget2 = get_option('widget_advtwidget');
krsort($advtwidget2);
foreach($advtwidget2 as $key1=>$val1)
{
	$advtwidget2_key = $key1;
	if(is_int($advtwidget2_key))
	{
		break;
	}
}
$categories = array();
$categories = get_option('widget_categories');
$categories[3] = array(
					"title"		=>	'',
					"count"		=>	0,
					"hierarchical"		=>	0,
					"dropdown"		=>	0,
					);
$categories['_multiwidget'] = '1';
update_option('widget_categories',$categories);
$categories = get_option('widget_categories');
krsort($categories);
foreach($categories as $key1=>$val1)
{
	$categories_key = $key1;
	if(is_int($categories_key))
	{
		break;
	}
}
$archives = array();
$archives = get_option('widget_archives');
$archives[3] = array(
					"title"		=>	'Archives',
					"count"		=>	0,
					"dropdown"		=>	0,
					);
$archives['_multiwidget'] = '1';
update_option('widget_archives',$archives);
$archives = get_option('widget_archives');
krsort($archives);
foreach($archives as $key1=>$val1)
{
	$archives_key = $key1;
	if(is_int($archives_key))
	{
		break;
	}
}
$search = array();
$search = get_option('widget_search');
$search[2] = array(
					"title"		=>	'',
					);
$search['_multiwidget'] = '1';
update_option('widget_search',$search);
$search = get_option('widget_search');
krsort($search);
foreach($search as $key1=>$val1)
{
	$search_key = $key1;
	if(is_int($search_key))
	{
		break;
	}
}
$comments = array();
$comments = get_option('widget_recent-comments');
$comments[2] = array(
					"title"		=>	'Recent Comments',
					"number"	=>	'5',
					);
$comments['_multiwidget'] = '1';
update_option('widget_recent-comments',$comments);
$comments = get_option('widget_recent-comments');
krsort($comments);
foreach($comments as $key1=>$val1)
{
	$comments_key = $key1;
	if(is_int($comments_key))
	{
		break;
	}
}
$links = array();
$links = get_option('widget_links');
$links[2] = array(
					"images"	=>	'1',
					"name"	=>	'1',
					"description"	=>	'0',
					"rating"	=>	'0',
					"category"	=>	'0',
					);
$links['_multiwidget'] = '1';
update_option('widget_links',$links);
$links = get_option('widget_links');
krsort($links);
foreach($links as $key1=>$val1)
{
	$links_key = $key1;
	if(is_int($links_key))
	{
		break;
	}
}

$sidebars_widgets["sidebar-10"] = array("search-$search_key","advtwidget-$advtwidget2_key","categories-$categories_key","archives-$archives_key","recent-comments-$comments_key","links-$links_key");
$advtwidget2 = array();
$advtwidget2 = get_option('widget_advtwidget');
$advtwidget2[8] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="#" ><img src="'.$dummy_image_path.'advt468x60px.jpg" alt="" /> </a>',
					);
$advtwidget2['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget2);
$advtwidget2 = get_option('widget_advtwidget');
krsort($advtwidget2);
foreach($advtwidget2 as $key1=>$val1)
{
	$advtwidget2_key = $key1;
	if(is_int($advtwidget2_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-11"] = array("advtwidget-$advtwidget2_key");










$advtwidget = array();
$advtwidget = get_option('widget_advtwidget');
$advtwidget[9] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="#" ><img src="'.$dummy_image_path.'advt300x250px.jpg" alt="" /> </a>',
					);
$advtwidget['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget);
$advtwidget = get_option('widget_advtwidget');
krsort($advtwidget);
foreach($advtwidget as $key1=>$val1)
{
	$advtwidget_key = $key1;
	if(is_int($advtwidget_key))
	{
		break;
	}
}

$advtwidget2 = array();
$advtwidget2 = get_option('widget_advtwidget');
$advtwidget2[10] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="#" ><img src="'.$dummy_image_path.'advt300x150px.jpg" alt="" /> </a>',
					);
$advtwidget2['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget2);
$advtwidget2 = get_option('widget_advtwidget');
krsort($advtwidget2);
foreach($advtwidget2 as $key1=>$val1)
{
	$advtwidget2_key = $key1;
	if(is_int($advtwidget2_key))
	{
		break;
	}
}
$comment = array();
$comment = get_option('widget_widget_comment');
$comment[4] = array(
					"title"			=>	'Recent Reviews',
					"count"			=>	'4',
					);
$comment['_multiwidget'] = '1';
update_option('widget_widget_comment',$comment);
$comment = get_option('widget_widget_comment');
krsort($comment);
foreach($comment as $key1=>$val1)
{
	$comment_key = $key1;
	if(is_int($comment_key))
	{
		break;
	}
}
$googlemmapwidget_sidebar = array();
$googlemmapwidget_sidebar[3] = array(
					"title"			=>	'',
					);
$googlemmapwidget_sidebar['_multiwidget'] = '1';
update_option('widget_googlemmapwidget_sidebar',$googlemmapwidget_sidebar);
$googlemmapwidget_sidebar = get_option('widget_googlemmapwidget_sidebar');
krsort($googlemmapwidget_sidebar);
foreach($googlemmapwidget_sidebar as $key1=>$val1)
{
	$googlemmapwidget_sidebar_key = $key1;
	if(is_int($googlemmapwidget_sidebar_key))
	{
		break;
	}
}

$sidebars_widgets["sidebar-12"] = array("googlemmapwidget_sidebar-$googlemmapwidget_sidebar_key","advtwidget-$advtwidget_key","widget_comment-$comment_key","advtwidget-$advtwidget2_key");
$advtwidget2 = array();
$advtwidget2 = get_option('widget_advtwidget');
$advtwidget2[11] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="#" ><img src="'.$dummy_image_path.'advt300x150px.jpg" alt="" /> </a>',
					);
$advtwidget2['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget2);
$advtwidget2 = get_option('widget_advtwidget');
krsort($advtwidget2);
foreach($advtwidget2 as $key1=>$val1)
{
	$advtwidget2_key = $key1;
	if(is_int($advtwidget2_key))
	{
		break;
	}
}
$comment = array();
$comment = get_option('widget_widget_comment');
$comment[5] = array(
					"title"			=>	'Recent Reviews',
					"count"			=>	'4',
					);
$comment['_multiwidget'] = '1';
update_option('widget_widget_comment',$comment);
$comment = get_option('widget_widget_comment');
krsort($comment);
foreach($comment as $key1=>$val1)
{
	$comment_key = $key1;
	if(is_int($comment_key))
	{
		break;
	}
}
$googlemmapwidget_sidebar = array();
$googlemmapwidget_sidebar = get_option('widget_googlemmapwidget_sidebar');
$googlemmapwidget_sidebar[4] = array(
					"title"			=>	'',
					);
$googlemmapwidget_sidebar['_multiwidget'] = '1';
update_option('widget_googlemmapwidget_sidebar',$googlemmapwidget_sidebar);
$googlemmapwidget_sidebar = get_option('widget_googlemmapwidget_sidebar');
krsort($googlemmapwidget_sidebar);
foreach($googlemmapwidget_sidebar as $key1=>$val1)
{
	$googlemmapwidget_sidebar_key = $key1;
	if(is_int($googlemmapwidget_sidebar_key))
	{
		break;
	}
}
$neighborhood = array();
$neighborhood[1] = array(
					"title"			=>	'In the neighborhood',
					"category"			=>	'',
					"post_number"			=>	'4',
					"post_link"			=>	'',
					);
$neighborhood['_multiwidget'] = '1';
update_option('widget_neighborhood',$neighborhood);
$neighborhood = get_option('widget_neighborhood');
krsort($neighborhood);
foreach($neighborhood as $key1=>$val1)
{
	$neighborhood_key = $key1;
	if(is_int($neighborhood_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-13"] = array("googlemmapwidget_sidebar-$googlemmapwidget_sidebar_key","neighborhood-$neighborhood_key","widget_comment-$comment_key","advtwidget-$advtwidget2_key");
$advtwidget2 = array();
$advtwidget2 = get_option('widget_advtwidget');
$advtwidget2[12] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="#" ><img src="'.$dummy_image_path.'advt468x60px.jpg" alt="" /> </a>',
					);
$advtwidget2['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget2);
$advtwidget2 = get_option('widget_advtwidget');
krsort($advtwidget2);
foreach($advtwidget2 as $key1=>$val1)
{
	$advtwidget2_key = $key1;
	if(is_int($advtwidget2_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-14"] = array("advtwidget-$advtwidget2_key");
//footer
$text2 = array();
$text2 = get_option('widget_text');
$text2[4] = array(
					"title"			=>	'About Geo Theme',
					"text"			=>	'<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam.  aliquam,  justo convallis luctus rutrum  justo convallis</p>',
					);
$text2['_multiwidget'] = '1';
update_option('widget_text',$text2);
$text2 = get_option('widget_text');
krsort($text2);
foreach($text2 as $key1=>$val1)
{
	$text2_key = $key1;
	if(is_int($text2_key))
	{
		break;
	}
}

$sidebars_widgets["sidebar-15"] = array("text-$text2_key");
$eventwidget = array();
$category = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like 'Blog'");
$eventwidget[1] = array(
					"title"			=>	' Latest News',
					"category"		=>	$category,
					"post_number"	=>	'3',
					"post_link"	 =>	'',
					);

$eventwidget['_multiwidget'] = '1';
update_option('widget_eventwidget',$eventwidget);
$eventwidget = get_option('widget_eventwidget');
krsort($eventwidget);
foreach($eventwidget as $key1=>$val1)
{
	$eventwidget_key = $key1;
	if(is_int($eventwidget_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-16"] = array("eventwidget-$eventwidget_key");
$tag_cloud = array();
$tag_cloud[1] = array(
					"title"			=>	'Tag Cloud',
					"taxonomy"		=>	'category',
					);
$tag_cloud['_multiwidget'] = '1';
update_option('widget_tag_cloud',$tag_cloud);
$tag_cloud = get_option('widget_tag_cloud');
krsort($tag_cloud);
foreach($tag_cloud as $key1=>$val1)
{
	$tag_cloud_key = $key1;
	if(is_int($tag_cloud_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-17"] = array("tag_cloud-$tag_cloud_key");
$subscribewidget = array();
$subscribewidget[1] = array(
					"title"			=>	'Newsletter Subscribe',
					"text"			=>	'If you did like to stay updated with all our latest news please enter your e-mail address here',
					);
$subscribewidget['_multiwidget'] = '1';
update_option('widget_widget_subscribewidget',$subscribewidget);
$subscribewidget = get_option('widget_widget_subscribewidget');
krsort($subscribewidget);
foreach($subscribewidget as $key1=>$val1)
{
	$subscribewidget_key = $key1;
	if(is_int($subscribewidget_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-18"] = array("widget_subscribewidget-$subscribewidget_key");
//===============================================================================
//////////////////////////////////////////////////////
update_option('sidebars_widgets',$sidebars_widgets);  //save widget iformations
/////////////// WIDGET SETTINGS END ///////////////
//====================================================================================//
//=====================================================================
/////////////// Design Settings START ///////////////
update_option("ptthemes_alt_stylesheet",'1-default.css');
update_option("ptthemes_feedburner_url",'http://feeds2.feedburner.com/geotheme');
update_option("ptthemes_feedburner_id",'geotheme');

$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Sub Page 1' and post_type='page'");
update_option("pag_exclude_$page_id",1);
$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Sub Page 2' and post_type='page'");
update_option("pag_exclude_$page_id",1);
$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Terms' and post_type='page'");
update_option("pag_exclude_$page_id",1);
$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'FAQs' and post_type='page'");
update_option("pag_exclude_$page_id",1);

$cat_id_arr = $wpdb->get_col("SELECT term_id FROM $wpdb->terms where name in ('Attractions','Food Nightlife','Hotels','Restaurants')");
update_option("ptthemes_placecategory",$cat_id_arr);
$cat_id_arr = $wpdb->get_col("SELECT term_id FROM $wpdb->terms where name in ('Events')");
update_option("ptthemes_eventcategory",$cat_id_arr);
$blog_cat_id_arr = $wpdb->get_col("SELECT term_id FROM $wpdb->terms where name in ('Blog')");
update_option("ptthemes_blogcategory",$blog_cat_id_arr);
update_option("ptthemes_api_key",'ABQIAAAAE4DbZwlvGB0uP0Klp1-GZRRcaiTLAfEj3CvwzOs7Na3ouzBSIhTbgGaRptviXjch08i00vpvjQ9h2w');
update_option("ptthemes_latitute",'39.953438023308465');
update_option("ptthemes_longitute",'-75.14579772949219');
update_option("ptthemes_scaling_factor",'14');
update_option("ptthemes_cat_listing",'normal listing');
update_option("posts_per_page",'4');
$page_id_arr = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_title in ('Site Map','Terms','FAQs') and post_type='page'");
update_option("ptthemes_footerpages",$page_id_arr);
update_option("ptthemes_breadcrumbs",1);
update_option("ptthemes_tweet_button",1);
update_option("ptthemes_facebook_button",1);
update_option("is_user_addevent",1);
update_option("ptthemes_contact_on_detailpage",'Yes');
update_option("ptthemes_email_on_detailpage",'Yes');


update_option("ptthemes_home_name",'Home');
update_option("	",'Search');
update_option("ptthemes_pages_name",'Pages');
update_option("ptthemes_last_posts",'Last 60 Blog Posts');
update_option("ptthemes_monthly_archives",'Monthly Archives');
update_option("ptthemes_categories_name",'Categories');
update_option("ptthemes_rssfeeds_name",'Available RSS Feeds');
update_option("ptthemes_404error_name",'Error 404 | Nothing found!');
update_option("ptthemes_404solution_name",'Sorry, but you are looking for something that is not here.');
update_option("ptthemes_password_protected_name",'This post is password protected. Enter the password to view comments.');
update_option("ptthemes_comment_responsesa_name",'No Comments');
update_option("ptthemes_comment_responsesb_name",'One Comment');
update_option("ptthemes_comment_responsesc_name",'% Comments');
update_option("ptthemes_comment_trackbacks_name",'Trackbacks For This Post');
update_option("ptthemes_comment_moderation_name",'Your comment is awaiting moderation.');
update_option("ptthemes_comment_conversation_name",'Be the first to start a conversation');
update_option("ptthemes_comment_closed_name",'Comments are closed.');
update_option("ptthemes_comment_off_name",'Comments are off for this post');
update_option("ptthemes_comment_reply_name",'Leave a Reply');
update_option("ptthemes_comment_mustbe_name",'You must be');
update_option("ptthemes_comment_loggedin_name",'logged in');
update_option("ptthemes_comment_postcomment_name",'to post a comment.');
update_option("ptthemes_comment_name_name",'Name');
update_option("ptthemes_comment_mail_name",'Mail');
update_option("ptthemes_comment_website_name",'Website');
update_option("ptthemes_comment_addcomment_name",'Add Comment');
update_option("ptthemes_comment_justreply_name",'Reply');
update_option("ptthemes_comment_edit_name",'Edit');
update_option("ptthemes_comment_delete_name",'Delete');
update_option("ptthemes_comment_spam_name",'Spam');
update_option("ptthemes_pagination_first_name",'First');
update_option("ptthemes_pagination_last_name",'Last');



global $upload_folder_path;
$folderpath = $upload_folder_path . "dummy/";
full_copy( TEMPLATEPATH."/images/dummy/", ABSPATH . $folderpath );
function full_copy( $source, $target ) 
{
	global $upload_folder_path;
	$imagepatharr = explode('/',$upload_folder_path."dummy");
	$year_path = ABSPATH;
	for($i=0;$i<count($imagepatharr);$i++)
	{
	  if($imagepatharr[$i])
	  {
		  $year_path .= $imagepatharr[$i]."/";
		  //echo "<br>";
		  if (!file_exists($year_path)){
			  mkdir($year_path, 0777);
		  }     
		}
	}
	@mkdir( $target );
		$d = dir( $source );
		
	if ( is_dir( $source ) ) {
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ) {
				full_copy( $Entry, $target . '/' . $entry );
				continue;
			}
			@copy( $Entry, $target . '/' . $entry );
		}
	
		$d->close();
	}else {
		@copy( $source, $target );
	}
}

global $multicity_db_table_name,$wpdb;
$wpdb->query("INSERT INTO `".$multicity_db_table_name."` (`cityname`, `lat`, `lng`, `scall_factor`, `is_zoom_home`, `categories`, `is_default`, `city_slug`) VALUES
('Philadelphia', '39.953438023308465', '-75.14579772949219', 15, 'No', '4,5,6,7,8,9,10',1, 'philadelphia' )");

global $custom_post_meta_db_table_name;
$wpdb->query("INSERT INTO `".$custom_post_meta_db_table_name."` (`cid`, `admin_title`, `htmlvar_name`, `admin_desc`, `site_title`, `ctype`, `default_value`, `option_values`, `clabels`, `sort_order`, `is_active`, `show_on_listing`, `show_on_detail`, `extrafield1`, `extrafield2`) VALUES
(2, 'Enter Custom field1', 'customfield1', 'Enter Custom field1. Example : value1,value2,value3', 'Custom field1', 'text', '', '', 'Enter Custom field1', 1, 0, 1, 1, '', ''),
");
?>