<?php

__('Hotels','geotheme');
__('Restaurants','geotheme');




// ***** NOTE: when editing text in this file, a single apostrophe ( ' ) can cause the site to break
// ***** Use an escaped apostrophe ( \' ) inside text in ALL cases
// ***** Good Example: define('EXAMPLE_TEXT',__('It\'s a nice day.'));
// ***** Bad Example define('EXAMPLE_TEXT',__('It's a nice day.'));
//header.php
define('ADD_LISTING',__('Add Listing','geotheme'));
define('ADD_EVENT',__('Add Event','geotheme'));
define('HEADER_ADD_PLACE_SEO',__('Add Place Listing','geotheme'));
define('HEADER_ADD_EVENT_SEO',__('Add Event Listing','geotheme'));
define('HEADER_ADD_PREVIEW_SEO',__('Add Listing Preview','geotheme'));
define('HEADER_LOGIN_REGISTRATION_SEO',__('Site Registration and Login Form'));
define('HEADER_SUCCESS_PAGE_SEO',__('Success'));
//submit_event.php
define('EVENT_REGISTRATION_DESC',__('How to Register'));
define('EVENT_REGISTRATION_FEES',__('Registration Fees'));
define('EVENT_REGISTRATION_DESC_MSG',__('Enter how to register details '));
$currency = get_option('currency');
$currencysym = get_option('currencysym');
define('EVENT_REGISTRATION_FEES_MSG',__('Enter Registration Fees, in '));
define('EVENT_REGISTRATION_FEES_PRICE_MSG',__($currency.' eg. : <b>'.$currencysym.'50</b>'));


define('POST_EVENT_TITLE',__('Add Event'));
define('UPGRADE_EVENT_TEXT',__('Upgrade Event'));
define('RENEW_EVENT_TEXT',__('Renew Event'));
define('EDIT_EVENT_TEXT',__('Update Event'));
define('POST_PLACE_TITLE',__('Add Listing'));
define('UPGRADE_LISING_TEXT',__('Upgrade Listing'));
define('RENEW_LISING_TEXT',__('Renew Listing'));
define('EDIT_LISING_TEXT',__('Update Listing'));
define('EVENT_DATE',__('Date'));
define('EVENT_TIME',__('Time'));

define('RENEW_LINK',__('Renew Now'));


define('IAM_TEXT',__("I am"));
define('LOGINORREGISTER',__("Login or Register"));
define('EXISTING_USER_TEXT',__("Existing User"));
define('NEW_USER_TEXT',__("New User? Register Now"));
define('LOGIN_TEXT',__('Login'));
define('SUBMIT_BUTTON',__('Submit'));
define('PRO_PHOTO_TEXT',__('Add Images : <small>(You can upload more than one images to create image gallery on detail page)</small>'));
define('PHOTOES_BUTTON',__('Select Images'));
define('PRO_DESCRIPTION_TEXT',__('Listing Description'));
define('EVENT_DESCRIPTION_TEXT',__('Event Description'));
define('PRO_FEATURE_TEXT',__('Special Offers'));
define('CONTACT_TEXT',__('Contact Number'));
define('PRO_ADD_COUPON_TEXT',__('Enter Coupon Code'));
define('COUPON_NOTE_TEXT',__('Enter coupon code here (optional)'));
define('CAPTCHA_TITLE_TEXT',__('Captcha Verification'));
define('SELECT_TYPE_TEXT',__('Select Package Type'));
define('COUPON_CODE_TITLE_TEXT',__('Coupon Code'));

define('PUBLISH_DAYS_TEXT',__('%s : number of publish days are %s (<span id="%s">%s %s</span>)'));
define('SELECT_PAY_MEHTOD_TEXT',__('Select Payment Method'));


