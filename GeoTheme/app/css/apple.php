<style>

/* Main Div */



h1, h2 {
	color: #333; 
	white-space: nowrap;
	overflow: hidden;
	margin: 0;
	padding: 10px 15px 0px 15px;
	font-size: 16px;
	font-weight: bold;
	text-shadow: rgba(0, 0, 0, 0.5) 1px 1px 1px;
}



/* CONTENT ITEMS */
	
div.content {
	padding: 0px;
	margin: 0px;
	-webkit-transition-property: -webkit-transform;
	-webkit-transition-timing-function: cubic-bezier(0,0,0.25,1);
	-webkit-transition-duration: 0;
	-webkit-transform: translate3d(0, 0, 0);
	color: #000;
	text-shadow: #efefef 1px 1px 1px;
	position: absolute;
	left: 0px; 
	top: 0px;
	right: 0px; 
	bottom: 0px;
}	

/* LISTS: rounded and edgetoedge */

div.content ul.rounded { 
	color: #000;
    font: bold 17px "Helvetica Neue", Helvetica;
    padding: 0px;
    margin: 15px 10px 15px 10px;
	-webkit-border-radius: 8px;
	-webkit-box-shadow: 1px 1px 2px #aaa;
}


table {
white-space: normal;
line-height: normal;
font-weight: normal;
font-size: medium;
font-variant: normal;
font-style: normal;
color: #333 !important;
text-align: -webkit-auto;
}

div.content ul.rounded li {
    color: #333 !important;
	border-left: 1px solid #888;
	border-right: 1px solid #888;
    border-top: 1px solid #ccc;
    list-style-type: none;
    padding: 10px;
	margin: 0px;
	background-color: #fff;
}

div.content ul.rounded li a{
    color: #333;
    text-decoration: none;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    display: block;
    padding: 12px 10px 12px 10px;
    margin: -10px;
    -webkit-tap-highlight-color: rgba(0,0,0,0);
	text-shadow: #222222 1px 1px 1px;
}



div.content ul li a.clicked {
	color: white;
	text-shadow: #333333 1px 1px 1px;
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#1faeef), to(#187bc8));
}

div.content ul.rounded li:first-child, div.content ul.rounded li:first-child div.label-wide{
	-webkit-border-top-left-radius: 8px;
	-webkit-border-top-right-radius: 8px;
    border-top: 1px solid #888;
}
div.content ul.rounded li:first-child a.clicked {
	-webkit-border-top-left-radius: 8px;
	-webkit-border-top-right-radius: 8px;
}

div.content ul.rounded li:last-child {
	-webkit-border-bottom-left-radius: 8px;
	-webkit-border-bottom-right-radius: 8px;
    border-bottom: 1px solid #888!important;
}

div.content ul.rounded li:last-child a.clicked {
	-webkit-border-bottom-left-radius: 8px;
	-webkit-border-bottom-right-radius: 8px;
}

/* List Elements */

/* FORMS */



.clear {
	clear: both;
}

div.content div.label {
	float: left;
	width: 70px;
	background-color: #eff5f5;
	margin: -10px 0px -10px -10px;
	padding: 11px 6px 14px 10px;
	font-size: 10px;
	font-weight: bold;
	color: #414b5a;
	text-shadow: #ffffff 1px 1px 1px;
	text-align: right;
	border-right: 1px solid #e2efef;
}

div.content div.label-wide {
	float: none;
	width: 100%;
	background-color: #eff5f5;
	margin: -10px 0px 5px -10px;
	padding: 4px 10px 8px 10px;
	font-size: 13px;
	font-weight: bold;
	color: #414b5a;
	text-shadow: #cccccc 1px 1px 1px;
	text-align: center;
	border-right: 1px solid #e2efef;
}

div.content div.label-img{padding:0px;}

div.content ul li:first-child div.label {
	border-top-left-radius: 8px;
}

div.content ul li:last-child div.label {
	border-bottom-left-radius: 8px;
}

div.content div.field {
	padding: 0px 0px 0px 78px;
	margin: -5px 0px -3px 0px;
}

 
div.content input[type=text],
div.content input[type=tel],
div.content input[type=email],
div.content input[type=url],
div.content input[type=password],
div.content select,
div.content textarea
{
	/*color: white !important;*/
	width:98%;
}





/* Overlays */

div.overlay {
	margin: 0px;
	padding: 0px;
	position: absolute;
	z-index: 10;
	border: 1px solid #1d263e;	
	background: rgba(10, 18, 38, 0.8);
	-webkit-border-radius: 5px;
	-webkit-box-shadow: 0px 0px 30px #333333;
	-webkit-box-sizing: border-box;
	font-family: helvetica;
	overflow: hidden;
}

div.overlay .toolbar {
    -webkit-box-sizing: border-box;
	-webkit-border-top-left-radius: 5px;
	-webkit-border-top-right-radius: 5px;
	background: -webkit-gradient(linear, 0% 0%, 0% 35, 
		from(rgba(220, 220, 220, 0.8)), 
		color-stop(0.02, rgba(145, 148, 157, 0.8)),
		color-stop(0.5, rgba(70, 78, 93, 0.8)),
		color-stop(0.6, rgba(58, 65, 82, 0.8)),
		to(rgba(10, 18, 38, 0.8)) );
	margin: 0px; 
    padding: 10px;
    height: 45px;
    -border-bottom: 1px solid #2d3642;
	-webkit-box-shadow: 0px 0px 10px black;
	position: relative;
	z-index: 5;
}

