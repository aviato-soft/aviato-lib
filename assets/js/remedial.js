/**
 * REMEDIAL JS
 *
 * @source: http://javascript.crockford.com/remedial.html
 * @author: Douglas Crockford
*/

"use strict";


/**
 * typeof Fix 2 major javascript issues:
 * typeof [] produces 'object' instead of 'array'
 * 	- That isn't totally wrong since arrays in JavaScript inherit from objects, but it isn't very useful.
 * typeof null produces 'object' instead of 'null'
 *  -That is totally wrong.
 *
 * We can correct this by defining our own typeOf function,
 * which we can use in place of the defective typeof operator.
*/
function typeOf(value) {
	var s = typeof value;
	if (s === 'object') {
		if (value) {
			if (value instanceof Array) {
				s = 'array';
			}
		} else {
			s = 'null';
		}
	}
	return s;
}


/**
 * isEmpty
 * @param o
 * @returns true if v is an object containing no enumerable members
 */
function isEmpty(o) {
	var i, v;
	if (typeOf(o) === 'object') {
		for (i in o) {
			v = o[i];
			if (v !== undefined && typeOf(v) !== 'function') {
				return false;
			}
		}
	}
	return true;
}


/**
 * entityify() produces a string in which '<', '>', and '&' are replaced with their HTML entity equivalents.
 * This is essential for placing arbitrary strings into HTML texts.
 * So,
 *		"if (a < b && b > c) {".entityify()
 *	produces
 *		"if (a &lt; b &amp;&amp; b &gt; c) {"
 *
 */
if (!String.prototype.entityify) {
    String.prototype.entityify = function () {
        return this.replace(/&/g, "&amp;")
        	.replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");
    };
}


/**
 * quote() produces a quoted string. This method returns a string that is like the original string except that it
 * is wrapped in quotes and all quote and backslash characters are preceded with backslash.
 *
 */
if (!String.prototype.quote) {
    String.prototype.quote = function () {
        var c, i, l = this.length, o = '"';
        for (i = 0; i < l; i += 1) {
            c = this.charAt(i);
            if (c >= ' ') {
                if (c === '\\' || c === '"') {
                    o += '\\';
                }
                o += c;
            } else {
                switch (c) {
                case '\b':
                    o += '\\b';
                    break;
                case '\f':
                    o += '\\f';
                    break;
                case '\n':
                    o += '\\n';
                    break;
                case '\r':
                    o += '\\r';
                    break;
                case '\t':
                    o += '\\t';
                    break;
                default:
                    c = c.charCodeAt();
                    o += '\\u00' + Math.floor(c / 16).toString(16) +
                        (c % 16).toString(16);
                }
            }
        }
        return o + '"';
    };
}


/**
 * supplant() does variable substitution on the string.
 * It scans through the string looking for expressions enclosed in { } braces.
 * If an expression is found, use it as a key on the object, and if the key has a string value or number value,
 * it is substituted for the bracket expression and it repeats.
 * This is useful for automatically fixing URLs. So

	param = {domain: 'aviato.ro', media: 'http://media.aviato.ro/'};
	url = "{media}logo.gif".supplant(param);
		produces
	a url containing "http://media.aviato.ro/logo.gif".
*/
if (!String.prototype.supplant) {
	String.prototype.supplant = function (o) {
		return this.replace( /\{([^{}]*)\}/g, function (a, b) {
			var r = o[b];
			return typeof r === 'string' || typeof r === 'number' ? r : a;
		});
	};
}

/**
 * The trim() method removes whitespace characters from the beginning and end of the string.
 */
if (!String.prototype.trim) {
	String.prototype.trim = function () {
		return this.replace(/^\s*(\S*(?:\s+\S+)*)\s*$/, "$1");
	};
}


/**
 * replaceAll() method replace all occurrences of the search string with the replacement string
 *
 * @source: http://stackoverflow.com/questions/1144783/replacing-all-occurrences-of-a-string-in-javascript
 */
if (!String.prototype.replaceAll) {
	String.prototype.replaceAll = function (find, replace) {
		return this.replace(new RegExp(find.escapeRegExp(), 'g'), replace);
	}
}

/**
 * Escaping user input to be treated as a literal string within a regular expression accomplished by simple replacement
 *
 * @source: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Regular_Expressions#Using_Special_Characters
 */
if(!String.prototype.escapeRegExp) {
	String.prototype.escapeRegExp = function () {
		return this.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
	}
}


/**
 * Capitalize first letter of string
 *
 * @source: http://stackoverflow.com/questions/1026069/capitalize-the-first-letter-of-string-in-javascript
 */
if (!String.prototype.ucFirst) {
	String.prototype.ucFirst = function () {
		return this.charAt(0).toUpperCase() + this.slice(1);
	};
}


/**
 * padLeft (add zero at the begining of the string, usefull for numbers)
 *
 * @source: http://stackoverflow.com/
 * questions/2686855/is-there-a-javascript-function-that-can-pad-a-string-to-get-to-a-determined-leng
 */
if(!String.prototype.padLeft) {
	String.prototype.padLeft = function (n, c) {
		if (isNaN(n)) {
			return null;
		}
		c = c || "0";
		return (new Array(n).join(c).substring(0, (n - this.length))) + this;
	};
}

/**
 * Production steps of ECMA-262, Edition 5, 15.4.4.14
 * Reference: http://es5.github.io/#x15.4.4.14
 *
 * @source: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/indexOf
 */
if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function(searchElement, fromIndex) {
	var k;

 // 1. Let o be the result of calling ToObject passing
 //    the this value as the argument.
	if (this == null) {
		throw new TypeError('"this" is null or not defined');
	}

	var o = Object(this);

 // 2. Let lenValue be the result of calling the Get
 //    internal method of o with the argument "length".
 // 3. Let len be ToUint32(lenValue).
	var len = o.length >>> 0;

 // 4. If len is 0, return -1.
	if (len === 0) {
		return -1;
	}

 // 5. If argument fromIndex was passed let n be
 //    ToInteger(fromIndex); else let n be 0.
	var n = +fromIndex || 0;

	if (Math.abs(n) === Infinity) {
		n = 0;
	}

 // 6. If n >= len, return -1.
	if (n >= len) {
		return -1;
	}

 // 7. If n >= 0, then Let k be n.
 // 8. Else, n<0, Let k be len - abs(n).
 //    If k is less than 0, then let k be 0.
	k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

 // 9. Repeat, while k < len
	while (k < len) {
   // a. Let Pk be ToString(k).
   //   This is implicit for LHS operands of the in operator
   // b. Let kPresent be the result of calling the
   //    HasProperty internal method of o with argument Pk.
   //   This step can be combined with c
   // c. If kPresent is true, then
   //    i.  Let elementK be the result of calling the Get
   //        internal method of o with the argument ToString(k).
   //   ii.  Let same be the result of applying the
   //        Strict Equality Comparison Algorithm to
   //        searchElement and elementK.
   //  iii.  If same is true, return k.
		if (k in o && o[k] === searchElement) {
			return k;
		}
		k++;
	}
	return -1;
	};
}