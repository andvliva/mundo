<?php
?>
<p class="logo"><img class="aligncenter" src="/wp-content/themes/Divi-child/image/m2.png" alt="http://la-regina.liva.com.vn/wp-content/themes/Divi-child/image/m2.png" /></p>
<p class="text0">COMING SOON</p>
<p class="text1">Welcome to <strong>La Regina Cruises</strong>! </p>
<p class="text1">We’re currently working on creating something fantastic.</p>
<p class="text1">We’ll be here soon. Subscribe to be notified</p>

<div class="form">
    <form id="notify_me" method="post" action="<?php echo admin_url('admin-post.php')?>">
        <input type="hidden" name="action" value="notify_me" />
        <?php wp_nonce_field('notify_me'); ?>
        <input type="text" name="email" placeholder="ENTER YOUR EMAIL" class="email" />
        <button type="button">Notify me</button>
        <div class="message"></div>
    </form>
</div>
<div class="footer">
    <div class="copy">Website by La Regina Cruises @2018. All Right Reserved</div>
    <div class="icon">
        <span>Find us on</span>
        <a href="https://www.facebook.com/La-Regina-Cruises-932031496957262/" target="_blank"><img src="/wp-content/themes/Divi-child/image/m-facebook.png" alt="facebook" /></a>
        <a href="https://www.instagram.com/lareginacruises/" target="_blank"><img src="/wp-content/themes/Divi-child/image/m-insta.png" alt="instagram" /></a>
    </div>
</div>
<style>
@font-face {
    font-family: 'AvenirLTStd Book';
    src: url('/wp-content/themes/Divi-child/fonts/AvenirLTStd/AvenirLTStd-Book.eot');
    src: url('/wp-content/themes/Divi-child/fonts/AvenirLTStd/AvenirLTStd-Book.eot?#iefix') format('embedded-opentype'),
        url('/wp-content/themes/Divi-child/fonts/AvenirLTStd/AvenirLTStd-Book.woff2') format('woff2'),
        url('/wp-content/themes/Divi-child/fonts/AvenirLTStd/AvenirLTStd-Book.woff') format('woff'),
        url('/wp-content/themes/Divi-child/fonts/AvenirLTStd/AvenirLTStd-Book.ttf') format('truetype'),
        url('/wp-content/themes/Divi-child/fonts/AvenirLTStd/AvenirLTStd-Book.svg#AvenirLTStd-Book') format('svg');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'Assassin';
    src:url('/wp-content/themes/Divi-child/fonts/webfonts_Assassin/Assassin.ttf.woff') format('woff'),
        url('/wp-content/themes/Divi-child/fonts/webfonts_Assassin/Assassin.ttf.svg#Assassin') format('svg'),
        url('/wp-content/themes/Divi-child/fonts/webfonts_Assassin/Assassin.ttf.eot'),
        url('/wp-content/themes/Divi-child/fonts/webfonts_Assassin/Assassin.ttf.eot?#iefix') format('embedded-opentype'); 
        font-weight: normal;
        font-style: normal;
}
.wrap {
    min-width: 1170px;
}
.text0 {
    text-align: center;
    color: #b88a2d;
    font-size: 86.18px;
    padding: 50px 45px;
    font-family: 'Assassin';
    line-height: 86px;
}
.text1 {
    font-family: 'AvenirLTStd Book';
    text-align: center; color: #fff;
    font-size: 23px;
    line-height: 30px;
}
.form {
    padding-top: 80px;
    padding-bottom: 100px;
}
.form .email {
    background: transparent;
    border: 1px solid #fff;
    border-radius: 30px;
    padding: 10px 30px;
    font-size: 20px;
    width: 513px;
    display: inline-block;
    font-family: 'AvenirLTStd Book';
    outline: none;
    color: #fff;
}
.form button {
    background: transparent;
    border: 1px solid #fff;
    border-radius: 30px;
    padding: 10px 30px;
    font-size: 20px;
    color: #fff;
    text-transform: uppercase;
    display: inline-block;
    margin-left: 10px;
    font-family: 'AvenirLTStd Book';
    cursor: pointer;
    outline: none;
}
.form button:hover {
    background: #b88a2d;
    border-color: #b88a2d;
}
.message {
    font-family: 'AvenirLTStd Book';
    color: #fff;
    font-size: 20px;
    width: 600px;
    margin: 0 auto;
    margin-top: 30px;
}
.footer {
    font-family: 'AvenirLTStd Book';
    color: #fff;
    font-size: 20px;
    position: fixed;
    bottom: 0;
    width: 100%;
    left: 0;
    background: rgba(0, 0, 0, 0.2);
    padding-top: 15px;
}

.footer .copy {
    float: left;
    margin-left: 50px;
}
.footer .icon {
    float: right;
    margin-right: 50px;
}
.footer .icon a{
    display: inline-block;
    vertical-align: -webkit-baseline-middle;
    padding: 0 10px;
}
@media (max-width: 1366px) {
    .wrap {
        min-width: 100px;
        width: 95%;
        margin-top: 50px;
    }
    .wrap > h2 {
        margin-bottom: 0;
    }
    .logo img{
        max-width: 150px;
    }
    .text0 {
        font-size: 60px;
        padding: 30px 0;
        line-height: 60px;
    }
    .text1 {
        font-size: 20px;
        line-height: 25px;
    }
    .form {
        padding-top: 50px;
        
    }
    .form .message {
        margin-top: 25px;
        line-height: 25px;
        max-width: 100%;
    }
    .footer .copy {
        margin-top: 6px;
    }
    .footer .icon {
        margin-top: 5px;
    }
    .footer .icon a img {
        height: 30px;
    }
    .footer {
        padding-top: 0;
        
    }
}
@media (max-width: 768px) {
    .form .email {
        max-width: 100%;
        box-sizing: border-box;
    }
    .form button {
        margin-left: 0;
        margin-top: 10px;
    }
    .footer {
        position: static;
    }
    .footer .copy {
        float: none;
        margin-left: 0;
        text-align: center;
        padding: 0 10px 10px;
        margin-top: 0;
    }
    .footer .icon {
        float: none;
        margin-right: 0;
        text-align: center;
        margin-top: 0;
    }
    .footer .icon a img {
        height: 20px;
    }
}
</style>