define('GOING_TO_PAY_MSG',__('This is preview of your listing and its not published yet. <br />If there is something wrong then "Go back and edit" or if you want to add listing then click on "Publish".<br> You are going to pay <b>%s</b> &  alive days are <b>%s</b> as %s listing'));
define('GOING_TO_UPDATE_MSG',__('This is preview of your listing and its not updated yet. <br />If there is something wrong then "Go back and edit" or if you want to add listing then click on "Update now"'));
define('GOING_TO_FREE_MSG',__('This is preview of your listing and its not published yet. <br />If there is something wrong then "Go back and edit" or if you want to add listing then click on "Publish".<br> Your %s listing will published for <b>%s</b> days'));
define('UNLIMITED',__('Unlimited'));



define('WRONG_COUPON_MSG',__('Invalid Coupon Code'));

define('EMAIL_USERNAME_EXIST_MSG',__('Email ID already exists. Please select a different Email.'));
define('REGISTRATION_DESABLED_MSG',__('New user registration disabled.'));

define('GENERAL_PROPERTY_INFO_TEXT',__('Select Package'));
define('SET_GOOGLE_MAP',__('Set Google Map'));
define('CAPTCHA',__('Word Verification'));
define('PRO_PREVIEW_BUTTON',__('Review Your Listing'));
define('EVENT_INFO_TEXT',__('Listing Information'));
define('SELECT_LISTING_TYPE_TEXT',__('Select Listing Type'));
define('SELECT_EVENT_TYPE_TEXT',__('Select Type'));
define('EVENT_TITLE_TEXT',__('Listing Title'));
define('IMAGE_ORDERING_MSG',__('Note : You can drag and drop the images to change the order and then click on "Save Order" to save'));
define('IMAGE_SAVE_ORDERING_MSG',__('Note : You can sort images once the post is saved by clicking on "Edit" on the listing'));
define('CONTACT_NAME_TEXT',__('Name'));
define('CITY_TEXT',__('City'));
define('STATE_TEXT',__('State'));
define('MOBILE_TEXT',__('Mobile Number'));
define('EMAIL_TEXT',__('Email'));
define('EMAIL_TEXT_MSG',__('Enter valid Email otherwise you will face an error on the next page.'));
define('WEBSITE_TEXT',__('Website'));
define('TWITTER_TEXT',__('Twitter'));
define('FACEBOOK_TEXT',__('Facebook'));
define('TAGKW_TEXT',__('Tag Keywords'));
define('TAGKW_MSG',__('Tags are short keywords, with no space within.(eg: tag1, tag2, tag3) Up to 40 characters only.'));
define('PHOTO_TEXT',__('Upload Photo'));
define('BIODATA_TEXT',__('Short Biodata Information'));
define('IMAGE_TYPE_MSG',__('Note : PNG, GIF of JPEG only, for better image quality upload image size 150x150'));
define('HTML_TAGS_ALLOW_MSG',__('Note : Basic HTML tags are allowed'));
define('HTML_SPECIAL_TEXT',__('Note: List out any special offers (optional)'));
define('EVENT_CATETORY_TEXT',__('Category'));
define('EVENT_ADDRESS',__('Address'));
define('EVENT_ADDRESS_LAT',__('Address Latitude'));
define('EVENT_ADDRESS_LNG',__('Address Longitude'));
define('EVENT_MAP_VIEW_LNG',__('Google Map View'));
define('EVENT_CITY_TEXT',__('Select City'));


define('BASIC_INFO_TEXT',__('Home Information'));
define('PRO_BACK_AND_EDIT_TEXT',__('&laquo; Go Back and Edit'));
define('PRO_UPDATE_BUTTON',__('Update Now'));
define('PRO_RENEW_BUTTON',__('Renew Now')); ### ADDED BY STIOFAN
define('PRO_UPGRADE_BUTTON',__('Upgrade Now')); ### ADDED BY STIOFAN
define('PRO_SUBMIT_BUTTON',__('Publish'));
define('PRO_CANCEL_BUTTON',__('Cancel'));
define('PRO_SUBMIT_PAY_BUTTON',__('Pay & Publish'));
define('EVENT_DESCRIPTION',__('Listing Description'));
define('CONTACT_DETAIL_TITLE',__('Publisher Information'));
define('EVENT_INFORMATION_TEXT',__('Fill Out Event Information'));
define('LISTING_DETAILS_TEXT',__('Enter Listing Details'));

