const $ = require('jquery');
require('bootstrap');
/**
 * Aviato JavaScript library v.1.0.0
 *
 * Include remedial.js
 *
 * Copyright Aviato Soft
 *
 * Date: 2016-11-11T11:11:11z
**/

"use strict";

const aviato = {
	/**
	 * <b>extending bootstrap with some usefull methodes</b>
	**/
	bootstrap,

	call,

	display,

	/**
	 * Usefull general functions
	**/
	fn,

	/**
	 * extend jQuery in need
	**/
	jq: {
		element: {}
	},

	/**
	 * actions
	 */
	on: {}
};


/**
 * ArrayTOString - extend supplant functionality
 */
aviato.fn.prototype.atos = function(a, p) {
	var i, r = '', iCount = a.length;
	for (i = 0; i < iCount; i++) {
		r += p.supplant(a[i]);
	}
	return r;
};


/**
 * add mapping 2 arrays into one object
 */
aviato.fn.prototype.arrayMap = function(arNames, arValues) {
	var oReturn = {};
	var i;
	var iMax = Math.min(arNames.length, arValues.length);
	for (i = 0; i < iMax; i++) {
		oReturn[arNames[i]] = arValues[i];
	}
	return oReturn;
}


/**
 * add get vars from url
 */
aviato.fn.prototype.getUrlVars = function(sUrl) {
	if (typeof (sUrl) === 'undefined') {
		sUrl = window.location.href;
	}
	var vars = [], hash;
	var hashes = sUrl.slice(sUrl.indexOf('?') + 1).split('&');
	for (var i = 0; i < hashes.length; i++) {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	return vars;
};


/**
 * save form values to localStorage
 */
aviato.fn.prototype.formToLocalStorage = function(selector) {
	var oFormValues = $(selector).serializeArray();
	localStorage.setItem(selector, JSON.stringify(oFormValues));
};


/**
 * load form values from localStorage
 */
aviato.fn.prototype.localStorageToForm = function(selector) {
	var oFormValues = JSON.parse(localStorage.getItem(selector));
	$(oFormValues).each(function() {
		$(selector + ' [name="' + this.name + '"]').val(this.value);
	});
	//TODO: specific logic for radios
};


/**
 * Filter properties from an object
 * aviato.fn.prototype.filterProperties({
	a:3,
	b:"3",
	c:function(o){return (o*3)},
	d:{d1:3, d2:"3"},
	e:null,
	f:undefined,
	g:[1,2,3,4]})

	will return:
		{a:3,b:"3"}
 */
aviato.fn.prototype.filterProperties = function (obj) {
	let entries = Object.entries(obj);
	let filter = entries.filter(function (item){return (typeof(item[1] === "number" || item[1] === "string"))});
	return (Object.fromEntries(filter));
}

/**
 * Check if we are on xs(mobile) resolution mode, it is based to navbar to work fine
 * DO NOT use it if there is not a navbar on the page because will return always false
 * @returns {Boolean}
 * @author Vasile Giorgi
**/
aviato.bootstrap.prototype.isXs = function() { // require navbar to return correct result
	return ($('.navbar-toggle:visible').length > 0);
};


/**
 * <b>Open(show) a bootstrap collapsable panel based on location hash
 * @param parentId
 * @author Vasile Giorgi
**/
aviato.bootstrap.prototype.showCollapseByLocationHash = function(parentId, closeOthers) {
	if (closeOthers === undefined) {
		closeOthers = false;
	}

	//check if there is something on location hash:
	if (window.location.hash.length > 1) {
		//check if exist the specified id and it is an collapse trigger:
		if ($('#' + parentId + ' a[href="' + window.location.hash + '"]').data('toggle') === 'collapse') {
			//close (show) all colapsible panels if some are opened(shown)
			if (closeOthers === true) {
				$('#' + parentId + ' .panel-collapse.in').collapse('hide');
			}
			//check if colapse element has class 'in' (in this case is open so nothing to do)
			if (!$(window.location.hash).hasClass('in')) {
				//finaly show the collapse element:
				$(window.location.hash).collapse('show');
			}
		}
	}
};


/**
 * <b> Create a string formated for bootstrap 3 collapible item
 * @param object oItemProperties - options of the collapsible item
 * @param boolean bAppendToParent - the string will be append on parent id (which is suppose to be the id of the acordion)
 * @return string|nothing - depending on $output the function will return the formated string or nothing
 *
 * @author Vasile Giorgi
 */
aviato.bootstrap.prototype.addCollapseItem = function(oItemProperties, bAppendToParent) {
	if (bAppendToParent === undefined) {
		bAppendToParent = false;
	}

	//apply default properties:
	let itemProperties = {
		'class': 'default', //default|primary|success|info|warning|danger
		'content': '',
		'id': 'collapseItem',
		'isCollapse': '', // '' | ' in'
		'isCurrent': '',//'' | 'current'
		'parentId': 'accordion',
		'title': 'Collapsible Group Item'
	};
	$.extend(itemProperties, oItemProperties);

	var sPattern =
		'<div class="panel panel-{class}">' +
		'<div class="panel-heading {isCurrent}">' +
		'<h4 class="panel-title">' +
		'<a data-toggle="collapse" data-parent="#{parentId}" href="#{id}">{title}</a>' +
		'</h4>' +
		'</div>' +
		'<div id="{id}" class="panel-collapse collapse {isCollapse}">' +
		'<div class="panel-body">{content}</div>' +
		'</div>' +
		'</div>';
	let item = sPattern.supplant(itemProperties);

	if (bAppendToParent) {
		$('#' + itemProperties.parentId).append(item);
		return true;
	}
	else {
		return item;
	}
};


/**
 *
 */
aviato.prototype.bind = function(selector) {
	if (selector === undefined) {
		selector = '';
	}
	if (aviato.jq.element.button('action', selector).length > 0) {
		aviato.jq.element.button('action', selector).on('click', function() {
			var $btn = $(this).button('loading...');
			aviato.on.click(this);
			$btn.button('reset');
		});
	}
};


/**

 */
aviato.jq.element.prototype.button = function(button, selector) {
	if (selector === undefined) {
		selector = '';
	}
	return ($(selector + '[data-type="button"][data-' + button + ']'));
};


/**
 */
aviato.on.prototype.click = function(oTrigger) {
	if ($(oTrigger).data('action') !== undefined) {
		var action = {
			data: aviato.fn.filterProperties($(oTrigger).data()),
			on: {},
			ajax: {
				async: true,
				cache: false,
				dataType: 'json',
				headers: {
					'cache-control': 'no-cache'
				},
				type: 'POST'
			}
		};

		switch ($(oTrigger).data('action')) {
			case 'section':
				action.data.section = $(oTrigger).data('section');
				if ($(oTrigger).data('target') !== undefined) {
					aviato.display.section.selector = $(oTrigger).data('target');
				}
				else {
					aviato.display.section.selector = '#main';
				}
				if ($(oTrigger).data('params') !== undefined) {
					action.data.params = $(oTrigger).data('params');
				}
				$(aviato.display.section.selector).html('').addClass("pending");

				action.on.success = aviato.display.section;
				break;

			case 'upload':
				action.ajax.contentType = false;
				action.ajax.enctype = 'multipart/form-data';
				action.ajax.processData = false;

				var oForm = $(oTrigger).closest("form")[0];

				//create form data object
				action.data = new FormData();

				//add handler method from form definition
				action.data.append('action', $(oForm).data('handler'));

				//add rest of form elements
				var dataForm = $(oForm).serializeArray();
				$(dataForm).each(function() {
					action.data.append(this.name, this.value);
				})

				//add files
				$.each($('#fileUpload')[0].files, function(k, v) {
					action.data.append(k, v);
				})

				break;
		}

		if ($(oTrigger).data('serialize') !== undefined && $(oTrigger).data('serialize') === true) {
			var dataForm = $(oTrigger).closest("form").serializeArray();
			$(dataForm).each(function() {
				action.data[this.name] = this.value;
			})
		}

		if ($(oTrigger).data('before') !== undefined) {
			action.before = $(oTrigger).data('before');
		}

		if ($(oTrigger).data('success') !== undefined) {
			action.on.success = $(oTrigger).data('success');
		}

		if ($(oTrigger).data('error') !== undefined) {
			action.on.error = $(oTrigger).data('error');
		}

		if ($(oTrigger).data('url') !== undefined) {
			action.url = $(oTrigger).data('url');
		}
		else {
			action.url = location.href;
		}

		aviato.call.ajax(action);
	}
};


aviato.call.prototype.ajax = function(o) {
	if (o === undefined) {
		return false;
	}

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
	*/

	$.ajax(ajaxSettings);
};


aviato.display.prototype.section = function(data) {
	$(this.success.selector).html(data.data).removeClass("pending");
	aviato.bind(this.success.selector + ' ');
};


aviato.display.prototype.alert = function(data) {
	var style = data.type;
	if (style === 'error') {
		style = 'danger';
	}
	$('#alerts').append(
		'<div class="alert alert-dismissible alert-' + style + '" role="alert">'
		+ '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
		+ '<span aria-hidden="true">&times;</span></button>'
		+ '<strong>' + data.type.toUpperCase() + '!</strong> '
		+ data.message
		+ '</div>');

	var alerts = $("#alerts>div").get();
	console.log(alerts.length);
	alerts = jQuery.unique(alerts);
	console.log(alerts.length);
};

/*
$(function() {
	aviato.bind();
});
*/module.exports = aviato;
