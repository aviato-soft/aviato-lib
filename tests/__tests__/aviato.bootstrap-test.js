// Copyright 2014-present Aviato Soft. All Rights Reserved.
const remedial = require('../../assets/js/remedial.js');
const avi = require('../../assets/js/aviato-node.js');


//aviato.bootstrap.isXs
test ('aviato.bootstrap.isXs', () => {
	expect (avi.bootstrap.isXs()).toBeFalsy();
});


//aviato.bootstrap.addCollapseItem
test ('aviato.bootstrap.addCollapseItem and aviato.bootstrap.showCollapseByLocationHash', () => {
	const $ = require('jquery');
	let data = {
		'html': '<div id="accordion"></div>',
		'items': {
			'one': {},
			'two': {
				'content': 'aviato',
				'id': 'item2',
				'class': 'primary', //default|primary|success|info|warning|danger
				'isCollapse': '', // '' | ' in'
				'isCurrent': 'current',//'' | 'current'
				'parentId': 'accordion',
				'title': 'Test Collapsible Group Item'
			}
		},
		'url': 'https://www.aviato.ro/index.php?name=aviato&one=1#item2',
		'expected':{
			'one': "<div class=\"panel panel-default\"><div class=\"panel-heading \"><h4 class=\"panel-title\"><a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseItem\">Collapsible Group Item</a></h4></div><div id=\"collapseItem\" class=\"panel-collapse collapse \"><div class=\"panel-body\"></div></div></div>",
			'two': "<div id=\"accordion\"><div class=\"panel panel-default\"><div class=\"panel-heading \"><h4 class=\"panel-title\"><a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseItem\">Collapsible Group Item</a></h4></div><div id=\"collapseItem\" class=\"panel-collapse collapse \"><div class=\"panel-body\"></div></div></div><div class=\"panel panel-primary\"><div class=\"panel-heading current\"><h4 class=\"panel-title\"><a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#item2\">Test Collapsible Group Item</a></h4></div><div id=\"item2\" class=\"panel-collapse collapse \"><div class=\"panel-body\">aviato</div></div></div></div>",
			'three': "<div id=\"accordion\"><div class=\"panel panel-default\"><div class=\"panel-heading \"><h4 class=\"panel-title\"><a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseItem\">Collapsible Group Item</a></h4></div><div id=\"collapseItem\" class=\"panel-collapse collapse \"><div class=\"panel-body\"></div></div></div><div class=\"panel panel-primary\"><div class=\"panel-heading current\"><h4 class=\"panel-title\"><a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#item2\" class=\"\" aria-expanded=\"true\">Test Collapsible Group Item</a></h4></div><div id=\"item2\" class=\"panel-collapse collapsing\" style=\"height: 0px;\"><div class=\"panel-body\">aviato</div></div></div></div>"
		}
	};
	document.body.innerHTML = data.html;

	expect(avi.bootstrap.addCollapseItem(data.items.one)).toBe(data.expected.one);
	$('#accordion').append(data.expected.one);

	expect(avi.bootstrap.addCollapseItem(data.items.two, true)).toBeTruthy();
	expect($('body').html()).toBe(data.expected.two);

	expect(avi.bootstrap.showCollapseByLocationHash('accordion')).toBeUndefined();
	delete window.location
	window.location = new URL(data.url);
	expect(avi.bootstrap.showCollapseByLocationHash('accordion', true)).toBeUndefined();
	expect($('body').html()).toBe(data.expected.three);
});