define('EVENT_DETAILS_TEXT',__('Enter Event Details'));
define('EVENT_TITLE',__('Event Title'));
define('A_BUSS',__('Link Business'));


define('EVENT_TIMING',__('Time'));
define('EVENT_ST_DATE',__('Event Start Date'));
define('EVENT_ST_DATE_MSG',__('Enter Event Start Date. eg. : ').'<b>'.date('Y-m-d').'</b>');
define('EVENT_ST_TIME',__('Start Time'));
define('EVENT_ST_TIME_MSG',__('Enter Event Start Time. eg. : ').'<b>'.date('H:i').'</b>');

define('EVENT_END_DATE',__('Event End Date'));
define('EVENT_END_DATE_MSG',__('Enter Event End Date. eg. : ').'<b>'.date('Y-m-d').'</b>');
define('EVENT_END_TIME',__('End Time'));
define('EVENT_END_TIME_MSG',__('Enter Event End Time. eg. : ').'<b>'.date('H:i').'</b>');

define('RECURRING_TEXT',__('Recurring Event'));
define('RECURRING_MSG',__('Select if event is recurring. eg. : <b>Every Week. Note: "Event End Date" must be selected.</b>'));


define('EVENT_CONTACT_INFO',__('Phone'));
define('EVENT_CONTACT_EMAIL',__('Email'));
define('EVENT_WEBSITE',__('Website'));
define('PRO_DELETE_PRE_MSG',__('Are you really sure want to DELETE this listing? Deleted listing can not be recovered later'));
define('PRO_DELETE_BUTTON',__('Yes, Delete Please!'));
define('IS_A_FEATURE_PRO_TEXT',__('This place is listed as Featured. Do you want to remove it from feature listing?'));

define('ADDREDD_MSG',__('Please enter listing address. eg. : <b>230 Vine Street And locations throughout Old City, Philadelphia, PA 19106</b>'));
define('TIMING_MSG',__('Enter Business or Listing Timing Information. <br /> eg. : <b>10.00 am to 6 pm every day</b>'));
define('GET_LATITUDE_MSG',__('Please enter latitude for google map perfection. eg. : <b>39.955823048131286</b>'));
define('GET_LOGNGITUDE_MSG',__('Please enter longitude for google map perfection. eg. : <b>-75.14408111572266</b>'));
define('GET_MAP_MSG',__('Click on "Set Address on Map" and then you can also drag pinpoint to locate the correct address'));
define('CONTACT_MSG',__('You can enter phone number,cell phone number etc.'));
define('WEBSITE_MSG',__('Enter website URL. eg. : <b>http://myplace.com</b>'));
define('TWITTER_MSG',__('Enter twitter URL. eg. : <b>http://twitter.com/myplace</b>'));
define('FACEBOOK_MSG',__('Enter facebook URL. eg. : <b>http://facebook.com/myplace</b>'));
define('CATEGORY_MSG',__('Select listing category from here. Select atleast one category'));
define('EVENT_MSG',__('Select event category from here. Select atleast one category'));

