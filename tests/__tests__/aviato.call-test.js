// Copyright 2014-present Aviato Soft. All Rights Reserved.
const remedial = require('../../assets/js/remedial.js');
const avi = require('../../assets/js/aviato-node.js');

//aviato.call.ajax
test ('avi.call.ajax', () => {
	let data = {
		html: '<div id="aviato"></div>',
		o:{
			ajax: {

			},
			before: function test() {

			},
			data: {},
			on: {
				error: function () {

				},
				success: function () {

				}
			},
			url: 'ajax.php'
		},
		expected : '<div id="1">one</div><div id="2">two</div>'
	}

	expect(avi.call.ajax()).toBeFalsy();
});


/*
aviato.call.ajax = function(o) {
	if (o.before !== undefined) {
		o.before(o);
	}
	var ajaxSettings = o.ajax;
	ajaxSettings.data = o.data;
	ajaxSettings.error = function(XMLHttpRequest, textStatus, errorThrown) {
		if (o.on.error !== undefined) {
			o.on.error(XMLHttpRequest, textStatus, errorThrown);
		}
	}
	ajaxSettings.success = function(data, textStatus, errorThrown) {
		if (o.on.success !== undefined) {
			o.on.success(data, textStatus, errorThrown);
		}
		if (data.success !== true) {
			$.each(data.log, function() {
				aviato.display.alert(this);
			})
		}
	}
	ajaxSettings.url = o.url;
	/*
	ajaxProto.xhr: function () {
		var myXhr = $.ajaxSettings.xhr();
		if (myXhr.upload) {
			myXhr.upload.addEventListener('progress', that.progressHandling, false);
		}
		return myXhr;
	},
	* /

	$.ajax(ajaxSettings);
};
*/
