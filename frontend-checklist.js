function frontend_checklist_checkbox_changed(fc_listID, cookie, cookie_lifetime_days) {
	var i;
	var sum = 0;
	var checkbox;
		
	for (i=0;i<=50;i++) {
		checkbox = jQuery('#frontend-checklist-' + fc_listID + '-item-' + i);
		if (checkbox && checkbox.prop('checked')) {
			sum += Math.pow(2, i);
			checkbox.closest('p').addClass('checked');
		}
		else checkbox.closest('p').removeClass('checked');
	}
		
	if (cookie == 1) {
		var expires = new Date();
		expires.setDate(expires.getDate() + cookie_lifetime_days);
		document.cookie = 'frontend-checklist-' + fc_listID + '=' + sum + "; expires=" + expires.toGMTString() + "; path=/";
	}
	else {
		var data = { action: 'fc_checkbox_changed', fc_listID: fc_listID, sum: sum};
		jQuery.post(frontendChecklist.ajaxurl, data);
	}
}



function frontend_checklist_load_status(fc_listID, cookie) {
	var sum;

	if (cookie == 1) {
		sum = getCookie('frontend-checklist-' + fc_listID);
		frontend_checklist_write_status(fc_listID, sum)
	}
	else {
		var data = { action: 'fc_load_status', fc_listID: fc_listID };
		jQuery.post(frontendChecklist.ajaxurl, data, function(response) {
			sum = parseInt(response);
			frontend_checklist_write_status(fc_listID, sum)
		});
	}
}



function frontend_checklist_write_status(fc_listID, sum) {
	var i;
	var checkbox;
	
	for (i=0;i<=50;i++) {
		checkbox = jQuery('#frontend-checklist-' + fc_listID + '-item-' + i);
		if (sum & Math.pow(2, i)) {
			checkbox.prop('checked', true);
			checkbox.closest('p').addClass('checked');
		}
	}
}



function getCookie(c_name)
{
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
{
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}