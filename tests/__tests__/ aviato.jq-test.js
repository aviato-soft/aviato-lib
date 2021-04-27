// Copyright 2014-present Aviato Soft. All Rights Reserved.
//const remedial = require('../../assets/js/remedial.js');
const avi = require('../../assets/js/aviato-node.js');


//aviato.jq.element.button
test ('aviato.jq.element.button', () => {
	const $ = require('jquery');
	let data = {
		'html': '<div id="wrapper"><input type="button" id="btnTest" data-type="button" data-action="aviato" value="click me!"/></div>'
	}
	document.body.innerHTML = data.html;

	//test 1: no params:
	let jq = avi.jq.element.button();
	expect (jq.length).toBe(0);

	//test 2: params: button
	jq = avi.jq.element.button('action');
	expect (jq.length).toBe(1);

	//test 3: params: button, selector
	jq = avi.jq.element.button('action', '#btnTest');
	expect (jq.length).toBe(1);

	//test 4: params: button, selector (invalid)
	jq = avi.jq.element.button('aviato', '#wrapper');
	expect (jq.length).toBe(0);
});
