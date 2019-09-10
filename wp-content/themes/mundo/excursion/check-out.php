<?php
    $transient = get_query_var('transient', array());

    $checkout_id = get_query_var('transient-id', 0);
    $post_id = $transient['post_id'];
    //print_r($post_id);exit();
    $tab = $transient['tab'];
    $departure_date = get_post_meta( $post_id, "departure_date_{$tab}" ) ?: array();

    $day_num = array(
        'monday' => 1,'tuesday' => 2,'wednesday' => 3,'thursday' => 4,'friday' => 5,'saturday' => 6,'sunday' => 0
    );
    $daily = get_post_meta($post_id,'daily_'.$tab,true);
    $day_enable = array_map( function( $txt ) use ($day_num) {
        return $day_num[$txt];
    }, $departure_date );
    if ($daily) {
        $day_enable = array(1,2,3,4,5,6,0);
    }

    
    $full_date = get_post_meta( $post_id, "_full_date_{$tab}", true ) ?: array();
    $max_date = get_post_meta( $post_id, "_max_date_{$tab}", true ) ?: '';
    if($max_date) {
        $max_date = date('Y-m-d', $max_date);
    }
    if($tab == 'private'){
        $pick_up_point = strip_tags(get_post_meta($post_id,'pick_up_point_private',true));
    }else{
        $pick_up_point = strip_tags(get_post_meta($post_id,'pick_up_point_group',true));
    }
    