div.overlay .toolbar > h1 {
    overflow: hidden;
    text-overflow: ellipsis;
	display: block;
    height: 40px;
    font-size: 18px;
    font-weight: bold;
    text-shadow: rgba(0, 0, 0, 0.4) 0px -1px 0;
    text-align: center;
	padding: 0px; 
	margin: 0px;
    white-space: nowrap;
    color: #fff;
	float:left;
}
div.overlay .toolbar img{float:right;}


div.overlay .footer {
	left: 5px;
	right: 5px;
	bottom: 5px;
	width: auto;
	height: 50px;
	position: absolute;
	overflow: hidden;
	text-align: center;
	color: white;
}

div.overlay .content {
    -webkit-box-sizing: border-box;
	margin: 0px;
    padding: 5px;
	width: auto;
	left: 5px; 
	right: 5px;
	top: 5px;
	bottom: 5px;
	background-color: white;
	-webkit-border-radius: 5px;
	position: absolute;
	color:#333;
	text-shadow:none;
}



/* List Elements */

.fixed{overflow:hidden;position:fixed;height:100%;width:100%;}

.error{border:2px red solid !important;}
.error div.label-wide {border-top:none !important;padding-right:9px !important;}
</style>






<style type="text/css">
/* Eric Meyer's Reset */html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{border:0;font-size:100%;font:inherit;vertical-align:baseline;margin:0;padding:0;}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block;}body{line-height:1;}ol,ul{list-style:none;}blockquote,q{quotes:none;}blockquote:before,blockquote:after,q:before,q:after{content:none;}table{border-spacing:0;}

/* Common */
strong,.strong {font-weight:bold;}
.center {text-align:center;}


/* Structure */
html, #wrap {background:transparent;font: 16px normal Helvetica,sans-serif;-webkit-user-select: none;}
			
	#main {background:transparent;height:100%;padding:63px 20px 20px 320px;position:relative;vertical-align:top;}
		#main .header {padding-left:155px;width:100%;}
			#main .header .left,
			#main .header .right {background: #7A8091; /* Old browsers */background: -moz-linear-gradient(top, #999999 0%, #333333 100%); /* FF3.6+ */background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#999999), color-stop(100%,#333333)); /* Chrome,Safari4+ */background: -webkit-linear-gradient(top, #999999 0%,#333333 100%); /* Chrome10+,Safari5.1+ */background: -o-linear-gradient(top, #999999 0%,#333333 100%); /* Opera 11.10+ */background: -ms-linear-gradient(top, #999999 0%,#333333 100%); /* IE10+ */background: linear-gradient(top, #999999 0%,#333333 100%); /* W3C */filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#999999', endColorstr='#333333',GradientType=0 ); /* IE6-9 */
