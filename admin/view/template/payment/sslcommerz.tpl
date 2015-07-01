<?php echo $header; ?><?php echo $column_left; ?>
	<div id="content">
		<div class="page-header">
			<div class="container-fluid">
				<div class="pull-right">
					<button type="submit" form="form-pp-std-uk" data-toggle="tooltip"
					        title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>
					</button>
					<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
					   class="btn btn-default"><i class="fa fa-reply"></i></a></div>
				<h1><?php echo $heading_title; ?></h1>
				<ul class="breadcrumb">
					<?php foreach ( $breadcrumbs as $breadcrumb ) { ?>
						<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<div class="container-fluid">
			<?php if ( isset( $error['error_warning'] ) ) { ?>
				<div class="alert alert-danger"><i
						class="fa fa-exclamation-circle"></i> <?php echo $error['error_warning']; ?>
					<button type="button" class="close" data-dismiss="alert">&times;</button>
				</div>
			<?php } ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
				</div>
				<div class="panel-body">
					<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"
					      id="form-pp-std-uk" class="form-horizontal">
						<div class="form-group required">
							<label class="col-sm-2 control-label"
							       for="entry-username"><?php echo $text_entry_username; ?></label>

							<div class="col-sm-10">
								<input type="text" name="sslcommerz_username"
								       value="<?php echo $sslcommerz_username; ?>"
								       placeholder="<?php echo $text_entry_username; ?>" id="entry-username"
								       class="form-control"/>
								<?php if ($error_username) { ?>
									<div class="text-danger"><?php echo $error_username; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group required">
							<label class="col-sm-2 control-label"
							       for="entry-password"><?php echo $text_entry_password; ?></label>

							<div class="col-sm-10">
								<input type="text" name="sslcommerz_password"
								       value="<?php echo $sslcommerz_password; ?>"
								       placeholder="<?php echo $text_entry_password; ?>" id="entry-password"
								       class="form-control"/>
								<?php if ($error_password) { ?>
									<div class="text-danger"><?php echo $error_password; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="entry-testbox"><span data-toggle="tooltip" title="<?php echo $text_help_testbox; ?>"><?php echo $text_entry_testbox; ?></span></label>

							<div class="col-sm-10">
								<select name="sslcommerz_testbox" id="entry-testbox" class="form-control">
									<?php if ( $sslcommerz_testbox ) { ?>
										<option value="1" selected="selected"><?php echo $text_yes; ?></option>
										<option value="0"><?php echo $text_no; ?></option>
									<?php } else { ?>
										<option value="1"><?php echo $text_yes; ?></option>
										<option value="0" selected="selected"><?php echo $text_no; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="entry-total"><span data-toggle="tooltip" title="<?php echo $text_help_total; ?>"><?php echo $text_entry_total; ?></span></label>

							<div class="col-sm-10">
								<input type="text" name="sslcommerz_total"
								       value="<?php echo $sslcommerz_total; ?>"
								       placeholder="<?php echo $text_entry_total; ?>" id="entry-total"
								       class="form-control"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"
							       for="entry-sort-order"><?php echo $text_entry_sort_order; ?></label>

							<div class="col-sm-10">
								<input type="number" min="0" name="sslcommerz_sort_order"
								       value="<?php echo $sslcommerz_sort_order; ?>"
								       placeholder="<?php echo $text_entry_sort_order; ?>" id="input-sort-order"
								       class="form-control"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"
							       for="entry-geo-zone"><?php echo $text_entry_geo_zone; ?></label>

							<div class="col-sm-10">
								<select name="sslcommerz_geo_zone_id" id="entry-geo-zone" class="form-control">
									<option value="0"><?php echo $text_all_zones; ?></option>
									<?php foreach ( $geo_zones as $geo_zone ) { ?>
										<?php if ( $geo_zone['geo_zone_id'] == $sslcommerz_geo_zone_id ) { ?>
											<option value="<?php echo $geo_zone['geo_zone_id']; ?>"
											        selected="selected"><?php echo $geo_zone['name']; ?></option>
										<?php } else { ?>
											<option
												value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"
							       for="entry-status"><?php echo $text_entry_status; ?></label>

							<div class="col-sm-10">
								<select name="sslcommerz_status" id="input-status" class="form-control">
									<?php if ( $sslcommerz_status ) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"
							       for="entry-notify"><?php echo $text_entry_notify; ?></label>

							<div class="col-sm-10">
								<select name="sslcommerz_notify" id="input-notify" class="form-control">
									<?php if ( $sslcommerz_notify ) { ?>
										<option value="1" selected="selected"><?php echo $text_yes; ?></option>
										<option value="0"><?php echo $text_no; ?></option>
									<?php } else { ?>
										<option value="1"><?php echo $text_yes; ?></option>
										<option value="0" selected="selected"><?php echo $text_no; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="entry-success-status-id"><?php echo $text_entry_success_status; ?></label>

							<div class="col-sm-10">
								<select name="sslcommerz_success_order_status_id" id="entry-success-status-id" class="form-control">
									<?php foreach ( $order_statuses as $order_status ) { ?>
										<?php if ( $order_status['order_status_id'] == $sslcommerz_success_order_status_id ) { ?>
											<option value="<?php echo $order_status['order_status_id']; ?>"
											        selected="selected"><?php echo $order_status['name']; ?></option>
										<?php } else { ?>
											<option
												value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="entry-unknown-status-id"><span data-toggle="tooltip" title="<?php echo $text_help_pending_status; ?>"><?php echo $text_entry_pending_status; ?></span></label>

							<div class="col-sm-10">
								<select name="sslcommerz_unknown_order_status_id" id="entry-unknown-status-id" class="form-control">
									<?php foreach ( $order_statuses as $order_status ) { ?>
										<?php if ( $order_status['order_status_id'] == $sslcommerz_unknown_order_status_id ) { ?>
											<option value="<?php echo $order_status['order_status_id']; ?>"
											        selected="selected"><?php echo $order_status['name']; ?></option>
										<?php } else { ?>
											<option
												value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-12 control-label"
							       for="entry-sort-order"><?php echo $text_support; ?></label>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php echo $footer; ?>