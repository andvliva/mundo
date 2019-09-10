<?php
    $current_lang =  pll_current_language();
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    switch ($current_lang) {
        case 'en':
            setlocale(LC_TIME, 'us_US');
            break;
        case 'es':
            setlocale(LC_TIME, 'es_ES');
            break;
        case 'pt':
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            break;

    }
    $post_id = get_query_var('post_id', 0);
    $tab = get_query_var('tab', 'group');
    $min_price = get_query_var('min_price', 0);
    $meta = get_query_var('meta', array());
    $full_date = get_query_var("full_date_{$tab}", '');
    $max_date = get_query_var("max_date_{$tab}", '');
    
    $time_default = time() + 86400;
    
    $day_text = array(
        'monday' => __('Monday','Mundo'),'tuesday' => __('Tuesday','Mundo'),'wednesday' => __('Wednesday','Mundo'),'thursday' => __('Thursday','Mundo'),'friday' => __('Friday','Mundo'),'saturday' => __('Saturday','Mundo'),'sunday' => __('Sunday','Mundo')
    );
    $departure_date = (array)$meta[$tab]['departure_date'];
    $day_num = array(
        'monday' => 1,'tuesday' => 2,'wednesday' => 3,'thursday' => 4,'friday' => 5,'saturday' => 6,'sunday' => 0
    );
    $daily = get_post_meta($post_id,'daily_'.$tab,true);

    $day_enable = array_map( function( $txt ) use ($day_num) {
        return isset( $day_num[$txt] ) ? $day_num[$txt] : $txt;
    }, $departure_date );

    if ($daily) {
        $day_enable = array(1,2,3,4,5,6,0);
    }

    $time_default = excursion_get_default_date( $time_default, $full_date, $max_date, $day_enable );
