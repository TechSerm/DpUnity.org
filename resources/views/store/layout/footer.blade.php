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

    .social-links i {
        font-size: 30px;
        margin-right: 5px;
        color: var(--theme-color);
    }
</style>
<div id="footerArea">
    <footer class="">

        
        
        <div class="footerBlock text-center">
            <div class="container" >
                স্বত্ব © 2024 <a href="">দৌলতপুর প্রবাসী সামাজিক সংগঠন</a> - সর্ব স্বত্ব সংরক্ষিত<br/>
                {{-- কারিগরি সহায়তায়: <b><a href="https://bibisena.com">বিবিসেনা অনলাইন শপ</a></b> --}}
            </div>
        </div>

    </footer>
</div>
{!! theme()->customFooterCode() !!}
