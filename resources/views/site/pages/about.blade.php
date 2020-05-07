@extends('site.layout.master')
@section('title','How it Works')
@section('content')
    <div id="content-wrap">
		<div id="page-content">
			<div class="page-header d-flex align-items-center" style="background-image: url('{{asset('mod/images/Portrait-of-young-father-carrying-his-daughter-on-his-back-862222524_5760x3840.jpeg')}}');">
				<div class="container">
					<div class="row">
						<div class="col">
							<h1 class="text-center text-white"> About Oasis</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row justify-content-center pt-5 pb-4 pt-md-6 pb-md-5">
					<div class="col-md-10 text-center">
						<h2 class="separator-center h3 wow">Legal Funding You Can Trust</h2>
						<p>Oasis was founded in 2003 by attorneys who saw a specific need among several of their clients. These clients were burdened with increasing medical bills and living expenses, but their cases weren’t settling fast enough to make payments. The attorneys launched Oasis to provide a way for plaintiffs to receive <a href="https://www.oasisfinancial.com/faq/">pre-settlement funding</a> and make life livable until their case closed.</p>
					</div>
				</div>
				<div class="row justify-content-center no-gutters align-items-center">
					<div class="col-md-5 font-size-28 font-weight-bold pr-md-5">
						<div class="mb-4 mb-md-7 px-2 px-md-0"> Our founders established a philosophy and values that guide our business every day.</div>
					</div>
					<div class="col-md-4 pl-4 pr-3 py-3 bg-white shadow position-relative" style="z-index: 2">
						<ul class="values font-size-16">
							<li class="border-bottom border-light"> Help people in difficult circumstances regain some control and prevent disaster.</li>
							<li class="border-bottom border-light"> Be responsible and transparent so customers can make informed choices.</li>
							<li class="border-bottom border-light"> Ensure a dignified customer experience by engaging them with respect and understanding.</li>
						</ul>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-10 px-0 px-md-3"> 
                        <img src="{{asset('mod/images/Depositphotos_169383864_xl-2015.jpg')}}" alt="Oasis Values" class="d-block valuesImg position-relative img-fluid" style="z-index: 1;">
                    </div>
				</div>
			</div>
			<div class="bg-light pt-5 pb-5 pt-md-8 pb-md-7 mt-md-n miles">
				<div class="container">
					<div class="row justify-content-center ">
						<div class="col-md-12 pr-md- font-size-18 line-height-28">
							<h2 class="h3 separator-left ">Milestones</h2>
						</div>
						<div class="col-md-6">
							<p>Today our organization includes <strong>Key Health</strong>, which offers medical lien solutions; and <strong>AccidentMeds</strong>, a pharmacy card program.</p>
						</div>
						<div class="col-md-6">
							<div class=" d-flex justify-content-center align-iems-center flex-wrap  px-4">
                                <div class="w-50 px-3"> 
                                    <a href="https://www.keyhealth.net/" target="_blank"> 
                                    <img src="{{asset('mod/images/Key-Health-horizontal-cmyk.png')}}" alt="Key" class="img-fluid d-block m-auto"> 
                                    </a>
                                </div>
                                <div class="w-50  px-3"> 
                                    <a href="https://www.accidentmeds.com/" target="_blank"> 
                                        <img src="{{asset('mod/images/AccidentMeds-horizontal-cmyk.png')}}" alt="AcciedentMeds" class="img-fluid d-block m-auto"> 
                                    </a>
                                </div>
							</div>
						</div>
					</div>
					<div class="row justify-content-center ">
						<div class="col-md-6">
							<p>We are founding partners of <a href="http://arclegalfunding.org/" target="_blank" rel="noopener"><strong>ARC</strong></a>, the Alliance for Responsible Consumer Lending, and <a href="http://www.accessforpatients.org/" target="_blank" rel="noopener"><strong>APA</strong></a>, Americans for Patient Access.</p>
						</div>
						<div class="col-md-6">
							<div class=" d-flex justify-content-center align-iems-center flex-wrap  px-4">
								<div class="w-50  px-3"> <a href="http://arclegalfunding.org/" target="_blank"> 
								<img src="{{asset('mod/images/ARC-LOGO-PNG.png')}}" alt="The Arc" class="img-fluid d-block m-auto" style="height: 70px;" /> </a></div>
                                <div class="w-50  px-3"> 
                                    <a href="http://www.accessforpatients.org/" target="_blank"> 
                                        <img src="{{asset('mod/images/keyhealth-logo-01-copy-3.png')}}" alt="APA" class="img-fluid d-block m-auto" style=" height: 35px; position:relative; top:20px;" /> 
                                    </a>
                                </div>
							</div>
						</div>
					</div>
					<div class="row justify-content-center ">
						<div class="col-md-6">
							<p>We’re proud of our A+ rating from the Better Business Bureau, and our four-star rating from Trustpilot. We’ve been a lifeline for more than 250,000 individuals and families, providing relief during difficult times.</p>
						</div>
						<div class="col-md-6">
							<div class=" d-flex justify-content-center align-iems-center flex-wrap  px-4">
								<div class="w-50  px-3"> <img src="{{asset('mod/images/bbaplus-e1558734159523.png')}}" alt="bbaplus" class="img-fluid d-block m-auto" style="height: 50px;"></div>
								<div class="w-50  px-3">
									<div class="trustpilot-widget" data-locale="en-US" data-template-id="53aa8912dec7e10d38f59f36" data-businessunit-id="5bdc94abfbd6140001fa449c" data-style-height="130px" data-style-width="100%" data-theme="light" data-stars="4,5" data-schema-type="Organization" style="width:100%"> <a href="https://www.trustpilot.com/review/oasisfinancial.com" target="_blank" rel="noopener">Trustpilot</a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bg-secondary leaders" style="background-image: url('{{asset('mod/images/Depositphotos_211232802_xl-2015.jpg')}}');">
			<div class="container pt-5 pb-4 pt-md-5 pb-md-6">
				<div class="row">
					<div class="col text-center">
						<h2 class="separator-center h3 text-white wow">Meet Our Leaders</h2>
					</div>
				</div>
				<div class="row justify-content-center d-none d-md-flex">
					<div class="col-md-5 pr-md-5">
						<ul class="nav flex-column nav-pills" id="myTab" role="tablist">
							<li class="nav-item"> <a class="nav-link active" id="leaders1-tab" data-toggle="tab" href="#leaders1" role="tab" aria-controls="leaders1" aria-selected="true"> <span class="font-weight-semibold"> Greg Zeeman</span> | <span class="font-size-14"> Chief Executive Officer</span></a></li>
							<li class="nav-item"> <a class="nav-link " id="leaders2-tab" data-toggle="tab" href="#leaders2" role="tab" aria-controls="leaders2" aria-selected=""> <span class="font-weight-semibold"> Robert Gallagher</span> | <span class="font-size-14"> Chief Financial Officer</span></a></li>
							<li class="nav-item"> <a class="nav-link " id="leaders3-tab" data-toggle="tab" href="#leaders3" role="tab" aria-controls="leaders3" aria-selected=""> <span class="font-weight-semibold"> Griffin Gordon</span> | <span class="font-size-14"> Chief Operating Officer</span></a></li>
							<li class="nav-item"> <a class="nav-link " id="leaders4-tab" data-toggle="tab" href="#leaders4" role="tab" aria-controls="leaders4" aria-selected=""> <span class="font-weight-semibold"> Mohammed Hanif</span> | <span class="font-size-14"> Chief Information Officer</span></a></li>
							<li class="nav-item"> <a class="nav-link " id="leaders5-tab" data-toggle="tab" href="#leaders5" role="tab" aria-controls="leaders5" aria-selected=""> <span class="font-weight-semibold"> Jeff Trigilio</span> | <span class="font-size-14"> Head of Medical Lien, CEO of Key Health</span></a></li>
							<li class="nav-item"> <a class="nav-link " id="leaders6-tab" data-toggle="tab" href="#leaders6" role="tab" aria-controls="leaders6" aria-selected=""> <span class="font-weight-semibold"> Phil Greenberg</span> | <span class="font-size-14"> General Counsel</span></a></li>
						</ul>
					</div>
					<div class="col-md-5">
						<div class="tab-content bg-white rounded px-4 py-4" id="myTabContent">
							<div class="tab-pane fade show active" id="leaders1" role="tabpanel" aria-labelledby="leaders1-tab"> 
                                <img src="{{asset('mod/images/Greg-Z.jpg')}}" alt="Greg Z">
								<p class="font-weight-semibold mb-4"> Responsible for Mission, Vision and Growth</p>
								<div class="font-size-16 border-left border-success pl-3 no-margin-bottom" style="border-width: 2px !important;">
									<p><strong>Relevant Experience</strong></p>
									<ul>
										<li>20+ years of leadership experience in consumer lending, specialty finance organizations including serving as COO for Enova International and COO for HSBC USA</li>
										<li>Former CEO for Main Street Renewal, a leading privately held multi-market single family real estate rental company</li>
									</ul>
									<hr />
									<p><strong>Education</strong></p>
									<ul>
										<li>B.A. Economics and Political Science, University of North Carolina</li>
										<li>M.B.A., Harvard Business School</li>
									</ul>
								</div>
							</div>
							<div class="tab-pane fade " id="leaders2" role="tabpanel" aria-labelledby="leaders2-tab"> 
                                <img src="{{asset('mod/images/Bob-G.jpg')}}" alt="Bob G">
								<p class="font-weight-semibold mb-4"> Responsible for Finance, Marketing, Human Resources and Facilities</p>
								<div class="font-size-16 border-left border-success pl-3 no-margin-bottom" style="border-width: 2px !important;">
									<p><strong>Relevant Experience</strong></p>
									<ul>
										<li>CFO of Cars.com/Classified Ventures for 12 years</li>
										<li><span class="s1">20+ years experience in high-tech businesses</span></li>
									</ul>
									<hr />
									<p><strong>Education</strong></p>
									<ul>
										<li>B.S. Accountancy, Northern Illinois University</li>
										<li>M.B.A., Northern Illinois University College of Business</li>
									</ul>
								</div>
							</div>
							<div class="tab-pane fade " id="leaders3" role="tabpanel" aria-labelledby="leaders3-tab"> 
                                <img src="{{asset('mod/images/Griffin-G.jpg')}}" alt="Griffin G">
								<p class="font-weight-semibold mb-4"> Responsible for Operations, Analytics and Business Strategy</p>
								<div class="font-size-16 border-left border-success pl-3 no-margin-bottom" style="border-width: 2px !important;">
									<p><strong>Relevant Experience</strong></p>
									<ul>
										<li><span class="s1">Led 500+ person business, Performant Recovery, that provides asset recovery services to federal agency, state government and corporate clients</span></li>
										<li><span class="s1">10+ years of financial services and technology experience as both as an operator and investor</span></li>
									</ul>
									<hr />
									<p><strong>Education</strong></p>
									<ul>
										<li>B.A., Dartmouth College</li>
										<li>M.B.A., University of Chicago Booth School of Business</li>
									</ul>
								</div>
							</div>
							<div class="tab-pane fade " id="leaders4" role="tabpanel" aria-labelledby="leaders4-tab"> 
                                <img src="{{asset('mod/images/Mohammed-H.jpg')}}" alt="Mohammed H">
								<p class="font-weight-semibold mb-4"> Responsible for Technology Strategy and Execution</p>
								<div class="font-size-16 border-left border-success pl-3 no-margin-bottom" style="border-width: 2px !important;">
									<p class="p1"><strong><span class="s1">Relevant Experience</span></strong></p>
									<ul>
										<li class="p1"><span class="s1">Diverse background in a variety of technology roles across several industries</span></li>
										<li class="p1"><span class="s1">Implemented several multi-million-dollar cost saving initiatives</span></li>
										<li class="p1"><span class="s1">Implemented multi-country ERP systems</span></li>
									</ul>
									<hr />
									<p><strong>Education</strong></p>
									<ul>
										<li>B.S. Computer Engineering, University of Illinois Urbana-Champaign</li>
										<li>M.B.A., Northwestern University – Kellogg School of Management</li>
									</ul>
								</div>
							</div>
							<div class="tab-pane fade " id="leaders5" role="tabpanel" aria-labelledby="leaders5-tab"> 
                                <img src="{{asset('mod/images/Jeff-T.jpg')}}" alt="Jeff T">
								<p class="font-weight-semibold mb-4"> Responsible for Medical Lien Sales</p>
								<div class="font-size-16 border-left border-success pl-3 no-margin-bottom" style="border-width: 2px !important;">
									<p class="p1"><strong><span class="s1">Relevant Experience</span></strong></p>
									<ul>
										<li class="p1"><span class="s1">Pioneer in developing the medical lien financing industry</span></li>
										<li class="p1"><span class="s1">40 years running successful businesses in medical financing and medical provider services</span></li>
										<li class="p1"><span class="s1">Founder of Key Health Group, Inc., the largest medical lien funding company in the U.S.</span></li>
									</ul>
									<hr />
									<p><strong>Education</strong></p>
									<ul>
										<li>B.S. Nuclear Medicine, Rochester Institute of Technology</li>
										<li>Graduate Research, SUNY Buffalo</li>
									</ul>
								</div>
							</div>
							<div class="tab-pane fade " id="leaders6" role="tabpanel" aria-labelledby="leaders6-tab"> 
                                <img src="{{asset('mod/images/phil-g-684x1024.jpg')}}" alt="Phil G">
								<p class="font-weight-semibold mb-4"> Responsible for Legal, Regulatory, Business Development and Strategy</p>
								<div class="font-size-16 border-left border-success pl-3 no-margin-bottom" style="border-width: 2px !important;">
									<p class="p1"><span class="s1"><strong>Relevant Experience</strong></span></p>
									<ul>
										<li class="p1"><span class="s1">Entrepreneur with 10+ years as CEO and founder of a successful plaintiff funding company</span></li>
										<li class="p1"><span class="s1">Developed a private label mortgage origination product for credit unions</span></li>
										<li class="p1"><span class="s1">M&amp;A and Structured Finance attorney, most recently with Cadwalader Wickersham &amp; Taft</span></li>
									</ul>
									<hr />
									<p><strong>Education</strong></p>
									<ul>
										<li>B.A., SUNY Stony Brook</li>
										<li>JD, Brooklyn Law School</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row d-md-none">
					<div class="col">
						<div class="accordion" id="accordionExample">
							<div class="card bg-transparent border-0">
								<div class="card-header bg-transparent border-0 p-0" id="heading1">
									<h2 class="mb-0"> <button class="btn btn-link text-left px-3 pt-3 pb-3 font-family-sans-serif font-weight-bold w-100" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapseOne"> <span class="d-block font-size-24"> Greg Zeeman</span> <span class="font-size-14 d-block"> Chief Executive Officer</span> </button></h2>
								</div>
								<div id="collapse1" class="collapse bg-white" aria-labelledby="heading1" data-parent="#accordionExample">
									<div class="card-body pt-2"> 
                                        <img src="{{asset('mod/images/Greg-Z-237x300.jpg')}}" alt="Greg Z">
										<p class="font-weight-semibold mb-4"> Responsible for Mission, Vision and Growth</p>
										<div class="font-size-16" style="border-width: 2px !important;">
											<p><strong>Relevant Experience</strong></p>
											<ul>
												<li>20+ years of leadership experience in consumer lending, specialty finance organizations including serving as COO for Enova International and COO for HSBC USA</li>
												<li>Former CEO for Main Street Renewal, a leading privately held multi-market single family real estate rental company</li>
											</ul>
											<hr />
											<p><strong>Education</strong></p>
											<ul>
												<li>B.A. Economics and Political Science, University of North Carolina</li>
												<li>M.B.A., Harvard Business School</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="card bg-transparent border-0">
								<div class="card-header bg-transparent border-0 p-0" id="heading2">
									<h2 class="mb-0"> <button class="btn btn-link text-left px-3 pt-3 pb-3 font-family-sans-serif font-weight-bold w-100" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapseOne"> <span class="d-block font-size-24"> Robert Gallagher</span> <span class="font-size-14 d-block"> Chief Financial Officer</span> </button></h2>
								</div>
								<div id="collapse2" class="collapse bg-white" aria-labelledby="heading2" data-parent="#accordionExample">
									<div class="card-body pt-2"> 
                                        <img src="{{asset('mod/images/Bob-G-225x300.jpg')}}" alt="Bob G">
										<p class="font-weight-semibold mb-4"> Responsible for Finance, Marketing, Human Resources and Facilities</p>
										<div class="font-size-16" style="border-width: 2px !important;">
											<p><strong>Relevant Experience</strong></p>
											<ul>
												<li>CFO of Cars.com/Classified Ventures for 12 years</li>
												<li><span class="s1">20+ years experience in high-tech businesses</span></li>
											</ul>
											<hr />
											<p><strong>Education</strong></p>
											<ul>
												<li>B.S. Accountancy, Northern Illinois University</li>
												<li>M.B.A., Northern Illinois University College of Business</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="card bg-transparent border-0">
								<div class="card-header bg-transparent border-0 p-0" id="heading3">
									<h2 class="mb-0"> <button class="btn btn-link text-left px-3 pt-3 pb-3 font-family-sans-serif font-weight-bold w-100" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapseOne"> <span class="d-block font-size-24"> Griffin Gordon</span> <span class="font-size-14 d-block"> Chief Operating Officer</span> </button></h2>
								</div>
								<div id="collapse3" class="collapse bg-white" aria-labelledby="heading3" data-parent="#accordionExample">
									<div class="card-body pt-2"> 
                                        <img src="{{asset('mod/images/Griffin-G-205x300.jpg')}}" alt="Griffin G">
										<p class="font-weight-semibold mb-4"> Responsible for Operations, Analytics and Business Strategy</p>
										<div class="font-size-16" style="border-width: 2px !important;">
											<p><strong>Relevant Experience</strong></p>
											<ul>
												<li><span class="s1">Led 500+ person business, Performant Recovery, that provides asset recovery services to federal agency, state government and corporate clients</span></li>
												<li><span class="s1">10+ years of financial services and technology experience as both as an operator and investor</span></li>
											</ul>
											<hr />
											<p><strong>Education</strong></p>
											<ul>
												<li>B.A., Dartmouth College</li>
												<li>M.B.A., University of Chicago Booth School of Business</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="card bg-transparent border-0">
								<div class="card-header bg-transparent border-0 p-0" id="heading4">
									<h2 class="mb-0"> <button class="btn btn-link text-left px-3 pt-3 pb-3 font-family-sans-serif font-weight-bold w-100" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapseOne"> <span class="d-block font-size-24"> Mohammed Hanif</span> <span class="font-size-14 d-block"> Chief Information Officer</span> </button></h2>
								</div>
								<div id="collapse4" class="collapse bg-white" aria-labelledby="heading4" data-parent="#accordionExample">
									<div class="card-body pt-2"> 
                                        <img src="{{asset('mod/images/Mohammed-H-223x300.jpg')}}" alt="Mohammed H">
										<p class="font-weight-semibold mb-4"> Responsible for Technology Strategy and Execution</p>
										<div class="font-size-16" style="border-width: 2px !important;">
											<p class="p1"><strong><span class="s1">Relevant Experience</span></strong></p>
											<ul>
												<li class="p1"><span class="s1">Diverse background in a variety of technology roles across several industries</span></li>
												<li class="p1"><span class="s1">Implemented several multi-million-dollar cost saving initiatives</span></li>
												<li class="p1"><span class="s1">Implemented multi-country ERP systems</span></li>
											</ul>
											<hr />
											<p><strong>Education</strong></p>
											<ul>
												<li>B.S. Computer Engineering, University of Illinois Urbana-Champaign</li>
												<li>M.B.A., Northwestern University – Kellogg School of Management</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="card bg-transparent border-0">
								<div class="card-header bg-transparent border-0 p-0" id="heading5">
									<h2 class="mb-0"> <button class="btn btn-link text-left px-3 pt-3 pb-3 font-family-sans-serif font-weight-bold w-100" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapseOne"> <span class="d-block font-size-24"> Jeff Trigilio</span> <span class="font-size-14 d-block"> Head of Medical Lien, CEO of Key Health</span> </button></h2>
								</div>
								<div id="collapse5" class="collapse bg-white" aria-labelledby="heading5" data-parent="#accordionExample">
									<div class="card-body pt-2"> 
                                        <img src="{{asset('mod/images/Jeff-T-216x300.jpg')}}" alt="Jeff T">
										<p class="font-weight-semibold mb-4"> Responsible for Medical Lien Sales</p>
										<div class="font-size-16" style="border-width: 2px !important;">
											<p class="p1"><strong><span class="s1">Relevant Experience</span></strong></p>
											<ul>
												<li class="p1"><span class="s1">Pioneer in developing the medical lien financing industry</span></li>
												<li class="p1"><span class="s1">40 years running successful businesses in medical financing and medical provider services</span></li>
												<li class="p1"><span class="s1">Founder of Key Health Group, Inc., the largest medical lien funding company in the U.S.</span></li>
											</ul>
											<hr />
											<p><strong>Education</strong></p>
											<ul>
												<li>B.S. Nuclear Medicine, Rochester Institute of Technology</li>
												<li>Graduate Research, SUNY Buffalo</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="card bg-transparent border-0">
								<div class="card-header bg-transparent border-0 p-0" id="heading6">
									<h2 class="mb-0"> <button class="btn btn-link text-left px-3 pt-3 pb-3 font-family-sans-serif font-weight-bold w-100" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapseOne"> <span class="d-block font-size-24"> Phil Greenberg</span> <span class="font-size-14 d-block"> General Counsel</span> </button></h2>
								</div>
								<div id="collapse6" class="collapse bg-white" aria-labelledby="heading6" data-parent="#accordionExample">
									<div class="card-body pt-2"> 
                                        <img src="{{asset('mod/images/phil-g-200x300.jpg')}}" alt="Phil G">
										<p class="font-weight-semibold mb-4"> Responsible for Legal, Regulatory, Business Development and Strategy</p>
										<div class="font-size-16" style="border-width: 2px !important;">
											<p class="p1"><span class="s1"><strong>Relevant Experience</strong></span></p>
											<ul>
												<li class="p1"><span class="s1">Entrepreneur with 10+ years as CEO and founder of a successful plaintiff funding company</span></li>
												<li class="p1"><span class="s1">Developed a private label mortgage origination product for credit unions</span></li>
												<li class="p1"><span class="s1">M&amp;A and Structured Finance attorney, most recently with Cadwalader Wickersham &amp; Taft</span></li>
											</ul>
											<hr />
											<p><strong>Education</strong></p>
											<ul>
												<li>B.A., SUNY Stony Brook</li>
												<li>JD, Brooklyn Law School</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container pt-5 pb-4 pt-md-5 pb-md-6">
			<div class="row justify-content-center pb-4">
				<div class="col-md-10 text-center">
					<h2 class="h3 separator-center wow">Meet Our Teams</h2>
					<p>Oasis works for our customers because of the dedicated team that works for Oasis. Below is an overview of the teams and team members that make Oasis great.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="team-wrapper row">
						<div class="col-lg-4 col-md-6">
							<div class="single-team" style="background-image: url( '{{asset('mod/images/Business-Strategy-Analytics-2-10-9-19.jpg')}}' );">
								<div class="team-content"> <span class="team-name">Business Strategy and Analytics</span>
									<p>The Business Strategy and Analytics team monitors business performance, identifies trends, and helps the business improve through data-driven solutions.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-team" style="background-image: url( '{{asset('mod/images/Call-Center-10-9-19.jpg')}}');">
								<div class="team-content"> <span class="team-name">Call Center</span>
									<p>The Call Center assists customers in the funding process by answering questions, taking applications and providing status updates, while providing the best possible customer service.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-team" style="background-image: url( '{{asset('mod/images/Case-Management-10-9-19.jpg')}}');">
								<div class="team-content"> <span class="team-name">Case Management</span>
									<p>The Case Management team leads the contract process, providing excellent customer service, ensuring clients understand the contracts, routing them for approval, and ensuring we help as many people as quickly as we can.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-team" style="background-image: url('{{asset('mod/images/Funding-10-9-16.jpg')}}');">
								<div class="team-content"> <span class="team-name">Funding</span>
									<p>The Funding team is tasked with the due diligence part of providing fundings. They review each funding before it is deployed to ensure our clients receive their funds with efficiency and accuracy.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-4 d-none d-lg-flex align-items-center justify-content-center"> 
                            <img src="{{asset('mod/images/IMG_2850.JPG')}}" alt="Oasis Financial"></div>
						<div class="col-lg-4 col-md-6">
							<div class="single-team" style="background-image: url( '{{asset('mod/images/Inside-Sales-2-10-9-19.jpg')}}' );">
								<div class="team-content"> <span class="team-name">Inside Sales</span>
									<p>Inside Sales serves as a single point of contact for attorneys, working with their plaintiffs to understand the details of the case, collect all required information, and kick-off the funding process.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-team" style="background-image: url('{{asset('mod/images/Servicing-10-9-19.jpg')}}');">
								<div class="team-content"> <span class="team-name">Servicing</span>
									<p>The Servicing team helps customers and their attorneys after their cases are funded by providing payoffs, answering general questions, and processing payment at settlement.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-team" style="background-image: url('{{asset('mod/images/Shared-Services-10-9-19.jpg')}}');">
								<div class="team-content"> <span class="team-name">Shared Services</span>
									<p>From Finance, to Marketing, HR, IT, and Legal, these teams ensure our business is financially strong, customers know about us, we’re attracting new talent to our teams, and operating at the highest levels of compliance.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-team" style="background-image: url( '{{asset('mod/images/Underwriting-QA-10-9-19.jpg')}}');">
								<div class="team-content"> <span class="team-name">Underwriting and QA</span>
									<p>The Underwriting and QA teams evaluate risk and prevent fraud in the funding process. They help ensure Oasis is adhering to the high standards it sets for itself.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row justify-content-center pt-5">
				<div class="col-md-10 text-center">
					<h2 class="h3 separator-center wow">Work at Oasis</h2>
					<p>At Oasis Financial, we help victims of accidents recover physically and financially from an injury. We help our customers access medical care and the funds they need to pay bills while waiting for a lawsuit to settle. Team members work directly with individual customers, attorney partners or colleagues at headquarters in a variety of specializations.</p>
				</div>
			</div>
		</div>
		<div class="team-full mb-5" style="background-image:url( '{{asset('mod/images/oasis-team.jpg')}}' );">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-6">
						<div class="team-left">
							<p>If you crave a high energy culture, possess a strong work ethic, and seek rewards that match achievement, review our <a href="http://www.oasisfinancial.com/about-oasis/careers/"><span style="text-decoration: underline;"><strong>open jobs</strong></span></a> and apply today!</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container pt-3 pb-4 pt-md-2 pb-md-6">
			<div class="row justify-content-center">
				<div class="col-md-10 text-center">
					<h2 class="h3 separator-center mb-md-7 wow"> Media</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-10">
					<div class="row justify-content-center">
						<div class="col-md px-4 text-center"> 
                            <a href="https://www.oasisfinancial.com/oasis-financial-and-key-health-team-up-with-los-angeles-trial-lawyers-charities/" class="d-block mediaLink py-4 py-md-0"> 
                                <img src="{{asset('mod/images/Videos-Copy.png')}}" class="d-block ml-auto mr-auto img-fluid rounded mb-4" alt="Oasis media" style="height:90px; width:auto;" /> 
                                <span class="font-size-24 font-weight-bold d-block"> Oasis Financial and Key Health team up with Los Angeles Trial Lawyers Charities </span> 
                            </a>
                        </div>
						<div class="col-md px-4 text-center"> 
                            <a href="https://www.oasisfinancial.com/oasis-partners-with-nonprofit-arc-to-increase-consumer-financial-wellness/" class="d-block mediaLink py-4 py-md-0"> 
                                <img src="{{asset('mod/images/ARC-LOGO-PNG.png')}}" class="d-block ml-auto mr-auto img-fluid rounded mb-4" alt="Oasis media" style="height:90px; width:auto;" /> 
                                <span class="font-size-24 font-weight-bold d-block"> Oasis Partners with Nonprofit ARC to Increase Consumer Financial Wellness </span> 
                            </a>
                        </div>
						<div class="col-md px-4 text-center"> 
                            <a href="https://www.oasisfinancial.com/oasis-receives-bbb-a-certification/" class="d-block mediaLink py-4 py-md-0"> 
                                <img src="{{asset('mod/images/BBB-A-rating-1.png')}}" class="d-block ml-auto mr-auto img-fluid rounded mb-4" alt="Oasis media" style="height:90px; width:auto;" /> 
                                <span class="font-size-24 font-weight-bold d-block"> Oasis Receives BBB A+ Certification </span> 
                            </a>
                        </div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col text-center"> 
                    <a href="https://www.oasisfinancial.com/contact-us/" class="arrow-right mt-5 mb-3 mt-md-5 mb-md-0">Media inquiries: Contact Us</a></div>
			</div>
		</div>
	</div>
@endsection
@section('css')
    <link media="all" href="{{asset('mod/css/about.css')}}" rel="stylesheet" />
@endsection