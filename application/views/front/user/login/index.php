<section class="page-section color get_into">

    <div class="container" id="login">

        <div class="row margin-top-0">

            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">

                <div class="logo_top">

                    <a href="<?php echo base_url()?>">

                    	<img class="img-responsive" src="<?php echo $this->crud_model->logo('home_bottom_logo'); ?>" alt="Shop" style="z-index:200">

                    </a>

                </div>

                <?php

                    echo form_open(base_url() . 'home/login/do_login/', array(

                        'class' => 'form-login',

                        'method' => 'post',

                        'id' => ''

                    ));

                    $fb_login_set = $this->crud_model->get_type_name_by_id('general_settings','51','value');

                    $g_login_set = $this->crud_model->get_type_name_by_id('general_settings','52','value');

                ?>

                    <div class="row box_shape">

                        <div class="title">

                            <?php echo "translate('sign_in')";?>

                            <div class="option">

                            	<?php echo translate('not_a_member_yet_?');?>

                                <a href="<?php echo base_url(); ?>home/login_set/registration"> 

                                    <?php echo translate('sign_up_now!');?>

                                </a>

                            </div>

                        </div>

                        <hr>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="form-group">

                                <input class="form-control" type="email" name="email" placeholder="<?php echo translate('email');?>">

                            </div>

                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="form-group">

                                <input class="form-control" type="password" name="password" placeholder="<?php echo translate('password');?>">

                            </div>

                        </div>

                        

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right pull-right">

                            <span class="forgot-password" style="cursor:pointer;" onClick="set_html('login','forget')">

                                <?php echo translate('forget_your_password_?');?>

                            </span>

                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <span class="btn btn-theme-sm btn-block btn-theme-dark pull-right login_btn enterer">

                                <?php echo translate('login');?>

                            </span>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

    


</section>


<style>

.g-icon-bg {

background: #ce3e26;

}

.g-bg {

background: #de4c34;

height: 37px;

margin-left: 41px;

width: 166px;

}

</style>