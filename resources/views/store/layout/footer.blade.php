<style>
    footer {
        margin-top: 100px;
        background: #ffffff;
        border-top: 1px solid #e9ecef;
    }

    .footerBlock {
        border-bottom: 1px solid #f3f4f5;
        padding: 15px 0px 15px 0px;
    }

    .intro-icon i {
        width: 50px;
        height: 50px;
        font-size: 18px;
        line-height: 43px;
        border-radius: 50%;
        text-align: center;
        display: inline-block;
        float: left;
        margin-right: 10px;
        color: var(--theme-color);
        background: var(--white);
        border: 3px double var(--theme-color);
        -webkit-box-shadow: var(--primary-bshadow);
        box-shadow: var(--primary-bshadow);
        transition: all linear .3s;
        -webkit-transition: all linear .3s;
        -moz-transition: all linear .3s;
        -ms-transition: all linear .3s;
        -o-transition: all linear .3s;
    }

    .intro-content p {
        font-size: 14px;
    }

    .intro-icon i:hover {
        background: var(--theme-color);
        color: var(--theme-font-color)
    }

    .intro-content h5 {
        font-size: 17px;
        margin-bottom: 3px;
        text-transform: capitalize;
    }

    .footer-link {
        margin-bottom: 10px;
        font-size: 15px;
    }

    .footer-link i {
        font-size: 22px;
        margin-right: 5px;
        color: var(--theme-color);
    }

    .footer-title {
        color: var(--theme-color);
        margin-bottom: 20px;
    }

    .social-links i{
        font-size: 30px;
        margin-right: 5px;
        color: var(--theme-color);
    }
</style>
<div id="footerArea">
    <footer class="">

        <section class="intro-part" style="padding: 30px 0px 15px 0px;  border: 1px solid #eeeeee; background: #F8FFFA">
            <div class="container">
                <div class="row g-0">
                    <div class="col-sm-6 col-lg-3 pr-0 mt-2">
                        <div class="intro-wrap">
                            <div class="intro-icon">
                                <i class="fas fa-thumbs-up"></i>
                            </div>
                            <div class="intro-content">
                                <h5>হাই-কোয়ালিটি পণ্য</h5>
                                <p>Enjoy top quality items for less</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 pr-0 col-lg-3 mt-2">
                        <div class="intro-wrap">
                            <div class="intro-icon"><i class="fas fa-headset"></i></div>
                            <div class="intro-content">
                                <h5>24/7 লাইভ চ্যাট</h5>
                                <p>Get instant assistance whenever you need it</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 pr-0 mt-2">
                        <div class="intro-wrap">
                            <div class="intro-icon"><i class="fas fa-truck"></i></div>
                            <div class="intro-content">
                                <h5>এক্সপ্রেস শিপিং</h5>
                                <p>Fast &amp; reliable delivery options</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 pr-0 mt-2">
                        <div class="intro-wrap">
                            <div class="intro-icon"><i class="fas fa-lock"></i></div>
                            <div class="intro-content">
                                <h5>সিকিউর পেমেন্ট</h5>
                                <p>Multiple safe payment methods</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="footerBlock pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="{{ theme()->logo() }}" height="80px" alt=""><br>
                        <div class="mt-2">
                            {{ theme()->description() }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-widget footer-about-2 mb-30">
                            <h5 class="footer-title"><b>Contact Us</b></h5>
                            <div class="footer-info-list">
                                <div class="footer-link">
                                    <i class='fa fa-envelope'></i> {{ theme()->email() }}
                                </div>
                                <div class="footer-link">
                                    <i class='fas fa-phone'></i> {{ theme()->mobile() }}
                                </div>
                                <div class="footer-link mb-3">
                                    <i class='fas fa-map'></i> {{ theme()->address() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-widget footer-about-2 mb-30">
                            <h5 class="footer-title"><b>Quick Links</b></h5>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-widget footer-about-2 mb-30">
                            <h5 class="footer-title"><b>Our Social Page</b></h5>
                            <div class="footer-info-list social-links">
                                <a href="#"><i class="fab fa-facebook"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="footerBlock text-center theme-bg">
            <div class="container">
                Developed By: <a href="https://xotechz.com/ " style="text-decoration: none;"><b>Xotech</b></a>
            </div>
        </div>

    </footer>
</div>
{!! theme()->customFooterCode() !!}