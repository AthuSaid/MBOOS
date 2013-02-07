<div class="navbar navbar-fixed-top">
  <div class="navbar-inner top-nav">
    <div class="container-fluid">
      <div class="branding">
        <div class="logo"> <a href="<?php echo base_url(); ?>admin/dashboard"><img src="<?php echo base_url(); ?>template/img/logo.png" width="168" height="40" alt="Logo"></a> </div>
      </div>
      <ul class="nav pull-right">
        <li class="dropdown search-responsive"><a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="nav-icon magnifying_glass"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li class="top-search">
              <form action="#" method="get">
                <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
                  <input type="text" id="searchIcon">
                </div>
              </form>
            </li>
          </ul>
        </li>
        <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $sessVar['sadmin_uname'];?> <span class="alert-noty">25</span><i class="white-icons admin_user"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url();?>admin/profile_mboos/edit_profile/<?php echo $sessVar['sadmin_uid'] ?>"><i class="icon-pencil"></i> Edit Profile</a></li>
            <li><a href="#"><i class="icon-cog"></i> Account Settings</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>admin/login/logout"><i class="icon-off"></i><strong> Logout</strong></a></li>
          </ul>
        </li>
      </ul>
      <button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar" type="button"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>

    </div>
  </div>
</div>
<div id="main-content">
<div class="container-fluid">
		<div class="row-fluid">
			<div class="span7">
				<div class="widget-block">
					<div class="widget-head">
						<h5> Edit Item </h5>
					</div>
					<div class="widget-content">
						<div class="widget-box">
						<div id="register_msg_error">
							<?php  echo validation_errors();  ?>
						</div>
						
							<form class="form-horizontal well white-box" id="admin_login_validation" action="<?php echo base_url(); ?>admin/register" method="POST">
								<fieldset id="registration_fieldset">
								<?php foreach ($edit_items as $rec):?>
									<p id="reg_required_msg">* Required </p>
									<?php $edit_item_id = $this->uri->segment(4); ?>
									<input type="hidden" id="item_id" name="item_id" value="<?php echo $edit_item_id;?>"/>
									<div class="control-group">
										<label class="control-label" for="item_name">Item Name *</label>
										<div class="controls">
											<input type="text" class="input-xlarge text-tip" title="first tooltip" name="item_name" value="<?php echo $rec->mboos_product_name;?>" />				
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Item Description</label>
										<div class="controls">
											<textarea name="item_desc" class="input-xlarge" rows="3"><?php echo $rec->mboos_product_desc;?></textarea>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="item_supplier">Item Supplier *</label>
										<div class="controls">
											<input type="text" class="input-xlarge" name="item_supplier" value="<?php echo $rec->mboos_product_supplier;?>" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Item Category </label>
										<div class="controls">
											<select name='product_category'>
													<?php foreach ($edit_items as $row):?>
													<option selected="selected" value="<?php echo $row->mboos_product_category_id;?>">--<?php echo $row->mboos_product_category_name;?>--</option>
													<?php endforeach;?>
									
                                    				<?php foreach ($all_category as $cat):?>
													<option value="<?php echo $cat->mboos_product_category_id;?>"><?php echo $cat->mboos_product_category_name;?></option>							
													<?php endforeach;?>
													
											</select>
										</div>
									</div>
								<div class="control-group">
										<label class="control-label" for="register_answer">Item Price *</label>
										<div class="controls">
											<?php foreach ($item_price as $price):?>
												<input type="text" name="item_price" value="<?php echo $price->mboos_product_price; ?>" class="input-xlarge"  id="item_price"/>
						
											<?php endforeach;?>
											<p><a href="<?php echo base_url();?>admin/item/add_price/<?php echo $rec->mboos_product_id;?>"><br />Add new item price</a></p>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="register_answer"></label>
										<div class="controls">
											<a id="add_new_price_btn" class="btn btn-modal" data-toggle="modal" href="#myModal">Add new item Price</a>
										</div>
									</div>
										
											
												
									
									<div class="modal hide fade" id="myModal">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">�</button>
											<h3>Add New Price</h3>
										</div>
										<div class="modal-body">
											
											<div class="control-group">
											
												<label class="control-label" for="register_answer">Item Price *</label>
												<div class="controls">
							
												<input type="text" name="item_price_new" value="" class="input-xlarge"  id="item_price_new"/>
											
											</div>
									</div>
											
										</div>
										<div class="modal-footer">
											<a href="#" class="btn" data-dismiss="modal">Close</a><a href="#" data-dismiss="modal" id="addNewPrice_btn" class="btn btn-primary">Add Price</a>
										</div>
										
									</div>
												
											
										
									
									
									<div class="control-group">
										<label class="control-label" for="register_answer">Item Image*</label>
										<div class="controls">
					
									<p><img src="<?php echo site_url() . 'images/item_images/' . $rec->mboos_product_image; ?>" width="50" height="50" /></p>			
									<p><a href="<?php echo base_url();?>admin/item/upload_image/<?php echo $rec->mboos_product_name;?>"><br />Change item image</a></p>
										</div>
									</div>
									

									
									<div class="row-fluid">
										<div class="span12">
											<div class="nonboxy-widget">
												<div class="widget-head">
													<h5>Manage Orders</h5>
												</div>
												<table class="data-tbl-simple table table-bordered">
												<thead>
												<tr>
												    	<th>Item Price</th>
												        <th>Price Date</th>
												        <th>Set Price</th>
												</tr>
												</thead>
												<tbody>
												<?php foreach ($all_price as $price):?>
												    <tr>
												    	 <td><?php echo $price->mboos_product_price;?></td>
												         <td><?php echo $price->mboos_product_price_date;?></td>
												      	 <td> <input checked="checked" id="price_radio_btn" type="radio" value="<?php echo $price->mboos_product_price;?>" name="price_status"/></td>
												    </tr><?php endforeach;?>
												    <?php endforeach;?>	
												</tbody>
												</table>
											</div>
										</div>
									</div>		
										
									<div class="clearfix">
										<button  id="saveEdit_button" class="btn btn-primary login-btn" title="theme-blue" type="submit">Update</button>
									</div>
									
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
