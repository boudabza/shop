<!-- PAGE -->
<section class="page-section featured-products sl-featured">
    <div class="container">
        <h2 class="section-title section-title-lg text-truncate">
            <span>
            	<span class="thin"> <?php echo translate('latest');?></span>
                <?php echo translate('featured');?> 
                <span class="thin"> <?php echo translate('products');?></span>
            </span>
        </h2>
        <div class="featured-products-carousel">
            <div class="owl-carousel" id="featured-products-carousel">
                <?php
					$box_style =  $this->db->get_where('ui_settings',array('ui_settings_id' => 29))->row()->value;
					$limit =  $this->db->get_where('ui_settings',array('ui_settings_id' => 20))->row()->value;
                    $featured=$this->crud_model->product_list_set('featured',$limit);
                    foreach($featured as $row){
                		echo $this->html_model->product_box($row, 'grid', $box_style);
					}
                ?>
            </div>
        </div>
    </div>
</section>
<!-- /PAGE -->