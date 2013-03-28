function frontend_checklist_save_cookie(fc_listID) {
	var i;
	var cookie_sum = 0;
	var str_cookie_sum;
	var checkbox;
	
	for (i=0;i<=50;i++) {
		checkbox = document.getElementById('frontend-checklist-' + fc_listID + '-item-' + i);
		if (checkbox && checkbox.checked) {
			cookie_sum += Math.pow(2, i);
		}
	}
	
	document.cookie = 'frontend-checklist-' + fc_listID + '=' + cookie_sum + "; expires=Tue, 07 Nov 2084 12:00:00 GMT";

}