?>
<div class="row <?php echo $tab . ' ' . $post_id?>">
    <div class="col-md-6 rate-left">
        <div class="item-excursion-rate row">
            <div class="lb col-md-4"><i class="fa fa-tag"></i><?php echo __('Price','Mundo')?>: </div>
            <div class="text col-md-8">
                <?php
                    if($tab == 'group') {
                        echo '$'.$min_price .'/'.__('person','Mundo');
                    }
                    elseif($tab == 'private') {
                        $price_detail = excursion_private_price_detail($post_id);
                        echo implode('<br>', $price_detail);
                    }
                ?>
            </div>
        </div>
        <div class="item-excursion-rate row">
            <div class="lb col-md-4"><i class="fa fa-comment"></i><?php echo __('Language','Mundo')?>: </div>
            <div class="text col-md-8"><?php echo $meta[$tab]['language'] ?></div>
        </div>
        <?php if ($tab=='group') {?>        
            <div class="item-excursion-rate row">
                <div class="lb col-md-4"><i class="fa fa-calendar-o"></i><?php echo __('Departure date','Mundo')?>: </div>
                <div class="text col-md-8"><?php
                    if( !empty( $departure_date ) && !$daily) {
                        echo implode(', ', array_map( function( $txt ) use ($day_text) {
                            return $day_text[$txt];
                        }, $departure_date ) );
                    }elseif( $daily ){
                        echo __('Daily','Mundo');
                    }
                ?></div>
            </div>
        <?php    } ?>
        <div class="item-excursion-rate row">
            <div class="lb col-md-4"><i class="fa fa-clock-o"></i><?php echo __('Departure time','Mundo')?>: </div>
            <div class="text col-md-8"><?php echo $meta[$tab]['departure_time'] ?></div>
        </div>
        <?php if($meta[$tab]['accomodation']){?>
            <div class="item-excursion-rate row">
                <div class="lb col-md-4"><i class="fa fa-hospital-o"></i><?php echo __('Accommodation','Mundo')?>: </div>
                <div class="text col-md-8"><?php echo $meta[$tab]['accomodation'] ?></div>
            </div>
        <?php }?>
        <div class="item-excursion-rate row">
            <div class="lb col-md-4"><i class="fa fa-bus"></i><?php echo __('Pick-up point','Mundo')?>: </div>
            <div class="text col-md-8"><?php echo $meta[$tab]['pick_up_point'] ?></div>
        </div>
        <p class="over-rate">
            <?php echo $meta[$tab]['over_rate'] ?>
        </p>
    </div>
    <div class="col-md-6 rate-right">
        <p class="text-head"><?php echo __('Select participants','Mundo'); ?></p>
        <form class="price-box-form">
            <?php wp_nonce_field( "price-{$tab}" ); ?>
            <input type="hidden" name="action" value="excurtion_step1" />
            <input type="hidden" name="tab" value="<?php echo $tab?>" />
            <input type="hidden" name="post_id" value="<?php echo $post_id?>" />

            <script>
                var full_date_<?php echo $tab?> = <?php echo json_encode( array_values($full_date) );?>;
                var max_date_<?php echo $tab?> = '<?php echo $max_date?>';
                var day_enable_<?php echo $tab?> = <?php echo json_encode( array_values($day_enable) );?>;
            </script>

            <div class="participants dropdown excursion-choose">
                <div class="participants-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="padult"><?php echo __('Adult','Mundo')?> x <span>2</span> </span>
                    <span class="pyouth " style="display: none;">, <?php echo __('Youth','Mundo')?> x <span>0</span>, </span>
                    <span class="pchildren" style="display: none;"><?php echo __('Children','Mundo')?> x <span>0</span>, </span>
                    <span class="pinfant" style="display: none;"><?php echo __('Infant','Mundo')?> x <span>0</span></span>
                </div>
                <div class="dropdown-menu excursion-choose-dropdown" aria-labelledby="dLabel">
                    <div class="row participants-input">
                        <div class="col-md-7"><?php echo __('Adult','Mundo')?><span>(<?php echo __('Age 12+','Mundo');?>) <?php if($tab=='group'){echo __('- minimum of 2 participants','Mundo');}?></span></div>
                        <div class="col-md-5">
                            <a class="btn-minus"><i class="fa fa-minus"></i></a>
                            <input type="text" size="1" readonly="" name="adult" value="2"  />
                            <a class="btn-plus"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row participants-input">
                        <div class="col-md-6"><?php echo __('Youth','Mundo')?><span>(<?php echo __('Age 8 - 11','Mundo');?>)</span></div>
                        <div class="col-md-6">
                            <a class="btn-minus"><i class="fa fa-minus"></i></a>
                            <input type="text" size="1" readonly="" name="youth" value="0"  />
                            <a class="btn-plus"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row participants-input">
                        <div class="col-md-6"><?php echo __('Children','Mundo');?><span>(<?php echo __('Age 4 - 7','Mundo');?>)</span></div>
                        <div class="col-md-6">
                            <a class="btn-minus"><i class="fa fa-minus"></i></a>
                            <input type="text" size="1" readonly="" name="children" value="0"  />
                            <a class="btn-plus"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row participants-input">
                        <div class="col-md-6"><?php echo __('Infant','Mundo')?><span>(<?php echo __('Age <3','Mundo');?>)</span></div>
                        <div class="col-md-6">
                            <a class="btn-minus"><i class="fa fa-minus"></i></a>
                            <input type="text" size="1" readonly="" name="infant" value="0"  />
                            <a class="btn-plus"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($tab=='private') {?> 
                <p class="text-head"><?php echo __('Select travel date','Mundo'); ?></p>
            <?php } ?>
            <div class="check-in-date">
                <div class="price-datepicker <?php echo $tab;?>"></div>
                <input type="hidden" name="check_in_date" value="<?php echo $time_default ? date('Y-m-d', $time_default) : '';?>" />
            </div>
            <div class="book-info infomation-booking">
                <div class="row">
                    <div class="col-md-6">
                        <div class="label-depart"><?php echo __('Departure','Mundo');?></div>
                        <div class="departure-date"><?php echo $time_default ?utf8_encode( strftime( '%a %d  %B %Y', $time_default )) : '';
                        //date('l d F Y', $time_default)?></div>
                        <div class="clear-both"></div>
                    </div>
                    <div class="col-md-6 price-detail">
                        
                    </div>
                    <hr />
                    <div class="col-md-12 price-total">
                        
                    </div>
                </div>
            </div>
            <div class="book-info wrapper-book_now">
                <button type="button" <?php echo $time_default ?: 'disabled' ?> name="book_now" class="btn book_now make-enquire"><?php echo __('Book now','Mundo');?></button>
            </div>
        </form>
    </div>
</div>