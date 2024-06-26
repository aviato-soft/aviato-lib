# Changelog
---

>## v1.24.11
> - fix aviato.js missing offcanvas element result in error

>## v1.24.10
> - fix aviato.js missing bootstrap object on bind

>## v1.24.09
> - Avi\Db insert select

>## v1.24.08
> - allow objects on ajax data

>## v1.24.07
> - add input attribute for HtmlElementBsInput

>## v1.24.06
> - fix layout row and inline for Avi\HtmlElementBsSelect help and validation

>## v.1.24.05
> - handle autocomplete attribute for form fields

>## v.1.24.04
> - new method: Avi\Tools::asortByKey

>## v.1.24.03
> - Add aviato.fn.clone to assign javascript objects by value not by refference

>## v.1.24.02
> - HtmlElement set tag using attributes

>## v.1.24.01
> - HtmlElementBsForm - add offset for button with layout row in forms

>## v.1.24.00
> - complete HtmlElementBs collection


>## v.1.23.25
> - new HtmlElement: BsButtonGroup
> - new HtmlElement: BsBadge
> - new HtmlElement: BsCard
> - new HtmlElement: BsInputCheckbox
> - new HtmlElement: BsInputRadio
> - new HtmlElement: BsListGroup
> - new HtmlElement: BsNav

>## v.1.23.24
> - add HtmlElement->child
> - add HtmlElement->parent

>## v.1.23.23
> - new HtmlElement: BsDropdown

>## v.1.23.22
> - new method: Avi\Tools::isEnclosedIn()
> - new HtmlElement: BsButton
> - new HtmlElement: BsIcon
> - new HtmlElement: BsSpinner

>## v.1.23.21
> - accessible for child class Response->filter and Response->log

>## v.1.23.20
> - add new ckass: Avi\HtmlElement

---
>## v.1.23.19
> - add aviato.bootstrap.progressbar

---
>## v.1.23.18
> - add new method in tools: array_set

---
> ## v.1.23.17
> - fix invalid format on Db ln#474

---
> ## v.1.23.16
> - add into on select parsing query

---
> ## v.1.23.15
> - add option for db/insert: on duplicate key update

---
> ## v.1.23.14
> - psalm tested 100%
> - phpUnit coverage 100%

---
> ## v.1.23.13
> - fix Avi\Db->getLastId bug: error if last id is missing
> - psalm issues solved

---
> ## v.1.23.12
> - fix Avi\Db\parseVar('NULL', '?int) returned 0 instead of 'NULL'

---
> ## v.1.23.11
> - bind button actions on offcanvas elements

---
> ## v.1.23.10
> - parse update - add encloseInBacktick for keys

---
> ## v.1.23.09
> - parse insert - use parse var if missing type for Avi\Db

---
> ## v.1.23.08
> - parse empty select and where for Avi\Db

---
> ## v.1.23.07
> - versioning fix

---
> ## v.1.23.06
> - add parse Var for ?type for columns wich allow NULL data
> - add parse auto to detect query type

---
> ## v.1.23.05
> - add parse IP for Avi\Db

---
> ## v.1.23.04
> - rename brach master -> main

---
> ## v.1.23.03
> - major version change because there is a production use
> - add MySQli database wrapper

---
> ## v.0.23.02
> - add possibility to define a global AVI_KEY constant used for decript / encrypt
> - add posibility to define a global log path using AVI_LOG_PATH

---
> ## v.0.23.01
> - fix file upload encoding

---
> ## v.0.22.27
> - add prefix attribute to Tools\atoattr

---
> ## v.0.22.26
> - use json for ajax calls to preserve the old compatibility

---
> ## v.0.22.25
> - use jsonp for ajax calls to avoid Cross-Origin Read Blocking (CORB) for cross domains calls

---
> ## v.0.22.24
> - add Avi\Tools::emailify

---


> ## v.0.22.23
> - remove documentation cache

---


> ## v.0.22.22
> - add phpunit/php-code-coverage
> - handling log backtrace level 2

---

> ## v.0.22.21
> - Bug fix

---

> ## v.0.22.20
> - Bug fix

---


> ## v.0.22.19
> - Stand With Ukraine

---

> ## v.0.22.18
> - Tools::Dec return false instead of warning on bad decryption

---

> ## v.0.22.17
> - js update content will update values for inputs

---

> ## v.0.22.16
> - add htmlentities on atos

---

> ## v.0.22.15
> - fix atos bugs

---

> ## v.0.22.14
> - use empty response on atos in case of empty array

---

> ## v.0.22.13
> - add aviato.fn.strech

---

> ## v.0.22.12
> - add feedback on ajax triggers
> -- spinners
> -- disable element

---

> ## v.0.22.11
> - update UI:
> -- avi.js index changed from 999 to '999avi'
> -- error handlers for missing sections in case of missing log

---

> ## v.0.22.10 [*omicron*]
>	-  transitional for bootstrap 5.1

---

> ## v.0.7.9
> - js update aviato.display.alert to use bootstrap v.5

---

> ## v.0.7.8
> - js use target as generic call with result on ajax complete

---

> ## v.0.7.7
> - js add new code method: aviato.fn.filterProperties

---

> ## v.0.7.6
> - js send all data from trigger as payload if action is set

---

> ## v.0.7.5
> - UI - allow non statical sections

---

> ## v.0.7.4
> - add attributes for html page tag

---

> ## v.0.7.3
> - Fix Avi\Tools::atos - return correct format from list array instead of warning

---

> ## v.0.7.2
> - Add new parameter on Avi\Tracker constructor: cookie

---

> ## v.0.7.1
> - Add new method Avi\Tools::isGdprSet()

---

> ## v.0.7.0
> - Add new class: Tracker

---

> ## v.0.6.6 - v.0.6.5
> - re-tag

---

> ## v.0.6.5
> - Use pending class for ajax call waiting

---

> ## v.0.6.4
> - signed branch - stable

---

> ## v.0.6.3
> - add Avi\Version::getJsMd5()

---

> ## v.0.6.2
> - doc -> docs

---

> ## v.0.6.1
> - Add new class: Filter

---

> ## v.0.5.1
> - Add method: Tools::validateDate

---

> ## v.0.5.0
> - Generate documentation using phpdoc

---

> ## v.0.4.9
> - Add method: Tools::dtFormatToFormat

---

> ## v.0.4.8
> - Allow custom atributes to section

---

> ## v.0.4.7 *[Turkey]*
>  - fixes for js based on jest tests

---

> ## v.0.4.6
>  - Fix compatibility with php8.0 on UI->$response

---

> ## v.0.4.5
> - removed unused debugging log

---

> ## v.0.4.4
> - fix aviato.js: invalid main

---

> ## v.0.4.3
> - add test unit for Version class

---

> ## v.0.4.2
> - use PHP_EOL instead of "\n"

---

> ## v.0.4.1
>  - full migration of old aviato-lib

---

> ## v.0.4.0
> - add javascript component

---

> ## v.0.3.0
> - add UI component

---

> ## v.0.2.0
> - add Response + Log components

---

> ## v.0.1.0
> - add Tools component

---

> ## v.0.0.1 *[start]*

---
