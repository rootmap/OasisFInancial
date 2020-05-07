@extends('site.layout.master')
@section('title','Faq')
@section('content')
    <div id="content-wrap">
        <div id="page-content">
            <div class="page-header d-flex align-items-center" style="background-image: url('{{asset('mod/images/Happiness-comes-from-family-534370377_7360x4912.jpeg')}}');">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h1 class="text-center text-white"> FAQ</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="negative-margin mb-4 d-none d-md-block">
                <div class="container">
                    <div class="row">
                        <div class="col-md"> <a href="#faq1" class="text-secondary faq-link bg-white py-4 px-4 d-flex flex-column justify-content-center font-family-serif font-size-24 h-100 shadow-sm text-center font-weight-bold">
                                <p>General Questions</p>
                            </a></div>
                        <div class="col-md"> <a href="#faq2" class="text-secondary faq-link bg-white py-4 px-4 d-flex flex-column justify-content-center font-family-serif font-size-24 h-100 shadow-sm text-center font-weight-bold">
                                <p>Financial</p>
                            </a></div>
                        <div class="col-md"> <a href="#faq3" class="text-secondary faq-link bg-white py-4 px-4 d-flex flex-column justify-content-center font-family-serif font-size-24 h-100 shadow-sm text-center font-weight-bold">
                                <p>After You Apply</p>
                            </a></div>
                        <div class="col-md"> <a href="#faq4" class="text-secondary faq-link bg-white py-4 px-4 d-flex flex-column justify-content-center font-family-serif font-size-24 h-100 shadow-sm text-center font-weight-bold">
                                <p>Types of Funding</p>
                            </a></div>
                        <div class="col-md"> <a href="#faq5" class="text-secondary faq-link bg-white py-4 px-4 d-flex flex-column justify-content-center font-family-serif font-size-24 h-100 shadow-sm text-center font-weight-bold">
                                <p>Case Types</p>
                            </a></div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column">
                <div class="faq-section">
                    <div id="faq1" class="container py-3 pt-md-5 pb-md-6 position-relative">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <h2 class="h3 mb-4 d-none d-md-block">General Questions</h2>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10"> <a href="#" class="h3 expander d-md-none d-block">General Questions</a>
                                <div class="accordion faq expanded" id="accordionExample1">
                                    <div class="card">
                                        <div class="card-header" id="heading1">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11"> Should I be willing to take a lower settlement during the COVID-19 outbreak? </button></h2>
                                        </div>
                                        <div id="collapse11" class="collapse " aria-labelledby="heading1" data-parent="#accordionExample1">
                                            <div class="card-body font-size-18">
                                                <p>With so much financial uncertainty, it may be tempting to take a lower settlement in the interest of obtaining much-needed cash quickly. Negotiating a settlement without full information will be difficult, as you likely don&#8217;t yet have a full understanding of what your injuries are and how much the claim is truly worth. If you can afford to wait or find alternate sources of financial support while you wait, you will have a better chance of getting a fair dollar value on your injury claim.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading2">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12"> What is pre-settlement funding? </button></h2>
                                        </div>
                                        <div id="collapse12" class="collapse " aria-labelledby="heading2" data-parent="#accordionExample1">
                                            <div class="card-body font-size-18">
                                                <p>Pre-settlement funding is when a company gives you money right away in exchange for the right to receive a portion of your financial settlement in the future. You get money immediately to pay bills and pay nothing back until you get money from the settlement of your claims. If you never get money from your claims, you never have to pay anything back to the legal funding company (the official term for this is “non-recourse”).</p>
                                                <p>Pre-settlement funding is sometimes called consumer <a href="https://www.oasisfinancial.com/">legal funding</a>, This type of legal funding is not a loan; there is no debt, no monthly payments, and no risk of collections calls or wage garnishments. Any money paid to the legal funding company comes only out of the proceeds of the settlement, never out of your pocket.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading3">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse13" aria-expanded="false" aria-controls="collapse13"> I don’t have an attorney. What do I do? </button></h2>
                                        </div>
                                        <div id="collapse13" class="collapse " aria-labelledby="heading3" data-parent="#accordionExample1">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Oasis works with a network of attorneys, and can help connect you to one. <a href="/need-an-attorney/">Learn more</a>. </span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading4">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse14" aria-expanded="false" aria-controls="collapse14"> What does non-recourse mean? </button></h2>
                                        </div>
                                        <div id="collapse14" class="collapse " aria-labelledby="heading4" data-parent="#accordionExample1">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Funding that is non-recourse means it doesn’t have to be paid back if you lose your case. When you work with Oasis, we offer to buy part of the proceeds you could receive from your settlement for money now, to help you get by until the rest of your settlement comes in. It’s not a loan — it’s a purchase. Because it’s a purchase, qualifying for funding isn’t based on your credit score (like loans are), and it can never put you into collections (like loans can). Because it’s a purchase, if you lose your case, you owe us nothing.</span> <span style="font-weight: 400;">Non-recourse pre-settlement funding can be a safe, stable alternative to taking out a loan while you wait, and can help you get back on your feet after an accident.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading5">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse15" aria-expanded="false" aria-controls="collapse15"> What is the process? </button></h2>
                                        </div>
                                        <div id="collapse15" class="collapse " aria-labelledby="heading5" data-parent="#accordionExample1">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">There are four easy steps to receive your pre-settlement funding. </span></p>
                                                <ol>
                                                    <li style="font-weight: 400;"><span style="font-weight: 400;"><strong>Apply</strong> — Make sure you have your case information and attorney’s contact information. It’s also important to </span><span style="font-weight: 400;">tell your attorney you are applying for funding on your legal claim so they can expect a call from Oasis; we contact them to verify your case details.</span></li>
                                                    <li style="font-weight: 400;"><span style="font-weight: 400;"><strong>Approval</strong> — Oasis reviews the information provided, and if you are qualified you’ll receive an approval notice and the contract to sign. Make sure you review and fully complete your contract before signing, and ask any questions you may have. Your attorney will also receive an acknowledgement to sign.</span></li>
                                                    <li style="font-weight: 400;"><span style="font-weight: 400;"><strong>Follow Up</strong> — After Oasis receives your signed contract and your attorney’s acknowledgement, we’ll process the request. You’ll receive a timeline and instructions about calling back if you don’t receive confirmation by the end of the timeline.</span></li>
                                                    <li style="font-weight: 400;"><span style="font-weight: 400;"><strong>Receive Funds</strong> — Oasis sends money the same day if possible using your selected method (Western Union, check or bank transfer) or the next day if it’s past the deadline (4PM CST).</span></li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading6">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse16" aria-expanded="false" aria-controls="collapse16"> What types of cases qualify? </button></h2>
                                        </div>
                                        <div id="collapse16" class="collapse " aria-labelledby="heading6" data-parent="#accordionExample1">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Many different kinds of personal injury cases qualify. <a href="/types-of-funding/#caseswefund">Learn more. </a></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading7">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse17" aria-expanded="false" aria-controls="collapse17"> Is the defendant’s insurance company notified? </button></h2>
                                        </div>
                                        <div id="collapse17" class="collapse " aria-labelledby="heading7" data-parent="#accordionExample1">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">No, the only parties aware of your transaction are you as the plaintiff, your attorney, and Oasis Financial.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="faq2" class="bg-md-info faq-section">
                    <div class="container py-3 pt-md-5 pb-md-6 position-relative">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <h2 class="h3 mb-4 d-none d-md-block">Financial</h2>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10"> <a href="#" class="h3 expander d-md-none d-block">Financial</a>
                                <div class="accordion faq expanded" id="accordionExample2">
                                    <div class="card">
                                        <div class="card-header" id="heading1">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse21" aria-expanded="false" aria-controls="collapse21"> Is good credit necessary to qualify for money? </button></h2>
                                        </div>
                                        <div id="collapse21" class="collapse " aria-labelledby="heading1" data-parent="#accordionExample2">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Your credit score is never considered in the approval process.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading2">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse22" aria-expanded="false" aria-controls="collapse22"> How long does it take to get money? </button></h2>
                                        </div>
                                        <div id="collapse22" class="collapse " aria-labelledby="heading2" data-parent="#accordionExample2">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Often you can get your money the same day your application is approved for funding. </span><span style="font-weight: 400;">The time it takes to approve funding varies based on the details of your case and the availability of your attorney. </span><span style="font-weight: 400;">On average, the application review takes about two business days from the time we speak with your attorney.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading3">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse23" aria-expanded="false" aria-controls="collapse23"> How much money can I expect to receive? </button></h2>
                                        </div>
                                        <div id="collapse23" class="collapse " aria-labelledby="heading3" data-parent="#accordionExample2">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">As a responsible financial firm, we typically limit the funding to about 10% of our estimate of potential case value ($500 to $100,000 is available — sometimes more depending on your case). This helps ensure that you receive sufficient proceeds from the settlement.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading4">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse24" aria-expanded="false" aria-controls="collapse24"> How is the money repaid? </button></h2>
                                        </div>
                                        <div id="collapse24" class="collapse " aria-labelledby="heading4" data-parent="#accordionExample2">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">The money is only paid from the proceeds of your case settlement.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading5">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse25" aria-expanded="false" aria-controls="collapse25"> What if I lose my case? </button></h2>
                                        </div>
                                        <div id="collapse25" class="collapse " aria-labelledby="heading5" data-parent="#accordionExample2">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">You keep the money and you owe nothing.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading6">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse26" aria-expanded="false" aria-controls="collapse26"> How much does it cost? </button></h2>
                                        </div>
                                        <div id="collapse26" class="collapse " aria-labelledby="heading6" data-parent="#accordionExample2">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Pricing for funding is determined by the specifics of your case. <a href="/apply-now/">Apply for free</a> and get full pricing details upon approval. Fees are competitive, and you pay nothing out of pocket — payment comes out of the settlement. You owe nothing if you don’t win your case.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="faq-section">
                    <div id="faq3" class="container py-3 pt-md-5 pb-md-6 position-relative">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <h2 class="h3 mb-4 d-none d-md-block">After You Apply</h2>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10"> <a href="#" class="h3 expander d-md-none d-block">After You Apply</a>
                                <div class="accordion faq expanded" id="accordionExample3">
                                    <div class="card">
                                        <div class="card-header" id="heading1">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse31" aria-expanded="false" aria-controls="collapse31"> What do I do after I apply? </button></h2>
                                        </div>
                                        <div id="collapse31" class="collapse " aria-labelledby="heading1" data-parent="#accordionExample3">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Once you’ve applied, there are three easy things you should do.</span></p>
                                                <ol>
                                                    <li style="font-weight: 400;"><span style="font-weight: 400;"><strong>Call your attorney. </strong>It’s important to notify your attorney of your application, as Oasis will contact them to confirm case details, sign the contract, and complete the process. </span></li>
                                                    <li style="font-weight: 400;"><span style="font-weight: 400;"><strong>Check your texts and email. </strong>Oasis will send you updates on your application status. </span></li>
                                                    <li style="font-weight: 400;"><span style="font-weight: 400;"><strong>Make sure your phone is on. </strong>Oasis will contact you when you application is approved to discuss how to transfer your funds. </span></li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading2">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse32" aria-expanded="false" aria-controls="collapse32"> What do I tell my attorney? </button></h2>
                                        </div>
                                        <div id="collapse32" class="collapse " aria-labelledby="heading2" data-parent="#accordionExample3">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Simply let them know you applied for financing with Oasis and that we will be contacting them. We ask your attorney to provide additional case details needed in the review process.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading3">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse33" aria-expanded="false" aria-controls="collapse33"> Can I apply for additional funding? </button></h2>
                                        </div>
                                        <div id="collapse33" class="collapse " aria-labelledby="heading3" data-parent="#accordionExample3">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Yes. If you have already received funding from Oasis and need more, you can apply for additional funding by completing a<a href="/additional-funding/"> free application online</a> or by phone. The additional funding process is as simple and easy as the first funding.</span></p>
                                                <p><span style="font-weight: 400;">Oasis will review any case updates or changes with you or your attorney. Oasis may reach out to you and your attorney for additional information, so make sure to provide current attorney information, phone number, and email address when applying for additional funding. </span></p>
                                                <p><span style="font-weight: 400;">If you are approved for additional funding, Oasis will notify you of the approval. You will then sign the Oasis Financial contract and your attorney will sign our acknowledgment form for the funding.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="declined">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse34" aria-expanded="false" aria-controls="collapse34"> What happens if my application is declined? </button></h2>
                                        </div>
                                        <div id="collapse34" class="collapse " aria-labelledby="heading4" data-parent="#accordionExample3">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">There are some common reasons why Oasis cannot provide funding on a case. Refer to these tips which may help..</span></p>
                                                <ol>
                                                    <li style="font-weight: 400;"><b>Your paperwork is incomplete.</b><span style="font-weight: 400;"> Make sure to properly complete all required portions of your contract. In order to provide you with funding, we need to receive signed and complete copies of paperwork from you. Make sure to check your email and phone if Oasis needs to reach you for questions or updates.</span></li>
                                                    <li style="font-weight: 400;"><b>We didn&#8217;t hear from your attorney.</b><span style="font-weight: 400;"> Make sure to let your attorney know that you have applied for funding and that we will be contacting them. In order to provide funding on your case, Oasis needs to hear from your attorney before providing you the funding.</span></li>
                                                    <li style="font-weight: 400;"><b>It&#8217;s not a case we can fund.</b><span style="font-weight: 400;"> Oasis provides funding on many different types of cases. Learn more about the types of cases Oasis can fund <a href="/types-of-funding/#caseswefund">here</a>.</span></li>
                                                    <li style="font-weight: 400;"><b>Other reasons.</b><span style="font-weight: 400;"> There may be other reasons or circumstances why Oasis has not been able to provide you with funding. Our team will provide as much information as possible and let you know when you can re-apply for funding with Oasis.</span></li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading5">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse35" aria-expanded="false" aria-controls="collapse35"> What happens after my case is settled or resolved? </button></h2>
                                        </div>
                                        <div id="collapse35" class="collapse " aria-labelledby="heading5" data-parent="#accordionExample3">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Once your case resolves, Oasis makes the process efficient and simple. We have a dedicated team of service representatives to answer questions from you or your attorney.</span></p>
                                                <p><span style="font-weight: 400;">If there is no recovery on your case, you get to keep the funds you received from Oasis. There is no risk for you. Please have your attorney contact Oasis if there is no recovery or settlement on your case. </span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading6">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse36" aria-expanded="false" aria-controls="collapse36"> Where can I get a copy of my payoff? </button></h2>
                                        </div>
                                        <div id="collapse36" class="collapse " aria-labelledby="heading6" data-parent="#accordionExample3">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">If at any time you or your attorney need a payoff, email <a href="mailto:payoffs@oasisfinancial.com">payoffs@oasisfinancial.com</a> or call <a href="tel:(888) 529-1253">(888) 529-1253</a>. Your attorney will submit payment directly to Oasis. </span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading7">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse37" aria-expanded="false" aria-controls="collapse37"> How does Oasis Financial help me get a fair settlement? </button></h2>
                                        </div>
                                        <div id="collapse37" class="collapse " aria-labelledby="heading7" data-parent="#accordionExample3">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">People who experience an injury that wasn&#8217;t their fault — people like you — often face the added insult of mounting financial problems, from lost income or costly medical bills to falling behind on rent. To make matters worse, the defendant, who may take advantage of your financial situation, is usually in no hurry to settle for fair value. Without Oasis Financial, plaintiffs might have to settle too soon for too little just to avoid bankruptcy. A cash lifeline from Oasis Financial &#8220;levels the playing field&#8221; by giving you and your attorney the time needed to negotiate a fair settlement.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="Decline">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse38" aria-expanded="false" aria-controls="collapse38"> Why was my case declined? </button></h2>
                                        </div>
                                        <div id="collapse38" class="collapse " aria-labelledby="heading8" data-parent="#accordionExample3">
                                            <div class="card-body font-size-18">
                                                <p>We know that people who are applying with Oasis have an urgent need for funding and are looking for help, quickly. We genuinely wish we could help all our applicants, but sometimes we cannot. Here are some of the most common reasons we have to decline an application.</p>
                                                <ol>
                                                    <li><strong>We do not fund in your state:</strong> In certain states, some regulations make funding difficult. As a result, we don’t currently provide funding in Arkansas, Kansas, Kentucky, Maryland, Nevada, North Carolina, or West Virginia. We continue to work with state legislators to try and make funding fast, fair and available in all states. In fact, we are founding members of <a href="http://arclegalfunding.org/">ARC</a>, the Alliance for Responsible Consumer Legal Funding, an association dedicated to preserving consumer legal funding through advocacy at the state and federal levels.</li>
                                                    <li><strong>Your case is too new</strong> – While every case is different, in general it is helpful to our underwriting process to review the case at least 30 days after the accident date. We need enough information about the accident to make a funding decision. This may include information about the defendant and their carriers, information about the damages sustained, an acceptance of liability, etc., all of which take some time after an accident to be established.</li>
                                                    <li><strong>You don’t have an attorney</strong> – We will not process a funding request unless you have an active case with a licensed attorney, and we are able to work with that attorney to determine your eligibility. Be <em>very </em>cautious if the funding company you are working with does not require the participation of your legal counsel. No one knows your case and will advocate for your best possible outcome like your attorney. If you don’t have an attorney – but would like one – Oasis may be able to help. <a href="https://www.oasisfinancial.com/need-an-attorney/">Find out more</a>.</li>
                                                    <li><strong>We want you to be satisfied at settlement</strong> – One of our goals in providing pre-settlement funding is to not only help you get money now to cover immediate needs, but to try and make sure you’re satisfied with your settlement check. Sometimes the amount you are requesting (either with a first request or based on additional requests) may mean that when your case ultimately settles, there are fewer dollars left for you to have a satisfactory outcome. Be cautious of funding companies willing to overextend funding.</li>
                                                    <li><strong>We are unable to obtain necessary information</strong> – Often applicants, in their rush for help, don’t provide accurate contact information for themselves or for their attorney. Please make sure we have your accurate information, and be on the lookout for calls, texts or emails (depending on your selected contact preferences) from us to answer any questions we may have. It’s equally important for you to you contact your attorney and tell them of your desire for funding and to give them permission to speak to us. If we don’t have the information we need, we’ll make several attempts to contact you and/or your attorney, but if we can’t gather the necessary information, we will have to decline the case.</li>
                                                    <li><strong>Your case doesn’t meet our guidelines</strong> – While your credit score is never a factor in our funding decision, other financial liabilities including bankruptcies and liens such as child support can disqualify you from funding. Once any liens are satisfied, you are welcome to reapply for funding.</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="faq4" class="bg-md-info faq-section">
                    <div class="container py-3 pt-md-5 pb-md-6 position-relative">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <h2 class="h3 mb-4 d-none d-md-block">Types of Funding</h2>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10"> <a href="#" class="h3 expander d-md-none d-block">Types of Funding</a>
                                <div class="accordion faq expanded" id="accordionExample4">
                                    <div class="card">
                                        <div class="card-header" id="heading1">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse41" aria-expanded="false" aria-controls="collapse41"> What is pre-settlement funding? </button></h2>
                                        </div>
                                        <div id="collapse41" class="collapse " aria-labelledby="heading1" data-parent="#accordionExample4">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Pre-settlement funding is a cash advance from your legal settlement. It’s a safe, risk-free payment we offer you based on what your case is worth. You agree to pay back the amount plus fees and interest once the case settles. Because all repayment comes from your settlement, there’s no risk if you don’t win your case. You can use this money to give yourself breathing room to pay bills, stay current, and get back to your life. Find out <a href="https://www.oasisfinancial.com/how-it-works/">how it works.</a></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading2">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse42" aria-expanded="false" aria-controls="collapse42"> What are structured settlements? </button></h2>
                                        </div>
                                        <div id="collapse42" class="collapse " aria-labelledby="heading2" data-parent="#accordionExample4">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Plaintiffs in a structured settlement have been offered smaller regular payments over time, instead of a large one-time payment at the end of a case. <a href="https://www.oasisfinancial.com/structured-settlement-application-form/">Learn how Oasis can help. </a></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading3">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse43" aria-expanded="false" aria-controls="collapse43"> What is inheritance funding? </button></h2>
                                        </div>
                                        <div id="collapse43" class="collapse " aria-labelledby="heading3" data-parent="#accordionExample4">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Inheritance funding is an advance against money you have been granted but is currently tied up in probate.<a href="https://www.oasisfinancial.com/inheritance-funding/"> Learn more about how Oasis can help. </a></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="faq-section">
                    <div id="faq5" class="container py-3 pt-md-5 pb-md-6 position-relative">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <h2 class="h3 mb-4 d-none d-md-block">Case Types</h2>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10"> <a href="#" class="h3 expander d-md-none d-block">Case Types</a>
                                <div class="accordion faq expanded" id="accordionExample5">
                                    <div class="card">
                                        <div class="card-header" id="autoaccidents">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse51" aria-expanded="false" aria-controls="collapse51"> Auto and Motor Vehicle Accidents <small> (includes Passenger Injury)</small> </button></h2>
                                        </div>
                                        <div id="collapse51" class="collapse " aria-labelledby="heading1" data-parent="#accordionExample5">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Ranging from fender benders to t-bone collisions, auto accidents are commonly the result of negligent driving. Motorists who are distracted, aggressive, or under the influence can cause major damage, and may be held responsible for a plaintiff’s medical bills, prescription drug costs, and compensation for lost wages. These cases involve everything from small passenger cars to large semi-trucks, and can include both injured drivers and passengers. </span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="workerscomp">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse52" aria-expanded="false" aria-controls="collapse52"> Workers' Compensation </button></h2>
                                        </div>
                                        <div id="collapse52" class="collapse " aria-labelledby="heading2" data-parent="#accordionExample5">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Workers&#8217; Compensation laws were created to protect injured workers by providing for medical care, compensation for lost wages related to the injury, and rehabilitation and/or retraining if necessary. Almost half of all workplace injuries are serious enough to cause the employee to miss work or require ongoing medical care. </span><span style="font-weight: 400;"><br /> </span><span style="font-weight: 400;"><br /> </span><span style="font-weight: 400;">Because paying these claims can be costly, employers don’t always believe they are legitimate, creating undue delays in resolving them. Plaintiffs are responsible for proving the employer was “at fault” in order to receive a settlement. </span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading3">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse53" aria-expanded="false" aria-controls="collapse53"> Civil Rights </button></h2>
                                        </div>
                                        <div id="collapse53" class="collapse " aria-labelledby="heading3" data-parent="#accordionExample5">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Civil rights claims can result from a wide variety of discriminatory misconduct, including misconduct regarding age, disability, pregnancy, race, and religious discrimination — as well as different types of harassment charges. While the actions prompting these claims may not leave a person with a physical injury, they can cause significant stress and psychological damage for the claimant, making it difficult to perform at one’s fullest potential, resulting in a lack of career momentum and missed financial gain. </span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading4">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse54" aria-expanded="false" aria-controls="collapse54"> Construction Negligence </button></h2>
                                        </div>
                                        <div id="collapse54" class="collapse " aria-labelledby="heading4" data-parent="#accordionExample5">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Construction negligence claims stem from accidents caused by unsafe construction sites, improper equipment and/or training, faulty machinery, and other dangerous work conditions. For construction workers injured on the job, employers may be held responsible for </span><span style="font-weight: 400;">a plaintiff’s medical bills, prescription drug costs, and compensation for lost wages. </span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading5">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse55" aria-expanded="false" aria-controls="collapse55"> FELA (Railroad) </button></h2>
                                        </div>
                                        <div id="collapse55" class="collapse " aria-labelledby="heading5" data-parent="#accordionExample5">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Similar to Workers&#8217; Compensation, the Federal Employer’s Liability Act (FELA) provides compensation for railroad workers injured on the job. Almost any worker employed by a railroad company, even those whose primary responsibilities are not performed in or around trains, is protected under the FELA.</span></p>
                                                <p><span style="font-weight: 400;">The degree of negligence the plaintiff must show under FELA (usually due to the railroad, its employees, or an equipment manufacturer) is actually less than “no fault” Workers&#8217; Comp. However, FELA requires a higher burden of proof by the courts than Workers&#8217; Comp, so FELA litigation can last much longer.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading6">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse56" aria-expanded="false" aria-controls="collapse56"> General Negligence </button></h2>
                                        </div>
                                        <div id="collapse56" class="collapse " aria-labelledby="heading6" data-parent="#accordionExample5">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">When a plaintiff becomes injured due to improper care of property and/or possessions, they can pursue a General Negligence lawsuit. These claims cover a broad range of specific complaints including animal bites, amusement park injuries, bicycle and pedestrian accidents, plus homeowner and nursing home negligence. </span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading7">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse57" aria-expanded="false" aria-controls="collapse57"> Jones Act (Maritime) </button></h2>
                                        </div>
                                        <div id="collapse57" class="collapse " aria-labelledby="heading7" data-parent="#accordionExample5">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">The Jones Act protects maritime workers involved in accidents while at work. Sailors can receive damages due to vessel, captain, or crew negligence. Claimants must prove that their employers were negligent or “at fault,” similar to Workers&#8217; Comp cases. </span><span style="font-weight: 400;"><br /> </span><span style="font-weight: 400;"><br /> </span><span style="font-weight: 400;">However, “comparative fault” is involved here. If the employer can prove that the plaintiff’s actions contributed to or caused the accident, the amount of the award can be reduced accordingly.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading8">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse58" aria-expanded="false" aria-controls="collapse58"> Pedestrian Injury </button></h2>
                                        </div>
                                        <div id="collapse58" class="collapse " aria-labelledby="heading8" data-parent="#accordionExample5">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">Pedestrian injury is very common, and can occur due to unsafe conditions or collisions with motor vehicles, motorcycles, bicycles, scooters, or skateboards. Injuries caused through another party’s negligence can result in compensation for </span><span style="font-weight: 400;">a plaintiff’s medical bills, prescription drug costs, and lost wages. </span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="negligence">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse59" aria-expanded="false" aria-controls="collapse59"> Premises Negligence (Slip and Fall) </button></h2>
                                        </div>
                                        <div id="collapse59" class="collapse " aria-labelledby="heading9" data-parent="#accordionExample5">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">If you were injured on another’s property and the property owner failed to warn you of the possible hazard, the owner may be found negligent and liable. Premise liability lawsuits encompass a wide range of accidents, but “slip and fall” cases are the most common.</span></p>
                                                <p>T<span style="font-weight: 400;">his type of injury can occur on private or public property and can be caused by uneven or cracked sidewalks, poorly lit pathways, slippery or unbalanced floors, potholes, ripped carpet or rugs, and even bad weather.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading10">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse510" aria-expanded="false" aria-controls="collapse510"> Workplace Negligence </button></h2>
                                        </div>
                                        <div id="collapse510" class="collapse " aria-labelledby="heading10" data-parent="#accordionExample5">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">A job-related injury is typically covered by Workers&#8217; Comp insurance. However, if the injury involved negligence on the part of the employer, a fellow employee or a product, tool or machine produced by a third party, a workplace negligence lawsuit may be filed. These are often handled outside of the state-specific Workers&#8217; Comp “no-fault” claims process. </span><span style="font-weight: 400;"><br /> </span><span style="font-weight: 400;"><br /> </span><span style="font-weight: 400;">Since these cases are not considered “no fault,” it is the claimant’s burden to prove that the other party is liable. </span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading11">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse511" aria-expanded="false" aria-controls="collapse511"> Wrongful Death </button></h2>
                                        </div>
                                        <div id="collapse511" class="collapse " aria-labelledby="heading11" data-parent="#accordionExample5">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">The loss of a loved one caused by the actions or negligence of someone else can result in a Wrongful Death suit. These claims most commonly entail medical malpractice, fatal car accidents, or when a victim is intentionally killed, and are filed by representatives of the victim’s estate. </span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading12">
                                            <h2 class="mb-0"> <button class="btn btn-link font-weight-bold font-family-sans-serif" type="button" data-toggle="collapse" data-target="#collapse512" aria-expanded="false" aria-controls="collapse512"> What is an “at fault” case? </button></h2>
                                        </div>
                                        <div id="collapse512" class="collapse " aria-labelledby="heading12" data-parent="#accordionExample5">
                                            <div class="card-body font-size-18">
                                                <p><span style="font-weight: 400;">In many personal injury cases, a plaintiff must be able to prove that the defendant was “at fault” or responsible for the accident or negligence causing the injury. The burden of proof is typically placed on the plaintiff in order to receive damages.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <a href="#" class="top">Back to top</a>
            </div>
            <div class="section pt-5 pt-md-6 pb-md-7 bg-light">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col text-center px-3 px-md-3">
                            <h2 class="h3 mb-4">We&#8217;re Here to Help!</h2>
                            <p>If you still have questions, call us toll-free at <a href="tel:877.333.6680">(877) 333-6680</a> or <a href="https://www.oasisfinancial.com/contact-us/">send us a message</a>.</p>
                            <p>Ready to get started? Apply for free in just seconds.</p>
                            <div class="bg-white shadow pt-4 pt-md-5 pb-3 pl-md-6 pr-md-5 mt-4 mt-md-5">
                                <div class='gf_browser_gecko gform_wrapper' id='gform_wrapper_1'>
                                    <div id='gf_1' class='gform_anchor' tabindex='-1'></div>
                                    <form method='post' enctype='multipart/form-data' id='gform_1' action='/#gf_1'>
                                        <div class="col-md-12">
                                            <div class="row pb-3">
                                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                                    <strong>All fields required</strong>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="gfield_label" for="exampleFormControlInput1">First Name<span class='gfield_required'>*</span></label>
                                                        <input type="text" class="form-control" autocomplete="off" id="exampleFormControlInput1">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="gfield_label" for="exampleFormControlInput1">Last Name<span class='gfield_required'>*</span></label>
                                                        <input type="text" class="form-control" autocomplete="off" id="exampleFormControlInput1">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="gfield_label" for="exampleFormControlInput1">Email<span class='gfield_required'>*</span></label>
                                                        <input type="email" class="form-control" autocomplete="off" id="exampleFormControlInput1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="gfield_label" for="exampleFormControlInput1">Phone<span class='gfield_required'>*</span></label>
                                                        <input type="tel" class="form-control" autocomplete="off" id="exampleFormControlInput1">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="gfield_label" for="exampleFormControlInput1">ZIP Code<span class='gfield_required'>*</span></label>
                                                        <input type="text" class="form-control" autocomplete="off" id="exampleFormControlInput1">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="gfield_label" for="exampleFormControlInput1">Law Firm Name<span class='gfield_required'>*</span></label>
                                                        <input type="text" class="form-control" autocomplete="off" id="exampleFormControlInput1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="gfield_label" for="exampleFormControlInput1">Attorney’s Name<span class='gfield_required'>*</span></label>
                                                        <input type="tel" class="form-control" autocomplete="off" id="exampleFormControlInput1">
                                                        <label class="gfield_label" for="exampleFormControlInput1">First</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="gfield_label" for="exampleFormControlInput1"></label>
                                                        <input type="text" class="form-control" autocomplete="off" id="exampleFormControlInput1">
                                                        <label class="gfield_label" for="exampleFormControlInput1">Last</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="gfield_label" for="exampleFormControlInput1">Law Firm Phone<span class='gfield_required'>*</span></label>
                                                        <input type="text" class="form-control" autocomplete="off" id="exampleFormControlInput1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                                    <button type="submit" class="gform_button button">
                                                        Continue
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div> <iframe style='display:none;width:0px;height:0px;' src='about:blank' name='gform_ajax_frame_1' id='gform_ajax_frame_1' title='Ajax Frame'>This iframe contains the logic required to handle Ajax powered Gravity Forms.</iframe>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link media="all" href="{{asset('mod/css/faq.css')}}" rel="stylesheet" />
@endsection