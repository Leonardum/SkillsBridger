<?php
include_once('header.html');
?>

<body>
    <div id="wrapper">
        <div id="header">
            <div id="logo">
                <img src="./images/web Logo.png">
            </div>
            
			<ul id="navbar">
				<li>
					<a href="#student"><button class="transparent-button">Student</button></a>
				</li>
				<li>
					<a href="#eventOrganiser"><button class="transparent-button">Event organiser</button></a>
				</li>
				<!--
				<li>
					<a href="#business"><button class="transparent-button">Business</button></a>
				</li>
				-->
			</ul>
        </div>
        <img id="headerImg" src="./images/Home page background.png">
        <!-- The height of the div tag is 92% of the screen, since the height of the header is 8% of the screen. -->
        <div style="height:92%; width:100%; clear:both;">
            <h1 class="homepageTitle">Educate yourself</h1>
            <h2 class="homepageSubTitle">...because no one else will!</h2>
			<div style="position:absolute; width:inherit; top:75%; text-align:center;">
				<a href="index.php?action=createAccount"><button class="call-to-action">Join now</button></a>
				<a href="index.php?action=logIn"><button class="call-to-action-neighbour">Log in</button></a>
			</div>
        </div>
	</div>
	
	<div class="homeContent">
		<div class="row">
			<a name="student"></a>
			<div class="col-10 valuePropositionBox">
				<p class="valuePropositionTitle">Are you a student who wants to work on your entrepreneurship, marketing, finance or accounting skills?</p>
				<div class="col-20 valuePropositionRow">
					<div class="valuePropSubRow" style="order:1;">
						<div class="homePageIconCol">
							<div class="homePageIconFrame">
								<img class="homePageIcon" src="./images/transparency.png">
							</div>
						</div>
						<div class="homePageTextCol">
							<div class="homeIconTextFrame">
								<div class="homeIconTextDiv">
									<p>Find out which skills are actually required to reach your professional ambition.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="valuePropSubRow" style="order:2;">
						<div class="homePageIconCol">
							<div class="homePageIconFrame">
								<img class="homePageIcon" src="./images/learningRecommendation.png">
							</div>
						</div>
						<div class="homePageTextCol">
							<div class="homeIconTextFrame">
								<div class="homeIconTextDiv">
									<p>Learn these skills at serious events around you, such as workshops and lectures.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-20 valuePropositionRow">
					<div class="valuePropSubRow" style="order:1;">
						<div class="homePageIconCol">
							<div class="homePageIconFrame">
								<img class="homePageIcon" src="./images/certifiedProfile.png">
							</div>
						</div>
						<div class="homePageTextCol">
							<div class="homeIconTextFrame">
								<div class="homeIconTextDiv">
									<p>Get certified for the skills you learn.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="valuePropSubRow" style="order:2;">
						<div class="homePageIconCol">
							<div class="homePageIconFrame">
								<img class="homePageIcon" src="./images/free.png">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-10 callToActionBox studentBackground">
				<div style="position:absolute; top:15%; left:50%;">
					<div style="position:relative; left:-50%;">
						<img class="callToActionImg" src="./images/microDegree2White.png">
					</div>
				</div>
				<div style="position:absolute; top:70%; left:50%;">
					<div style="position:relative; left:-50%;">
						<a href="index.php?action=createAccount"><button class="call-to-action">Start working on my skills</button></a>
					</div>
				</div>
			</div>
		</div>
		
		<div id="organiserRow" class="row">
			<a name="eventOrganiser"></a>
			<div class="col-10 callToActionBox organisationBackground" style="order:2;">
				<div style="position:absolute; top:15%; left:50%;">
					<div style="position:relative; left:-50%;">
						<img class="callToActionImg" src="./images/promoteWhite.png">
					</div>
				</div>
				<div style="position:absolute; top:70%; left:50%;">
					<div style="position:relative; left:-50%;">
						<a href="index.php?action=createAccount"><button class="call-to-action">Join our ecosystem now</button></a>
					</div>
				</div>
			</div>
			<div class="col-10 valuePropositionBox" style="order:1;">
				<p class="valuePropositionTitle">Do you organize educative events and do you want<br>to become a part of our ecosystem?</p>
				<div class="col-20 valuePropositionRow">
					<div class="valuePropSubRow" style="order:1;">
						<div class="homePageIconCol">
							<div class="homePageIconFrame">
								<img class="homePageIcon" src="./images/promote.png">
							</div>
						</div>
						<div class="homePageTextCol">
							<div class="homeIconTextFrame">
								<div class="homeIconTextDiv">
									<p>Promote your event directly to students searching for the skills your event offers.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="valuePropSubRow" style="order:2;">
						<div class="homePageIconCol">
							<div class="homePageIconFrame">
								<img class="homePageIcon" src="./images/organiserMicroDegreeValue.png">
							</div>
						</div>
						<div class="homePageTextCol">
							<div class="homeIconTextFrame">
								<div class="homeIconTextDiv">
									<p>Increase the value of your learning event by tying a certificate to it.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-20 valuePropositionRow">
					<div class="valuePropSubRow" style="order:1;">
						<div class="homePageIconCol">
							<div class="homePageIconFrame">
								<img class="homePageIcon" src="./images/eventData.png">
							</div>
						</div>
						<div class="homePageTextCol">
							<div class="homeIconTextFrame">
								<div class="homeIconTextDiv">
									<p>Have access to all your event data through SkillsBridger, including the attendee lists!</p>
								</div>
							</div>
						</div>
					</div>
					<div class="valuePropSubRow" style="order:2;">
						<div class="homePageIconCol">
							<div class="homePageIconFrame">
								<img class="homePageIcon" src="./images/sponsorSpotlight.png">
							</div>
						</div>
						<div class="homePageTextCol">
							<div class="homeIconTextFrame">
								<div class="homeIconTextDiv">
									<p>Highlight your sponsors or partners.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!--
		<div class="row">
			<a name="business"></a>
			<div class="col-10" style="height:600px;">
				<p class="valuePropositionTitle">Do you want to recruit the best profiles?</p>
				<div class="col-20 valuePropositionRow" style="margin-top:50px;">
					<div class="valuePropSubRow" style="order:1;">
						<div class="homePageIconCol">
							<div class="homePageIconFrame">
								<img class="homePageIcon" src="./images/jobOffer.png">
							</div>
						</div>
						<div class="homePageTextCol">
							<div class="homeIconTextFrame">
								<div class="homeIconTextDiv">
									<p>Post jobs & internship offers on SkillsBridger.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="valuePropSubRow" style="order:2;">
						<div class="homePageIconCol">
							<div class="homePageIconFrame">
								<img class="homePageIcon" src="./images/businessMicroDegreeValue.png">
							</div>
						</div>
						<div class="homePageTextCol">
							<div class="homeIconTextFrame">
								<div class="homeIconTextDiv">
									<p>Tie micro-degrees to your internships to make them even more attractive for the students.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-10 callToActionBox businessBackground">
				<div style="position:absolute; top:15%; left:50%;">
					<div style="position:relative; left:-50%;">
						<img class="callToActionImg" src="./images/handShake.png">
					</div>
				</div>
				<div style="position:absolute; top:70%; left:50%;">
					<div style="position:relative; left:-50%;">
						<a href="index.php?action=createAccount"><button class="call-to-action">Start recruiting</button></a>
					</div>
				</div>
			</div>
		</div>
		-->
		
		<div class="row">
			<div class="col-20 videoRow">
				<p class="valuePropositionTitle">How does SkillsBridger work? Watch the video:</p>
				<video class="homeVideo" poster="./images/where career paths begin poster.png" controls onclick="playVideo(this)">
					<source src="./videos/Where Career Paths Begin.mp4" type="video/mp4">
					Your browser does not support the display of this video. Please, update your browser if you would like to see it.
				</video>
			</div>
		</div>
		
		<div class="row">
			<div class="col-20 partners">
				<p>DISCOVER OUR PARTNERS:</p>
				<div class="col-20">
					<div class="partnerLogoContainer">
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.startit.be" target="_blank"><img src="./images/startitkbc.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://absoc.be/" target="_blank"><img src="./images/ABSOC.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.capitant.be" target="_blank"><img src="./images/capitant.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.imbit.org" target="_blank"><img src="./images/IMBIT.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.intree.be" target="_blank"><img src="./images/intree.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.lvsv.be" target="_blank"><img src="./images/LVSV.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.promeco.be" target="_blank"><img src="./images/promeco.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.sincantwerpen.be" target="_blank"><img src="./images/SINC.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.solvaybusinessgame.com" target="_blank"><img src="./images/solvay business game.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.unizo.be" target="_blank"><img src="./images/unizo.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.ustartbelgium.com" target="_blank"><img src="./images/ustart.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.wikings.be" target="_blank"><img src="./images/wikings.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.youngpotentials.eu" target="_blank"><img src="./images/young potentials.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.augent.be/" target="_blank"><img src="./images/associatie ugent.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.180dc.org/branch/ghent" target="_blank"><img src="./images/180 degrees consulting.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.co-searching.be/" target="_blank"><img src="./images/co-Searching.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.start-academy.be/nl/mod_users/" target="_blank"><img src="./images/startAccademy.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.bryo.be/" target="_blank"><img src="./images/bryo.png"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-20 inMedia">
				<p style="text-align:center; margin-bottom:50px;">SkillsBridger as featured in:</p>
				<div class="col-20">
					<div class="inMediaLogoContainer">
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.bloovi.be/nieuws/detail/deze-start-up-helpt-studenten-aan-een-job-door-ze-belangrijke-skills-aan-te-leren" target="_blank"><img src="./images/bloovi.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://kanaalz.knack.be/expert/skillsbridger-werkt-aan-uw-vaardigheden-01-11-16/video-normal-771389.html" target="_blank"><img src="./images/KanaalZ.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="http://www.madeinoostvlaanderen.be/nieuws/starter-van-de-week-skillsbridger-helpt-afgestudeerden-sneller-aan-job/" target="_blank"><img src="./images/Made in Oost-Vlaanderen.png"></a>
							</div>
						</div>
						<div class="partnerLogo">
							<div class="partnerLogoFrame">
								<a href="https://www.dvo.be/artikel/54713-skillsbridger-elimineert-skills-gap-tussen-studenten-en-bedrijven/" target="_blank"><img src="./images/dvo.png"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-20" style="height:70px; text-align:center;">
				<a href="index.php?action=contact"><button>Contact us</button></a>
			</div>
		</div>
		<div class="row">
			<div class="col-20 footer">
				<p>All rights reserved © 2016 SkillsBridger</p>
				<p><a class="textLink" href="index.php?action=terms" target="_blank">Terms of service & Privacy Policy</a></p>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="./js/home.js"></script>
</body>


<?php
include_once('footer.html');
?>