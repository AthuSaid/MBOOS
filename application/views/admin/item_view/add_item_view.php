<p>Add Items</p>

<?php echo form_open_multipart('admin/item/add_item_validate');?>

<p><label>Item Name</label><input name="item_name" type="text" value="" /></p>
<p><label>Item Description</label><textarea name="item_desc" ></textarea></p>
<p><label>Item Supplier</label><input name="item_supplier" type="text" value="" /></p>
<p><label>Item Category</label><select name='product_category'>    
									<?php foreach ($category as $row):?>
									<option value="<?php echo $row->mboos_product_category_id;?>"><?php echo $row->mboos_product_category_name;?></option>
									<?php endforeach;?>
								</select>
<p><label>Item Availability</label><input name="item_availability" type="text" value="" /></p>
<p><label>Item Price</label><input name="item_price" type="text" value="" /></p>
<input name="price_date" type="text" value="" /></p>
<input name="product_id" type="text" value="" /></p>
<p><label>Item Image: <input type="file" name="item_image" size="12" /> </label></p>
<p><input name="submit" type="submit" value="Save Item" /></p>
</form>

<div name="button_back">
<form action="<?php echo base_url();?>admin/dashboard" method="POST">
<input name="button_back" type="submit" value="Back" />

</form>
</div>