
<div id="scope_impressum" class="modal fade">
	<div class="modal-dialog modal-info" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Impressum</h4>
				<a class="close" aria-hidden="true" data-dismiss="modal">
					<i class="fa fa-times primary-color" aria-hidden="true"></i>
				</a>
			</div>
			<div class="modal-body">
				<p><?=nl2br($company['Company']['imprint'])?></p>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<div id="scope_datenschutz" class="modal fade">
	<div class="modal-dialog modal-info" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Datenschutz</h4>
				<a class="close" aria-hidden="true" data-dismiss="modal">
					<i class="fa fa-times primary-color" aria-hidden="true"></i>
				</a>
			</div>
			<div class="modal-body">
				<p><?=nl2br($company['Company']['data_protection'])?></p>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