?>
<script>var excursion_ajaxurl = '<?php echo admin_url('admin-ajax.php')?>';</script>
<form class="exc-checkout-form">
    <?php wp_nonce_field( "checkout-{$tab}" ); ?>
    <input type="hidden" name="action" value="excurtion_checkout" />
    <input type="hidden" name="tab" value="<?php echo $tab?>" />
    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
    <input type="hidden" name="checkout_id" value="<?php echo $checkout_id; ?>" />
    <script>
        var full_date = <?php echo json_encode( array_values($full_date) );?>;
        var max_date = '<?php echo $max_date?>';
        var day_enable = <?php echo json_encode( array_values($day_enable) );?>;
    </script>

    <div class="row info-in-checkout">
        <div class="col-md-3 row_in_mobile">
            <label class="col-md-6 col-6"><?php echo __('Departure date','Mundo')?>:</label>
            <input type="text" name="check_in_date" readonly="" value="<?php echo $transient['check_in_date']?>" class="price-datepicker checkout col-md-6 col-6" />
            <span class="mui-ten-xuong"></span>
        </div>
        <div class="col-md-6 row_in_mobile">
            <label class="col-md-3 col-6"><?php echo __('Number of travelers','Mundo')?>:</label>
            <div class="participants dropdown col-md-8 col-6">
                <div class="participants-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="padult"><?php echo __('Adult','Mundo')?> x <span><?php echo $transient['adult']?></span></span>
                    <span class="pyouth" style="display: none;">, <?php echo __('Youth','Mundo')?> x <span><?php echo $transient['youth']?></span>, </span>
                    <span class="pchildren" style="display: none;"><?php echo __('Children','Mundo')?> x <span><?php echo $transient['children']?></span>, </span>
                    <span class="pinfant" style="display: none;"><?php echo __('Infant','Mundo')?> x <span><?php echo $transient['infant']?></span></span>
                </div>
                <div class="dropdown-menu excursion-choose-dropdown" aria-labelledby="dLabel">
                    <div class="row participants-input ">
                        <div class="col-md-7"><?php echo __('Adult')?><span>(<?php echo __('Age 12+','Mundo')?>) <?php echo __('- minimum of 2 participants')?></span></div>
                        <div class="col-md-5">
                            <a class="btn-minus"><i class="fa fa-minus"></i></a>
                            <input type="text" size="1" readonly="" name="adult" value="<?php echo $transient['adult']?>"  />
                            <a class="btn-plus"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row participants-input">
                        <div class="col-md-6"><?php echo __('Youth','Mundo')?><span>(<?php echo __('Age 8 - 11','Mundo')?>)</span></div>
                        <div class="col-md-6">
                            <a class="btn-minus"><i class="fa fa-minus"></i></a>
                            <input type="text" size="1" readonly="" name="youth" value="<?php echo $transient['youth']?>"  />
                            <a class="btn-plus"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row participants-input">
                        <div class="col-md-6"><?php echo __('Children','Mundo')?><span>(<?php echo __('Age 4 - 7','Mundo')?>)</span></div>
                        <div class="col-md-6">
                            <a class="btn-minus"><i class="fa fa-minus"></i></a>
                            <input type="text" size="1" readonly="" name="children" value="<?php echo $transient['children']?>"  />
                            <a class="btn-plus"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row participants-input">
                        <div class="col-md-6"><?php echo __('Infant','Mundo')?><span>(<?php echo __('Age <3','Mundo')?>)</span></div>
                        <div class="col-md-6">
                            <a class="btn-minus"><i class="fa fa-minus"></i></a>
                            <input type="text" size="1" readonly="" name="infant" value="<?php echo $transient['infant']?>"  />
                            <a class="btn-plus"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <span class="mui-ten-xuong"></span>
        </div>
        <div class="col-md-3 row_in_mobile">
            <label class="col-md-6 col-6"><?php echo __('Duration','Mundo')?>:</label>
            <span class="col-md-6 col-6"><?php echo get_post_meta( $post_id, 'time_trip', true ) ?: '';?></span>
        </div>
    </div>
    <div class="row info-in-checkout row_in_mobile">
        <div class="col-md-3 row_in_mobile">
            <label class="col-md-6 col-6"><?php echo __('From','Mundo')?>:</label>
            <span class="col-md-6 col-6">
                <?php
                    $cat = wp_get_object_terms( $post_id, 'category-destination' );
                    $cat = wp_list_pluck( $cat, 'name' );
                    echo implode(', ', $cat);
                ?>
            </span>
        </div>
        <div class="col-md-6 row_in_mobile">
            <label class="col-md-3 col-6"><?php echo __('Total','Mundo')?>:</label>
            <span class="total-checkout col-md-8 col-6">$<?php echo $transient['total_price'] ?></span>
        </div>
        <div class="col-md-3 row_in_mobile">
            <label class="col-md-6 col-6"><?php echo __('Guide','Mundo')?>:</label>
            <?php 
                $guides = get_post_meta($post_id,'language_'.$tab,true);
            ?>
            <span class="col-md-6 col-6"><?php echo $guides;?></span>
        </div>
    </div>
    <div class="clear-both"> </div>
    <hr />
    <div class="text_center">
        <h1 class="et_pb_contact_main_title"><?php echo __('Please fill in your details below anh we will contact you within 24 to 48 hours','Mundo')?></h1>
        <div class="et_pb_contact">
            <p class="et_pb_contact_field ">
                <input type="text" id="" class="input required ex_name" value="" name="full_name" placeholder="<?php echo __('Your full name *','Mundo');?>"/>
            </p>
            <p class="et_pb_contact_field ">
                <input type="text" id="" class="input required ex_email" value="" name="email" placeholder="<?php echo __('Email address *','Mundo');?>"/>
            </p>
            <p class="et_pb_contact_field ">
                <?php 
                    if ($tab=='group') {
                        $readonly = 'readonly';
                    }
                ?>
                <textarea id="" class="input" value="" name="pick_up_point" <?php echo $readonly;?> placeholder="<?php echo __('Pick-up point','Mundo');?>" rows="6"><?php echo $pick_up_point;?></textarea>
            </p>
            <p class="et_pb_contact_field ">
                <input type="text" id="" class="input" value="" name="phone" placeholder="<?php echo __('Phone number','Mundo');?>"/>
            </p>
            <p class="et_pb_contact_field ">
                <textarea name="message" id="message" class="et_pb_contact_message input" 
                placeholder="<?php echo __('Anything else we should know?
Hotel standard, special interests, budget per person...','Mundo'); ?>" rows="6"></textarea>
            </p>
            <div class="et_contact_bottom_container">
    			<button type="button" class="et_pb_contact_submit et_pb_button book_now"><?php echo __('SEND YOUR REQUEST','Mundo');?></button>
    		</div>
        </div>
    </div>
    
</form>