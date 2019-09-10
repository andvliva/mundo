<?php 
    global $post;
    $post_id = $post->ID;
    
    $min_group = excursion_get_price_min( $post_id, 'group' );
    $min_private = excursion_get_price_min( $post_id, 'private' );

?>
<div class="wrapper-price">
    <script>
        var excursion_ajaxurl = '<?php echo admin_url('admin-ajax.php')?>';
        var group_min_date = '<?php echo date('Y-m-d', $min_group['t'])?>';
        var private_min_date = '<?php echo date('Y-m-d', $min_private['t'])?>';
    </script>
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <?php
                $active_tab = $min_group['p'] ? 'group' : 'private';
            ?>
            <?php if(!empty($min_group['p'])){?>
                <li role="presentation " class="<?php echo $active_tab == 'group' ? 'active' : '' ?> excursion-group-detail">
                    <a href="#price-group" aria-controls="price-group" role="tab" data-toggle="tab" class="et_smooth_scroll_disabled">
                        <div class="head-list-rate-ex">   
                            <span class="title"><?php echo __('Group','Mundo')?></span>
                            <span class="star-ex"><?php echo __('From','Mundo');?> : <b>$<?php echo $min_group['p']; ?></b> pp</span>    
                        </div>
                        <div class="star-list-rate-ex">
                            <?php 
                                $type_rate = 'reviews_group';
                                $star_rate_equal = get_rate_star_avg($post->ID,$type_rate);
                                echo $star_rate_equal['star_html'].' ('.$star_rate_equal['count'].')';
                            ?>
                        </div>
                        
                    </a>
                </li>
            <?php } ?>
            <?php if(!empty($min_private['p'])){?>
            <li role="presentation " class="<?php echo $active_tab == 'private' ? 'active' : '' ?> excursion-private-detail">
                <a href="#price-private" aria-controls="price-private" role="tab" data-toggle="tab" class="et_smooth_scroll_disabled">
                    <div class="head-list-rate-ex">    
                        <span class="title"><?php echo __('Private','Mundo')?></span>
                        <span class="star-ex"><?php echo __('From','Mundo');?> : <b>$<?php echo $min_private['p']; ?></b> pp</span>    
                    </div>
                    <div class="star-list-rate-ex">
                        <?php 
                            $type_rate = 'reviews_private';
                            $star_rate_equal = get_rate_star_avg($post->ID,$type_rate);
                            echo $star_rate_equal['star_html'].' ('.$star_rate_equal['count'].')';
                        ?>
                    </div>
                </a>
            </li>
            <?php } ?>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <?php if(!empty($min_group['p'])){?>
                <div role="tabpanel" class="tab-pane <?php echo $active_tab == 'group' ? 'active' : '' ?>" id="price-group">
                    <?php
                        set_query_var('tab', 'group');
                        set_query_var('min_price', $min_group['p']);
                        get_template_part('excursion/price-box-tab');
                    ?>
                </div>
            <?php } ?>
            <?php if(!empty($min_private['p'])){?>
                <div role="tabpanel" class="tab-pane <?php echo $active_tab == 'private' ? 'active' : '' ?>" id="price-private">
                    <?php
                        set_query_var('tab', 'private');
                        set_query_var('min_price', $min_private['p']);
                        get_template_part('excursion/price-box-tab');
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>