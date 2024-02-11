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

let aviato = {
	/**
	 * <b>extending bootstrap with some usefull methodes</b>
	**/
	bootstrap: {},

	call: {},

	display: {},

	/**
	 * Usefull general functions
	**/
	fn: {},

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
 * add mapping 2 arrays into one object
 */
aviato.fn.arrayMap = function(arNames, arValues) {
	var oReturn = {};
	var i;
	var iMax = Math.min(arNames.length, arValues.length);
	for (i = 0; i < iMax; i++) {
		oReturn[arNames[i]] = arValues[i];
	}
	return oReturn;
}


/**
 * ArrayTOString - extend supplant functionality
 */
aviato.fn.atos = function(a, p) {
	const iCount = a.length;
	let i, r = '';

	for (i = 0; i < iCount; i++) {
		r += p.supplant(a[i]);
	}
	return r;
};


/**
 * Clone object - in this way object is assign by value not refference
 *
 */
aviato.fn.clone = function(o) {
	return Object.assign({}, o);
}


/**
 * Filter properties from an object
 */
aviato.fn.filterProperties = function(obj) {
	let entries = Object.entries(obj);
	let filter = entries.filter(function(item) { return (typeof (item[1]) === "number" || typeof (item[1]) === "string") });
	return (Object.fromEntries(filter));
}


/**
 * save form values to localStorage
 */
aviato.fn.formToLocalStorage = function(selector) {
	var oFormValues = $(selector).serializeArray();
	localStorage.setItem(selector, JSON.stringify(oFormValues));
};


/**
 * add get vars from url
 */
aviato.fn.getUrlVars = function(sUrl) {
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
 * load form values from localStorage
 */
aviato.fn.localStorageToForm = function(selector) {
	var oFormValues = JSON.parse(localStorage.getItem(selector));
	$(oFormValues).each(function() {
		$(selector + ' [name="' + this.name + '"]').val(this.value);
	});
	//TODO: specific logic for radios
};


/**
 * Return the function from string.
 * It parse the parents chain in case of one or multiple parents.
 */
aviato.fn.method = function(fname) {
	var fn;
	if (typeof fname === 'string' || fname instanceof String) {
		if (fname.indexOf('.') !== -1) {
			fname = fname.split('.');
			fn = window[fname[0]];
			for (var i = 1; i < fname.length; i++) {
				fn = fn[fname[i]];
			}
		}
		else {
			fn = window[fname];
		}
	}
	return fn;
}

/**
 * Strech a textarea by creating a hidden clone <pre> element
 * Options:
 * 	cloneId = the id of clonned pre element
 *	maxWidth = -1 | 0 | int value in pixels
 *	maxHeight = -1 | 0 | int value in pixels
 *	widthMargin
 *	heightMargin
 */
aviato.fn.strech = function(o, p = {}) {
	let defaults = {
		widthMargin: 10,
		maxWidth: 0,
		heightMargin: 5,
		maxHeight: 0,
		cloneId: 'clone-' + o.id
	}

	for (let v in defaults) {
		if (p[v] === undefined) {
			p[v] = defaults[v];
		}
	}

	var elClone = document.getElementById(p.cloneId);
	if (elClone === null) {
		elClone = document.createElement('pre');
		elClone.setAttribute('id', p.cloneId);
		elClone.style.display = "inline-block";
		elClone.style.position = "absolute";
		elClone.style.right = "99999px";
		elClone.style.border = "1px solid #99f";
		elClone.style.padding = "2px";
		elClone.style.zIndex = "-1";
		document.body.appendChild(elClone);

//remove element on textarea loose focus:
		o.addEventListener ("blur", function (){
			elClone.parentElement.removeChild(elClone)
		}, {once: true});
	}

	elClone.innerText = (o.value);
	let recall = false;

	// -1 = ignore - not strech width
	if (p.maxWidth !== -1) {
		// 0 = no limit for strech width
		if (p.maxWidth == 0 || o.clientWidth < p.maxWidth) {
			if ((elClone.clientWidth + p.widthMargin) > o.clientWidth) {
				o.cols++;
				recall = true;
			}
		}
	}

	// -1 = ignore - not strech height
	if (p.maxHeight !== -1) {
		// 0 = no limit for strech height
		if (p.maxHeight == 0 || o.clientHeight < p.maxHeight) {
			if ((elClone.clientHeight + p.heightMargin) > o.clientHeight) {
				o.rows++;
				recall = true;
			}
		}
	}

	if(recall) {
		aviato.fn.strech(o, p);
	}

}

/**
 * Check if we are on xs(mobile) resolution mode, it is based to navbar to work fine
 * DO NOT use it if there is not a navbar on the page because will return always false
 * @returns {Boolean}
 * @author Vasile Giorgi
**/
aviato.bootstrap.isXs = function() { // require navbar to return correct result
	return ($('.navbar-toggle:visible').length > 0);
};


/**
 * <b>Open(show) a bootstrap collapsable panel based on location hash
 * @param parentId
 * @author Vasile Giorgi
**/
aviato.bootstrap.showCollapseByLocationHash = function(parentId, closeOthers) {
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
aviato.bootstrap.addCollapseItem = function(oItemProperties, bAppendToParent) {
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
 * Set value for Bootstap progresbar
 * @param selector = the selector
 * @param value = the percentage
 */
aviato.bootstrap.progressbar = function(selector, value) {
	var valuePercent = '' + value + '%';
	$(selector).width(valuePercent);
	$(selector).text(valuePercent);
	$(selector).attr('aria-valuenow', valuePercent);
};



/**
 *
 */
aviato.bind = function(selector) {
	if (selector === undefined) {
		selector = '';
	}
	else {
		selector += ' ';
	}
	$(selector + '[data-action]').on('click', function() {
		aviato.on.click(this);
	});

	if (this.offcanvas === undefined) {
		this.offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvas'));
		document.getElementById('offcanvas').addEventListener('hidden.bs.offcanvas', function() {
			$('#alerts').html('');
		})
	}
};


/**

 */
aviato.jq.element.button = function(button, selector) {
	if (selector === undefined) {
		selector = '';
	}
	else {
		selector += ' ';
	}
	return ($(selector + '[data-type="button"][data-' + button + ']'));
};


aviato.on.click = function(oTrigger) {
	let $trigger = $(oTrigger);
	if ($trigger.data('action') !== undefined) {
		//visualy enable spinner
		$trigger.find('[data-role="spinner"]').removeClass('d-none');
		$trigger.find('[data-role="btn-icon"]').addClass('d-none');


		var action = {
			ajax: {
				async: true,
				cache: false,
				dataType: 'json',
				headers: {
					'cache-control': 'no-cache',
					'Access-Control-Allow-Origin': '*'
				},
				type: 'POST'
			},
			data: aviato.fn.filterProperties($trigger.data()),
			on: {},
			trigger: $trigger
		};

		var target = $trigger.data('target');

		switch ($trigger.data('action')) {
			case 'section':
				action.data.section = $trigger.data('section');
				if (target === undefined) {
					target = 'main';
					action.data.target = target;
				}
				$(target).html('');
				break;

			case 'upload':
				action.ajax.contentType = false;
				action.ajax.enctype = 'multipart/form-data';
				action.ajax.processData = false;

				var oForm = $trigger.closest("form")[0];

				//create form data object
				var formData = new FormData();

				//add existing form data:
				for(var key in action.data) {
					formData.append(key, action.data[key]);
				}

				//add handler method from form definition
				formData.append('handler', $(oForm).data('handler'));

				//add rest of form elements
				dataForm = $(oForm).serializeArray();
				$(dataForm).each(function() {
					formData.append(this.name, this.value);
				})

				//add files
				$.each($('#fileUpload')[0].files, function(k, v) {
					formData.append(k, v);
				})

				action.data = formData;

				break;
		}

		if ($trigger.data('serialize') !== undefined && $trigger.data('serialize') === true) {
			var dataForm = $trigger.closest("form").serializeArray();
			$(dataForm).each(function() {
				action.data[this.name] = this.value;
			})
		}

		if (target !== undefined) {
			aviato.display.selector = target;
			$(aviato.display.selector).addClass('pending');
		}

		//clenup dynamic data:
		if ($trigger.data('dyn') !== undefined) {
			$trigger.removeData('dyn');
		}

		if ($trigger.data('before') !== undefined) {
			action.before = $trigger.data('before');
		}

		if ($trigger.data('success') !== undefined) {
			action.on.success = aviato.fn.method($trigger.data('success'));
		}

		if ($trigger.data('complete') !== undefined) {
			action.on.complete = aviato.fn.method($trigger.data('complete'));
		}

		if ($trigger.data('error') !== undefined) {
			action.on.error = aviato.fn.method($trigger.data('error'));
		}

		if ($trigger.data('url') !== undefined) {
			action.url = $trigger.data('url');
		}
		else {
			action.url = location.href;
		}

		if ($trigger.data('verbose') !== undefined) {
			action.verbose = ($trigger.data('verbose') === true);
		}

		aviato.call.ajax(action);
	}
};


aviato.on.clickAgain = function(o) {
	aviato.offcanvas.hide();
	let trigger = $(o).data('trigger');
	$(trigger).data('dyn', $(o).data('dyn'));
	//wait to close the offcanvas...
	setTimeout(function() {
		//submit form again with dynamic option
		aviato.on.click(trigger);
	}, 500
	);
}


aviato.call.ajax = function(o) {
	if (o === undefined) {
		return false;
	}

	let $trigger = $(o.trigger);

	if (o.before !== undefined) {
		o.before(o);
		//visualy show spinner
		$trigger.find('[data-role="spinner"]').removeClass('d-none');
		$trigger.find('[data-role="btn-icon"]').addClass('d-none');

		//visualy disable element
		if ($trigger.prop('tagName') === 'A') {
			$trigger.addClass('disabled')
		}
		if ($trigger.prop('tagName') === 'BUTTON') {
			$trigger.prop('disabled', true);
		}
	}
	var ajaxSettings = o.ajax;
	ajaxSettings.data = o.data;
	ajaxSettings.error = function(XMLHttpRequest, textStatus, errorThrown) {
		if (o.on.error !== undefined) {
			o.on.error(XMLHttpRequest, textStatus, errorThrown);
		}
	}

	ajaxSettings.success = function(data, textStatus, jqXHR) {
		//redirect if location parameter is present
		if (data.location !== undefined) {
			location = data.location;
		}

		//diplay data on target if it is string (most cases)
		if (typeof data.data === 'string' || data.data instanceof String) {
			aviato.display.content(data.data);
		}

		//display error from logs
		if (data.success !== true || (o.verbose !== undefined && o.verbose === true)) {
			aviato.display.logs(data.log);
		}

		//call succes function if defined
		if (o.on.success !== undefined) {
			o.on.success(data, textStatus, jqXHR);
		}
	}
	ajaxSettings.complete = function(jqXHR, textStatus) {
		//visualy hide spinner
		$trigger.find('[data-role="spinner"]').addClass('d-none');
		$trigger.find('[data-role="btn-icon"]').removeClass('d-none');

		//visualy disable element
		if ($trigger.prop('tagName') === 'A') {
			$trigger.removeClass('disabled')
		}
		if ($trigger.prop('tagName') === 'BUTTON') {
			$trigger.prop('disabled', false);
		}

		if (o.on.complete !== undefined) {
			o.on.complete(jqXHR, textStatus);
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


aviato.display.content = function(data) {
	if (this.selector !== undefined) {
		if ($(this.selector).prop('tagName') === 'INPUT') {
			$(this.selector).val(data);
		}
		else {
			$(this.selector).html(data);
		}
		$(this.selector).removeClass("pending");
		aviato.bind(this.selector + ' ');
	}
	delete this.selector;
};


aviato.display.logs = function(logs, targetSelector = '#alerts') {
	$.each(logs, function() {
		aviato.display.alert(this, targetSelector);
	});
	//re-bind the controls:
	aviato.bind(targetSelector);

	aviato.offcanvas.show();
}


aviato.display.alert = function(data, targetSelector = '#alerts') {
	var style = data.type;
	if (style === 'error') {
		style = 'danger';
	}

	if ($(targetSelector).length === 0) {
		$('body').append('<div id="alerts" class="p-3" data-role="alerts"></div>');
	}

	let alertHtml = ''
		+ '<div class="alert alert-' + style + ' alert-dismissible" role="alert">'
		+ '<span>' + data.message + '</span>'
		+ '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
		+ '</div>';

	$(targetSelector).append(alertHtml);
};

/**
Bind sort using list js
 */
aviato.fn.sort = function(triggerId) {
	var a = [];
	$('#' + triggerId + ' th>button.sort').each(function() { a.push($(this).data('sort')) });

	var options = {
		valueNames: a
	};

	var table = new List(triggerId, options);
}

/*
$(function() {
	aviato.bind();
});
*/module.exports = aviato;