color: #fff;border-radius: 5px;border: 1px solid #6d6d6d;font-size: 12px;left: 310px;position: fixed;top: 9px;padding: 5px 8px;text-decoration:none;}
			#main .header .title {}
			#main .header .right {right: 10px;left: auto;}
		#main .content {margin-top:20px;}
			#main .content>:first-child {margin-top:0 !important;}
			#main .content .title {font-size:18px;font-weight:bold;margin:20px 10px 10px;}
			#main .content .title2 {color:#4C536C;font-size:16px;font-weight:bold;margin:20px 0 10px;}
			#main .content .title3 {}
			#main .content .title4 {}
			#main .content .title5 {}
			#main .content>p {color:#4C536C;margin:10px 0;text-shadow:0 1px 1px #ccc;}
			#main .content p.note {color:#4C536C;font-size:12px;text-align:center;text-shadow:0 1px 1px #ccc;}
			
			/* Box white */
			#main .content .box-white {border:1px solid #C9C9C9;border-radius:10px;margin: 0 10px;	background-color: #fff;
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#fdfdfd), to(#f0f0f0));
}
				#main .content .box-white p:first-child {color: #555;border-bottom:1px solid #333;font-weight:bold;margin:0;padding:10px;}
				#main .content .box-white p {color: #333;font-weight:bold;margin:0;padding:10px;}
					#main .content .box-white p:last-child {border-bottom:none;}
				#main .content .box-white p span {color: #555;float:right;font-weight:normal;}
					#main .content .box-white p span.detail {color: #999;float: none;font-size:12px;margin-left:5px;}
					#main .content .box-white p span.arrow {color: #666;float: none;font-family: monospace;font-weight: bold;margin-left: 5px;text-shadow: 0 1px 1px #666;}
			
			/* Tables */
			#main table {margin:20px 0 10px;width:100%;}
				#main table thead th {color:#848B9A;font-size:90%;font-weight:normal;margin:20px 0 10px;padding-bottom:10px;text-align:left;}
					#main table thead th:first-child {color:#000;font-size:16px;font-weight:bold;}
						#main table tbody tr:last-child {border-bottom:none;}
							#main table tbody tr td:first-child {padding-left:10px;}
							#main table tbody tr td:last-child {padding-right:10px;}
							
							/* Dirty fix attempt for tbody border-radius */
							#main table tbody {border-spacing: 0;}
								#main table tbody tr {border:1px solid #B4B7BB;border-radius:10px;}
								#main table tbody tr:first-child td:first-child {border-top-left-radius:10px;}
								#main table tbody tr:first-child td:last-child {border-top-right-radius:10px;}
								#main table tbody tr:last-child td:first-child {border-bottom-left-radius:10px;}
								#main table tbody tr:last-child td:last-child {border-bottom-right-radius:10px;}
								#main table tbody tr:last-child {border-bottom:1px solid #B4B7BB;}

				/* Links */
				a {color:#0085d5;text-decoration:none;-webkit-touch-callout: none;}
				#main .content .box-white p a,
				#main .content table a {display: block;padding: 10px;margin: -10px;}

				/* Forms and buttons */
				#main .content p label {width:15%;} /* Labels not currently clickable without scripting */
				#main .content p input[type=text],
				#main .content p input[type=tel],
				#main .content p input[type=email],
				#main .content p input[type=url],
				#main .content p input[type=password],
				#main .content p select {background:none;border:none;color:#4C556C;float:right;font-size:14px;margin-top: -1px;}
				#main .content p select {margin-right:15px;}
				#main .content p textarea {background:none;border:none;color:#4C556C;font-size:14px;margin-top: -1px;width:100%;height:100px;}
				#main .content .button {color:#fff;cursor:pointer;border:1px solid #999;border-radius: 5px;font-size:16px;font-weight:bold;padding: 8px;width:100%;}
				#main .content .button.red {background: #D42E32; /* Old browsers */
background: -moz-linear-gradient(top, #d58e94 0%, #d42e32 50%, #be1012 51%, #90191b 100%); /* FF3.6+ */background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#d58e94), color-stop(50%,#d42e32), color-stop(51%,#be1012), color-stop(100%,#90191b)); /* Chrome,Safari4+ */background: -webkit-linear-gradient(top, #d58e94 0%,#d42e32 50%,#be1012 51%,#90191b 100%); /* Chrome10+,Safari5.1+ */background: -o-linear-gradient(top, #d58e94 0%,#d42e32 50%,#be1012 51%,#90191b 100%); /* Opera 11.10+ */background: -ms-linear-gradient(top, #d58e94 0%,#d42e32 50%,#be1012 51%,#90191b 100%); /* IE10+ */background: linear-gradient(top, #d58e94 0%,#d42e32 50%,#be1012 51%,#90191b 100%); /* W3C */filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d58e94', endColorstr='#90191b',GradientType=0 ); /* IE6-9 */
border-color:#9A8185;}
				#main .content .button.blue {background: #3030d4; /* Old browsers */
background: -moz-linear-gradient(top, #8b8bd5 0%, #3030d4 50%, #1111bb 51%, #181893 100%); /* FF3.6+ */background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#8b8bd5), color-stop(50%,#3030d4), color-stop(51%,#1111bb), color-stop(100%,#181893)); /* Chrome,Safari4+ */background: -webkit-linear-gradient(top, #8b8bd5 0%,#3030d4 50%,#1111bb 51%,#181893 100%); /* Chrome10+,Safari5.1+ */background: -o-linear-gradient(top, #8b8bd5 0%,#3030d4 50%,#1111bb 51%,#181893 100%); /* Opera 11.10+ */background: -ms-linear-gradient(top, #8b8bd5 0%,#3030d4 50%,#1111bb 51%,#181893 100%); /* IE10+ */background: linear-gradient(top, #8b8bd5 0%,#3030d4 50%,#1111bb 51%,#181893 100%); /* W3C */filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8b8bd5', endColorstr='#181893',GradientType=0 ); /* IE6-9 */
border-color:#9A8185;}



/* All portable */
@media only screen and (max-device-width: 1024px) {
	#sidebar {overflow:scroll;} /* Sidebar is only scrollable in portable devices, you can change that */
}
/* iPhone */
@media only screen and (max-width: 768px) {
	#sidebar {display:none;}
	#main {padding-left:20px;}
		#main .header {padding-left:0;}
			#main .header .left {left:10px;}
			
#main .content p label {}
				#main .content p input[type=text],
				#main .content p input[type=password],
				#main .content p select {width:60%;}
}


.arrow-left {
	width: 0; 
	height: 0; 
	border-top: 10px solid transparent;
	border-bottom: 10px solid transparent; 
	border-right:10px solid #000; 
}

.arrow-down {
	width: 0; 
	height: 0; 
	border-left: 10px solid transparent;
	border-right: 10px solid transparent;
	border-top: 10px solid #999;
}

.ddown {background:#ffffff;display:none;}

.message_note{margin-left:2px;}
.form_cat, .form_subcat {width:280px !important;margin-left:-80px;}


</style>