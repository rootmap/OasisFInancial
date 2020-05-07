<footer id="footer" class="bg-secondary text-white pt-5 pt-md-6">
    <div class="container">
        <div class="row justify-content-between no-gutters">
            <div class="col-md-3 pt-md-2"> 
                <img src="{{asset('mod/images/Oasis-logo-white.png')}}" alt="Oasis Financial" class="img-fluid m-auto d-block d-md-inline" style="max-width:150px;">
            </div>
            <div class="col-md-5 pl-md-0 d-none d-md-block">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <div class="nav footerNav">
                            <ul>
                                <li class="nav-item"><a href="/how-it-works/" class="nav-link">How It Works</a></li>
                                <li class="nav-item"><a href="/types-of-funding/" class="nav-link">Types of Funding</a></li>
                                <li class="nav-item"><a href="/about-oasis/" class="nav-link">About Oasis</a></li>
                                <li class="nav-item"><a href="/library/" class="nav-link">Resources</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="nav footerNav">
                            <ul>
                                <li class="nav-item"><a href="/for-attorneys/" class="nav-link">For Attorneys</a></li>
                                <li class="nav-item"><a href="/for-brokers/" class="nav-link">For Brokers</a></li>
                                <li class="nav-item"><a href="/faq/" class="nav-link">FAQ <span style="width:50px; display:inline-block;"></span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="nav footerNav">
                            <ul>
                                <li class="nav-item"><a href="/contact-us/" class="nav-link">Contact Us</a></li>
                                <li class="nav-item"><a href="/about-oasis/careers/" class="nav-link">Careers</a></li>
                                <li class="nav-item d-none d-sm-inline-block">
                                    <a href="http://localhost/oasisfinancial/es/" class="nav-link">
                                        <img style="max-width:115px; height:auto;" src="{{asset('mod/images/ESP_footer.png')}}" alt="Español" />
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 pl-md-5">
                <div class="container-fluid logins">
                    <div class="row text-center">
                        <div class=" col-3 col-md-6"> 
                            <a href="#" target="_blank"> 
                                <img src="{{asset('mod/images/digicert-reviews1-1.png')}}" alt="DIGI CERT" style="width:auto !important; height:35px !important;"> 
                            </a>
                        </div>
                        <div class="col-3 col-md-6"> 
                            <a href="https://westernunion.com/locations/" target="_blank"> 
                                <img src="{{asset('mod/images/loader.png')}}" data-lazy-src="{{asset('mod/images/WU_LOGO_PRIM_ST_R_BL_RGB-1.png')}}" alt="Western union" style="width:auto !important;" class="d-none d-md-block"> 
                                <img src="{{asset('mod/images/loader.png')}}" data-lazy-src="{{asset('mod/images/WU_LOGO_PRIM_ST_BL_RGB.png')}}" alt="Western union" style="width:auto !important;" class="d-md-none"> 
                            </a>
                        </div>
                        <div class="col-3 col-md-6"> 
                            <a href="http://arclegalfunding.org/" target="_blank"> 
                                <img src="{{asset('mod/images/loader.png')}}" data-lazy-src="{{asset('mod/images/ARC-LOGO-PNG_WHT.png')}}" alt="ARC LOGGO" style="width:70px !important;"> 
                            </a>
                        </div>
                        <div class="col-3 col-md-6"> 
                            <a href="https://www.bbb.org/us/il/rosemont/profile/financial-services/oasis-financial-0654-33003199#bbbonlineclick" target="_blank"> 
                                <img src="{{asset('mod/images/loader.png')}}" data-lazy-src="{{asset('mod/images/BBB-A-rating.png')}}" alt="BBB A rating" style="width:80px !important;"> 
                            </a>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="trustpilot-widget" data-locale="en-US" data-template-id="5419b732fbfb950b10de65e5" data-businessunit-id="5bdc94abfbd6140001fa449c" data-style-height="24px" data-style-width="100%" data-theme="dark"> <a href="https://www.trustpilot.com/review/oasisfinancial.com" target="_blank">Trustpilot</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 mt-md-6">
            <div class="col">
                <p class="footer-copyright mb-0 py-3 text-center text-md-left border-top border-white d-block"> 
                    <small>&copy;
                        2020 Oasis Financial. All Rights Reserved. <br class="d-md-none"> 
                        <a href="/for-brokers/" class="d-sm-none border-right border-1 pr-1 mr-1 text-white">For Brokers</a> 
                        <a class="border-right border-1 pr-1 mr-1 text-white" href="http://localhost/oasisfinancial/terms-of-use/">Terms of Use</a> 
                        <a class="border-right border-1 pr-1 mr-1 text-white" href="http://localhost/oasisfinancial/privacy-policy/">Privacy Policy</a> 
                        <a class="border-right border-1 pr-1 mr-1 text-white" href="http://localhost/oasisfinancial/state-specific-licenses/">State-specific Licenses</a> 
                        <a class="text-white" href="/sitemap/">Sitemap</a> 
                        <a class="text-white d-block d-sm-none" href="http://localhost/oasisfinancial/es/" class="nav-link">
                            <img style="max-width:115px; height:auto;" src="{{asset('mod/images/ESP_footer.png')}}" alt="Español" />
                        </a> 
                    </small>
                </p>
            </div>
        </div>
</footer>

<script type="text/javascript">
    function showhide_toggle(e, t, r, g) {
        var a = jQuery("#" + e + "-link-" + t),
            s = jQuery("a", a),
            i = jQuery("#" + e + "-content-" + t),
            l = jQuery("#" + e + "-toggle-" + t);
        a.toggleClass("sh-show sh-hide"), i.toggleClass("sh-show sh-hide").toggle(), "true" === s.attr("aria-expanded") ? s.attr("aria-expanded", "false") : s.attr("aria-expanded", "true"), l.text() === r ? (l.text(g), a.trigger("sh-link:more")) : (l.text(r), a.trigger("sh-link:less")), a.trigger("sh-link:toggle")
    }
</script>

<script defer src="{{asset('mod/js/autoptimize_204af37c341b097539214fe21c9dbae0.js')}}"></script>