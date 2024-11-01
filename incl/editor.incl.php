<label class="folio-label">
	Url:
</label>
	<input class="folio-input" name="folio-url" value="<?php echo $url; ?>" /><br />
<label class="folio-label">
	Client Name:
</label>
	<input class="folio-input" name="folio-clientname" value="<?php echo $client; ?>" /><br />
<label class="folio-label">
	Client URL:
</label>
	<input class="folio-input" name="folio-clurl" value="<?php echo $clurl; ?>" /><br />
<label class="folio-label">
	Client Sector:
</label>
	<input class="folio-input" name="folio-clsec" value="<?php echo $clsec; ?>" /><br />
<label class="folio-label">
	Date:
</label>
	<input class="folio-input folio-date" name="folio-date" value="<?php echo $date; ?>" /><br />
<label class="folio-label">
	Type of Work:
</label>
	<select class="folio-input" name="folio-punp" value="<?php echo $punp; ?>" >
		<option value="Unpaid">Unpaid</option>
		<option value="Paid">Paid</option>
		<option value="Private">Private</option>
		<option value="Charity">Charity</option>
		<option value="Public Release">Public Release</option>
	</select>