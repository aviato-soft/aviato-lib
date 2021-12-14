/* 
Aviato-Lib.js, build #00.07.03 from 2021-12-14 20:01:10.
Copyright 2014-present Aviato Soft. All Rights Reserved.
 */"use strict";function typeOf(value){var s=typeof value;if(s==='object'){if(value){if(value instanceof Array){s='array';}}else{s='null';}}
return s;}
function isEmpty(o){var i,v;if(typeOf(o)==='object'){for(i in o){v=o[i];if(v!==undefined&&typeOf(v)!=='function'){return false;}}}
return true;}
if(!String.prototype.entityify){String.prototype.entityify=function(){return this.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");};}
if(!String.prototype.quote){String.prototype.quote=function(){var c,i,l=this.length,o='"';for(i=0;i<l;i+=1){c=this.charAt(i);if(c>=' '){if(c==='\\'||c==='"'){o+='\\';}
o+=c;}else{switch(c){case'\b':o+='\\b';break;case'\f':o+='\\f';break;case'\n':o+='\\n';break;case'\r':o+='\\r';break;case'\t':o+='\\t';break;default:c=c.charCodeAt();o+='\\u00'+Math.floor(c/16).toString(16)+
(c%16).toString(16);}}}
return o+'"';};}
if(!String.prototype.supplant){String.prototype.supplant=function(o){return this.replace(/\{([^{}]*)\}/g,function(a,b){var r=o[b];return typeof r==='string'||typeof r==='number'?r:a;});};}
if(!String.prototype.trim){String.prototype.trim=function(){return this.replace(/^\s*(\S*(?:\s+\S+)*)\s*$/,"$1");};}
if(!String.prototype.replaceAll){String.prototype.replaceAll=function(find,replace){return this.replace(new RegExp(find.escapeRegExp(),'g'),replace);}}
if(!String.prototype.escapeRegExp){String.prototype.escapeRegExp=function(){return this.replace(/([.*+?^=!:${}()|\[\]\/\\])/g,"\\$1");}}
if(!String.prototype.ucFirst){String.prototype.ucFirst=function(){return this.charAt(0).toUpperCase()+this.slice(1);};}
if(!String.prototype.padLeft){String.prototype.padLeft=function(n,c){if(isNaN(n)){return null;}
c=c||"0";return(new Array(n).join(c).substring(0,(n-this.length)))+this;};}
if(!Array.prototype.indexOf){Array.prototype.indexOf=function(searchElement,fromIndex){var k;if(this==null){throw new TypeError('"this" is null or not defined');}
var o=Object(this);var len=o.length>>>0;if(len===0){return-1;}
var n=+fromIndex||0;if(Math.abs(n)===Infinity){n=0;}
if(n>=len){return-1;}
k=Math.max(n>=0?n:len-Math.abs(n),0);while(k<len){if(k in o&&o[k]===searchElement){return k;}
k++;}
return-1;};}"use strict";const aviato={bootstrap:{},call:{},display:{},fn:{},jq:{element:{}},on:{}};aviato.fn.atos=function(a,p){var i,r='',iCount=a.length;for(i=0;i<iCount;i++){r+=p.supplant(a[i]);}
return r;};aviato.fn.arrayMap=function(arNames,arValues){var oReturn={};var i;var iMax=Math.min(arNames.length,arValues.length);for(i=0;i<iMax;i++){oReturn[arNames[i]]=arValues[i];}
return oReturn;}
aviato.fn.getUrlVars=function(sUrl){if(typeof(sUrl)==='undefined'){sUrl=window.location.href;}
var vars=[],hash;var hashes=sUrl.slice(sUrl.indexOf('?')+1).split('&');for(var i=0;i<hashes.length;i++){hash=hashes[i].split('=');vars.push(hash[0]);vars[hash[0]]=hash[1];}
return vars;};aviato.fn.formToLocalStorage=function(selector){var oFormValues=$(selector).serializeArray();localStorage.setItem(selector,JSON.stringify(oFormValues));};aviato.fn.localStorageToForm=function(selector){var oFormValues=JSON.parse(localStorage.getItem(selector));$(oFormValues).each(function(){$(selector+' [name="'+this.name+'"]').val(this.value);});};aviato.bootstrap.isXs=function(){return($('.navbar-toggle:visible').length>0);};aviato.bootstrap.showCollapseByLocationHash=function(parentId,closeOthers){if(closeOthers===undefined){closeOthers=false;}
if(window.location.hash.length>1){if($('#'+parentId+' a[href="'+window.location.hash+'"]').data('toggle')==='collapse'){if(closeOthers===true){$('#'+parentId+' .panel-collapse.in').collapse('hide');}
if(!$(window.location.hash).hasClass('in')){$(window.location.hash).collapse('show');}}}};aviato.bootstrap.addCollapseItem=function(oItemProperties,bAppendToParent){if(bAppendToParent===undefined){bAppendToParent=false;}
let itemProperties={'class':'default','content':'','id':'collapseItem','isCollapse':'','isCurrent':'','parentId':'accordion','title':'Collapsible Group Item'};$.extend(itemProperties,oItemProperties);var sPattern='<div class="panel panel-{class}">'+'<div class="panel-heading {isCurrent}">'+'<h4 class="panel-title">'+'<a data-toggle="collapse" data-parent="#{parentId}" href="#{id}">{title}</a>'+'</h4>'+'</div>'+'<div id="{id}" class="panel-collapse collapse {isCollapse}">'+'<div class="panel-body">{content}</div>'+'</div>'+'</div>';let item=sPattern.supplant(itemProperties);if(bAppendToParent){$('#'+itemProperties.parentId).append(item);return true;}
else{return item;}};aviato.bind=function(selector){if(selector===undefined){selector='';}
if(aviato.jq.element.button('action',selector).length>0){aviato.jq.element.button('action',selector).on('click',function(){var $btn=$(this).button('loading...');aviato.on.click(this);$btn.button('reset');});}};aviato.jq.element.button=function(button,selector){if(selector===undefined){selector='';}
return($(selector+'[data-type="button"][data-'+button+']'));};aviato.on.click=function(oTrigger){if($(oTrigger).data('action')!==undefined){var action={data:{action:$(oTrigger).data('action')},on:{},ajax:{async:true,cache:false,dataType:'json',headers:{'cache-control':'no-cache'},type:'POST'}};switch($(oTrigger).data('action')){case'section':action.data.section=$(oTrigger).data('section');if($(oTrigger).data('target')!==undefined){aviato.display.section.selector=$(oTrigger).data('target');}
else{aviato.display.section.selector='#main';}
if($(oTrigger).data('params')!==undefined){action.data.params=$(oTrigger).data('params');}
$(aviato.display.section.selector).html('').addClass("pending");action.on.success=aviato.display.section;break;case'upload':action.ajax.contentType=false;action.ajax.enctype='multipart/form-data';action.ajax.processData=false;var oForm=$(oTrigger).closest("form")[0];action.data=new FormData();action.data.append('action',$(oForm).data('handler'));var dataForm=$(oForm).serializeArray();$(dataForm).each(function(){action.data.append(this.name,this.value);})
$.each($('#fileUpload')[0].files,function(k,v){action.data.append(k,v);})
break;}
if($(oTrigger).data('serialize')!==undefined&&$(oTrigger).data('serialize')===true){var dataForm=$(oTrigger).closest("form").serializeArray();$(dataForm).each(function(){action.data[this.name]=this.value;})}
if($(oTrigger).data('before')!==undefined){action.before=$(oTrigger).data('before');}
if($(oTrigger).data('success')!==undefined){action.on.success=$(oTrigger).data('success');}
if($(oTrigger).data('error')!==undefined){action.on.error=$(oTrigger).data('error');}
if($(oTrigger).data('url')!==undefined){action.url=$(oTrigger).data('url');}
else{action.url=location.href;}
aviato.call.ajax(action);}};aviato.call.ajax=function(o){if(o===undefined){return false;}
if(o.before!==undefined){o.before(o);}
var ajaxSettings=o.ajax;ajaxSettings.data=o.data;ajaxSettings.error=function(XMLHttpRequest,textStatus,errorThrown){if(o.on.error!==undefined){o.on.error(XMLHttpRequest,textStatus,errorThrown);}}
ajaxSettings.success=function(data,textStatus,errorThrown){if(o.on.success!==undefined){o.on.success(data,textStatus,errorThrown);}
if(data.success!==true){$.each(data.log,function(){aviato.display.alert(this);})}}
ajaxSettings.url=o.url;$.ajax(ajaxSettings);};aviato.display.section=function(data){$(this.success.selector).html(data.data).removeClass("pending");aviato.bind(this.success.selector+' ');};aviato.display.alert=function(data){var style=data.type;if(style==='error'){style='danger';}
$('#alerts').append('<div class="alert alert-dismissible alert-'+style+'" role="alert">'
+'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
+'<span aria-hidden="true">&times;</span></button>'
+'<strong>'+data.type.toUpperCase()+'!</strong> '
+data.message
+'</div>');var alerts=$("#alerts>div").get();console.log(alerts.length);alerts=jQuery.unique(alerts);console.log(alerts.length);};