//success.php
define('POSTED_SUCCESS_TITLE',__('Listing Posted Successfully'));
define('RENEW_SUCCESS_TITLE',__('Listing Renewal Successfully'));
define('POSTED_SUCCESS_MSG',__('<p>Thank you, your information has been successfully received.</p><p><a href="[#submited_information_link#]" >View your submitted information &raquo;</a></p><p>Thank you for visiting us at [#site_name#].</p>'));
define('POSTED_SUCCESS_PREBANK_MSG',__('<p>Thank you, your request received successfully.</p><p>To publish the property please transfer the amount of <u>[#order_amt#] </u> at our bank with the following information :</p>
<p>Account Name : [#bank_name#]</p><p>Account Sort Code : [#account_sortcode#]</p><p>Account Number : [#account_number#]</p><br><p>Please include the ID as reference : [#orderId#]</p><p><a href="[#submited_information_link#]" >View your submitted listing</a><br>
<p>Thank you for visit at [#site_name#].</p>'));
//cancel.php
define('PAY_CANCELATION_TITLE',__('Posting Canceled'));
define('PAY_CANCEL_MSG',__('<h3>Your listing is cancelled. Sorry for cancellation.</h3><h5>Thank you for visiting us at [#site_name#].</h5>'));

//return.php
define('PAYMENT_SUCCESS_TITLE',__('Payment Success'));
define('PAYMENT_SUCCESS_MSG',__('<h4>Your payment received successfully and your information is published.</h4>
<p><a href="[#submited_information_link#]" >View your submitted information &raquo;</a></p><h5>Thank you for becoming a member at [#site_name#].</h5>'));

define('PAYMENT_FAIL_TITLE',__('Payment Failed'));
define('PAYMENT_FAIL_MSG',__('<h4>There was a problem with your payment.</h4>'));



//dashboard.php
define('DASHBOARD_TEXT',__('Dashboard'));
define('EDIT_PROFILE_PAGE_TITLE',__('Edit Profile'));
define('CHANGE_PW_TEXT',__('Change Password'));

//sidebar.php
define('MY_ACCOUNT_TEXT',__('My Account'));

//header.php
define('WELCOME_TEXT',__('Welcome '));
define('GUEST_TEXT',__('Guest'));
define('LOGOUT_TEXT',__('Logout'));
define('SIGN_IN_TEXT',__('Sign In'));
define('SIGN_UP_TEXT',__('Signup'));

//author.php
define('LISTING_NOT_AVAIL_MSG',__('No listings posted yet.'));
define('EDIT_TEXT',__('edit'));
define('RENEW_TEXT',__('renew'));
define('DELETE_TEXT',__('delete'));
define('UPGRADE_TEXT',__('upgrade'));

//registration.php
define('FORGOT_PW_TEXT',__('Forgot Password?'));
define('USERNAME_EMAIL_TEXT',__('E-mail'));
define('USERNAME_TEXT',__('Email'));
define('PASSWORD_TEXT',__('Password'));

define('PASSWORD_LENGTH_MSG',__('Enter your user password, must be 7 characters or more'));
define('PASSWORD_LENGTH_TEXT',__('Password must be 7 characters or more'));
define('PASSWORD_MATCH_TEXT',__('Passwords do not match'));

define('REMEMBER_ON_COMPUTER_TEXT',__('Remember me on this computer'));
define('GET_NEW_PW_TEXT',__('Get New Password'));
define('INDICATES_MANDATORY_FIELDS_TEXT',__('Indicates mandatory fields'));
define('REGISTRATION_NOW_TEXT',__('Sign Up Now'));
define('PERSONAL_INFO_TEXT',__('Personal Information'));
define('FIRST_NAME_TEXT',__('Full Name'));
define('REGISTRATION_MESSAGE',__('(note: A password will be e-mailed to you for future usage.)'));
define('REGISTER_NOW_TEXT',__('Register Now'));
define('SIGN_IN_BUTTON',__('Sign In'));
define('REGISTER_BUTTON',__('Register'));
define('SIGN_IN_PAGE_TITLE',__('Sign In'));
define('INVALID_USER_PW_MSG',__('Invalid Username/Password.'));
define('REG_COMPLETE_MSG',__('Registration complete. Please check your e-mail for login details.'));
define('NEW_PW_EMAIL_MSG',__('We just sent you a new password. Kindly check your e-mail now.'));
define('EMAIL_CONFIRM_LINK_MSG',__('A confirmation link has been sent to you via email. Kindly check your e-mail now.'));
define('USER_REG_NOT_ALLOW_MSG',__('User registration has been disabled by the admin.'));
define('YOU_ARE_LOGED_OUT_MSG',__('You are now logged out.'));
define('ENTER_USER_EMAIL_NEW_PW_MSG',__('Please enter your e-mail address as username. You will receive a new password via e-mail.'));
define('INVALID_USER_FPW_MSG',__('Invalid Email, Please check'));
define('PW_SEND_CONFIRM_MSG',__('Check your e-mail for your new password.'));

//widget_functios.php
define('ENTER_LOCATION_TEXT',__('Enter Your Location'));
define('READMORE_TEXT',__('Read More...'));

//comments.php
define('COMMENTS_TITLE_PLACE',__('Place Your Review'));
define('COMMENTS_TITLE_BLOG',__('Your Comments'));
define('RATING_MSG',__('Rate this place by clicking a star below :'));
define('COMMENT_TEXT',__('Comment'));
define('REVIEW_TEXT',__('Review'));
define('COMMENT_TEXT2',__('Comments'));
define('REVIEW_TEXT2',__('Reviews'));
define('REVIEW_SUBMIT_BTN',__('Submit Review'));
//comments_functions.php
define('OWNER_TEXT',__('Business Owner'));
define('SITE_ADMIN',__('Site Admin'));



//header_searchform.php
define('NEAR_TEXT',__('Near'));
define('SEARCH_FOR_TEXT',__('Search for'));
define('SEARCH_FOR_MSG',__('food, products or place'));
define('SEARCH_NEAR_MSG',__('Zip code or address '));
define('SEARCH',__('Search'));

//profile.php
define('EDIT_PROFILE_TITLE',__('Edit Profile'));
define('CONFIRM_PASSWORD_TEXT',__('Confirm Password'));
define('EDIT_BUTTON',__('Edit'));
define('EDIT_PROFILE_SUCCESS_MSG',__('Profile edited successfully.'));
define('EMPTY_EMAIL_MSG',__('Please enter Email.'));
define('ALREADY_EXIST_MSG',__('Email already exist, please choose another.'));
define('PW_NO_MATCH_MSG',__('Profile edited successfully.'));

//paypal_response.php
define('PAYPAL_MSG',__('Processing for paypal, Please wait...'));
//2co_response.php
define('TWOCO_MSG',__('Processing for 2Checkout, Please wait...'));
//authorizenet_response.php
define('AUTHORISE_NET_MSG',__('Processing for Authorize Net, Please wait...'));
//googlechekcout_response.php
define('GOOGLE_CHKOUT_MSG',__('Processing for Google Checkout, Please wait...'));
//2co_response.php
define('WORLD_PAY_MSG',__('Processing for WordPay, Please wait...'));


//success.php
define('PROPERTY_POSTED_SUCCESS_PREBANK_MSG',__('<p>Thanks. The listing has been submitted successfully.</p><p>In order to publish the listing, kindly transfer amount of <u>[#$order_amt#] </u> in our bank. Our bank account details are mentioned below.</p>
<p>Bank Name : [#$bank_name#]</p><p>Account Number : [#$account_number#]</p><br><p>Please include the following reference : [#$orderId#]</p><p><a href="[#$submited_listing_link#]" >View your submitted listing &raquo;</a></p><br><p>Thanks for listing your listing at [#$store_name#].</p>'));

//submit_event.php
define('HOW_TO_APPLY_DESC_TEXT',__('<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href="#" class="button">Register Now</a></p>'));

//favourite
define('MY_FAVOURITE_TEXT',__('My Favorites'));
define('ADD_FAVOURITE_TEXT',__('Add to Favorites'));
define('REMOVE_FAVOURITE_TEXT',__('Remove from Favorites'));
define('FAVOURITE_NOT_AVAIL_MSG',__('You have not added any favourites yet.'));


//popup_frms.php
define('OWNER_VERIFIED_PLACE',__('Owner Verified Listing'));
define('OWNER_VERIFIED_EVENT',__('Owner Verified Event'));
define('SEND_TO_FRIEND',__('Send To Friend'));
define('ADD_PLACE_CLAIM_LISTING',__('Business Owner/Associate?'));
define('ADD_EVENT_CLAIM_LISTING',__('Event Owner/Associate?'));
define('CLAIM_LISTING',__('Claim Listing'));
define('VERIFY_PAGE_TITLE',__('Verify Listing'));
define('CLAIM_LISTING_OWNER',__('Business Owner?'));
define('CLAIM_LISTING_PROCESS_SHOW',__('What is the claim proccess?'));
define('CLAIM_LISTING_PROCESS_HIDE',__('Hide claim proccess.'));
define('CLAIM_LISTING_PROCESS',__('Fill out the form below, we will verify your claim and email you confirmation.'));
define('CLAIM_LISTING_SAMPLE_CONTENT',__('Hi i am the owner of this business and i would like to claim it...'));
define('CLAIM_LISTING_SUCCESS',__('Request sent successfully'));
define('SEND_TO_FRIEND_SAMPLE_CONTENT',__('Hi there, check out this site, I think you might be interested in..'));
define('SEND_INQUIRY',__('Send Enquiry'));
define('SEND_INQUIRY_SAMPLE_CONTENT',__('Hi there, I would like to enquire about this place. I would like to ask more info about...'));
define('SEND_INQUIRY_SUCCESS',__('Enquiry sent successfully'));
define('SEND_FRIEND_SUCCESS',__('Email to Friend sent successfully'));
define('WRONG_CAPTCH_MSG',__('Enter correct verification code.'));


define('VERIFY_TEXT',__('CLICK HERE TO VERIFY'));
define('NOT_WITH_PACKAGE',__('Not available with the selected package.'));
define('NO_CATEGORY_LISTINGS',__('<b>No Listings here</b>'));


define('BROWSING_CATEGORY',__('Browsing Category'));
define('BROWSING_TAG',__('Browsing Tag'));
define('BROWSING_AUTHOR',__('Browsing Posts of Author'));
define('BROWSING_DAY',__('Browsing Day'));
define('BROWSING_MONTH',__('Browsing Month'));
define('BROWSING_YEAR',__('Browsing Year'));
define('ERROR_404_NAME',__('Error 404 | Nothing found!'));
define('SOLUTION_404_NAME',__('Sorry, but you are looking for something that is not here.'));
define('PASSWORD_PROTECTED',__('This post is password protected. Enter the password to view comments.'));
define('NO_REVIEW',__('No Review'));
define('ONE_REVIEW',__('One Review'));
define('MULTIPLE_REVIEW',__('% Review'));
define('COMMENT_TRACKBACKS',__('Trackbacks For This Post'));
define('COMMENT_MODERATION',__('Your review is awaiting moderation.'));
define('COMMENTS_CLOSED',__('Review are closed.'));
define('COMMENT_REPLY',__('Post Your Review'));
define('COMMENT_MUSTBE',__('You must be'));
define('COMMENT_LOGGED_IN',__('logged in'));
define('COMMENT_POST_REVIEW',__('to post a review.'));
define('COMMENT_LOGOUT',__('Logout'));
define('COMMENT_NAME',__('Name'));
define('COMMENT_EMAIL',__('Email'));
define('COMMENT_WEBSITE',__('Website'));
define('COMMENT_ADD_COMMENT',__('Add Comment'));
define('COMMENT_REPLY_NAME',__('Reply'));
define('COMMENT_EDIT_NAME',__('Edit'));
define('COMMENT_DELETE_NAME',__('Delete'));
define('COMMENT_SPAM_NAME',__('Spam'));


define('RELATIVE_POSTED',__('Posted'));
define('RELATIVE_AGO',__('ago'));
define('RELATIVE_S',__('s'));
define('RELATIVE_YEAR',__('year'));
define('RELATIVE_MONTH',__('month'));
define('RELATIVE_WEEK',__('week'));
define('RELATIVE_DAY',__('day'));
define('RELATIVE_HOUR',__('hour'));
define('RELATIVE_MINUTE',__('minute'));
define('RELATIVE_MOMENTS',__('moments'));

define('UPLOAD_IMAGE',__('Upload Image'));
define('ATTACH_IMAGE',__('Attach an image to your review.'));

//MAPS
define('MAP_NO_RESULTS',__('<h3>No Records Found</h3><p>Sorry, no records were found. Please adjust your search criteria and try again.</p>'));

//AUTHOR PAGE
define('EVENTS',__('Events'));
define('LISTINGS',__('Listings'));
define('UPCOMING',__('Upcoming'));
define('PAST',__('Past'));
define('VIEW_AUTHOR',__('View Author'));


define('NO_IMAGES',__('Images are not allowed with this selected package.'));

// USER FIELDS
define('USER_PIC',__('Profile Picture'));
define('USER_WEBSITE',__('Website URL'));
define('USER_AIM',__('AOL IM'));
define('USER_YIM',__('Yahoo IM'));
define('USER_JABBER',__('Jabber / Google Talk'));
define('USER_BIO',__('About You'));
define('USER_COUNTRY',__('Nationality'));
define('USER_CITY',__('Your City'));
define('USER_FACEBOOK',__('Facebook URL'));
define('USER_TWITTER',__('Twitter URL'));
define('USER_GPLUS',__('Google Plus URL'));

// USER PROFILE
define('USER_PROFILE_PIC',__('Profile Picture'));
define('USER_PROFILE_WEBSITE',__('Website'));
define('USER_PROFILE_AIM',__('AOL IM'));
define('USER_PROFILE_YIM',__('Yahoo IM'));
define('USER_PROFILE_JABBER',__('Jabber / Google Talk'));
define('USER_PROFILE_BIO',__('About You'));
define('USER_PROFILE_COUNTRY',__('Nationality'));
define('USER_PROFILE_CITY',__('City'));
define('USER_PROFILE_FACEBOOK',__('Facebook URL'));
define('USER_PROFILE_TWITTER',__('Twitter URL'));
define('USER_PROFILE_GPLUS',__('Google Plus URL'));



define('PRO_VIDEO_TEXT',__('Video code'));
define('HTML_VIDEO_TEXT',__('Add video code here, YouTube etc'));

define('NEW_USER_INFO',__('You will be asked for new user details on the next page'));
define('LOGIN_CLAIM',__('You must be logged in to claim a listing. Please login/register and retry.'));


define('NEIGHBOURHOOD',__('Neighbourhood'));
define('NEIGHBOURHOOD_MSG',__('Select Neighbourhood'));


define('EVENT_VENUE',__('Event Venue'));


define('FEATURED_IMG_CLASS',__('featured_img_class'));

define('NEAR_ME',__('me'));

// API
define('REPORT_LOGIN_MSG',__('You must be logged in to report this'));
define('REPORT_ALREADY_MSG',__('You have already reported this post.'));
define('REPORT_THIS',__('Report this?'));
define('REPORT_REPORTED',__('Thank you for reporting this post.'));
define('REPORT_NO_REASON',__('You must give a reason.'));
define('ADDED_FAV',__('Added to Favorites.'));
define('REMOVED_FAV',__('Removed from Favorites.'));
define('ADD_DISABLED',__('Adding listings has been disabled.'));


// Recurring Events
define('RECCURING_NOT',__('Not Recurring'));
define('RECCURING_WEEK',__('Every Week'));
define('RECCURING_2WEEK',__('Every Two Weeks'));
define('RECCURING_MONTH',__('Every Month'));
define('RECCURING_YEAR',__('Every Year'));


// Preview page
define('SUBMITTING',__('Submitting...'));





?>