/* 
Aviato-Lib.js, build #01.23.11 from 2023-03-17 19:21:31.
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
return-1;};}"use strict";let aviato={bootstrap:{},call:{},display:{},fn:{},jq:{element:{}},on:{}};aviato.fn.arrayMap=function(arNames,arValues){var oReturn={};var i;var iMax=Math.min(arNames.length,arValues.length);for(i=0;i<iMax;i++){oReturn[arNames[i]]=arValues[i];}
return oReturn;}
aviato.fn.atos=function(a,p){var i,r='',iCount=a.length;for(i=0;i<iCount;i++){r+=p.supplant(a[i]);}
return r;};aviato.fn.filterProperties=function(obj){let entries=Object.entries(obj);let filter=entries.filter(function(item){return(typeof(item[1])==="number"||typeof(item[1])==="string")});return(Object.fromEntries(filter));}
aviato.fn.formToLocalStorage=function(selector){var oFormValues=$(selector).serializeArray();localStorage.setItem(selector,JSON.stringify(oFormValues));};aviato.fn.getUrlVars=function(sUrl){if(typeof(sUrl)==='undefined'){sUrl=window.location.href;}
var vars=[],hash;var hashes=sUrl.slice(sUrl.indexOf('?')+1).split('&');for(var i=0;i<hashes.length;i++){hash=hashes[i].split('=');vars.push(hash[0]);vars[hash[0]]=hash[1];}
return vars;};aviato.fn.localStorageToForm=function(selector){var oFormValues=JSON.parse(localStorage.getItem(selector));$(oFormValues).each(function(){$(selector+' [name="'+this.name+'"]').val(this.value);});};aviato.fn.method=function(fname){var fn;if(typeof fname==='string'||fname instanceof String){if(fname.indexOf('.')!==-1){fname=fname.split('.');fn=window[fname[0]];for(var i=1;i<fname.length;i++){fn=fn[fname[i]];}}
else{fn=window[fname];}}
return fn;}
aviato.fn.strech=function(o,p={}){let defaults={widthMargin:10,maxWidth:0,heightMargin:5,maxHeight:0,cloneId:'clone-'+o.id}
for(let v in defaults){if(p[v]===undefined){p[v]=defaults[v];}}
var elClone=document.getElementById(p.cloneId);if(elClone===null){elClone=document.createElement('pre');elClone.setAttribute('id',p.cloneId);elClone.style.display="inline-block";elClone.style.position="absolute";elClone.style.right="99999px";elClone.style.border="1px solid #99f";elClone.style.padding="2px";elClone.style.zIndex="-1";document.body.appendChild(elClone);o.addEventListener("blur",function(){elClone.parentElement.removeChild(elClone)},{once:true});}
elClone.innerText=(o.value);let recall=false;if(p.maxWidth!==-1){if(p.maxWidth==0||o.clientWidth<p.maxWidth){if((elClone.clientWidth+p.widthMargin)>o.clientWidth){o.cols++;recall=true;}}}
if(p.maxHeight!==-1){if(p.maxHeight==0||o.clientHeight<p.maxHeight){if((elClone.clientHeight+p.heightMargin)>o.clientHeight){o.rows++;recall=true;}}}
if(recall){aviato.fn.strech(o,p);}}
aviato.bootstrap.isXs=function(){return($('.navbar-toggle:visible').length>0);};aviato.bootstrap.showCollapseByLocationHash=function(parentId,closeOthers){if(closeOthers===undefined){closeOthers=false;}
if(window.location.hash.length>1){if($('#'+parentId+' a[href="'+window.location.hash+'"]').data('toggle')==='collapse'){if(closeOthers===true){$('#'+parentId+' .panel-collapse.in').collapse('hide');}
if(!$(window.location.hash).hasClass('in')){$(window.location.hash).collapse('show');}}}};aviato.bootstrap.addCollapseItem=function(oItemProperties,bAppendToParent){if(bAppendToParent===undefined){bAppendToParent=false;}
let itemProperties={'class':'default','content':'','id':'collapseItem','isCollapse':'','isCurrent':'','parentId':'accordion','title':'Collapsible Group Item'};$.extend(itemProperties,oItemProperties);var sPattern='<div class="panel panel-{class}">'+'<div class="panel-heading {isCurrent}">'+'<h4 class="panel-title">'+'<a data-toggle="collapse" data-parent="#{parentId}" href="#{id}">{title}</a>'+'</h4>'+'</div>'+'<div id="{id}" class="panel-collapse collapse {isCollapse}">'+'<div class="panel-body">{content}</div>'+'</div>'+'</div>';let item=sPattern.supplant(itemProperties);if(bAppendToParent){$('#'+itemProperties.parentId).append(item);return true;}
else{return item;}};aviato.bind=function(selector){if(selector===undefined){selector='';}
else{selector+=' ';}
$(selector+'[data-action]').on('click',function(){aviato.on.click(this);});if(this.offcanvas===undefined){this.offcanvas=new bootstrap.Offcanvas(document.getElementById('offcanvas'));document.getElementById('offcanvas').addEventListener('hidden.bs.offcanvas',function(){$('#alerts').html('');})}};aviato.jq.element.button=function(button,selector){if(selector===undefined){selector='';}
else{selector+=' ';}
return($(selector+'[data-type="button"][data-'+button+']'));};aviato.on.click=function(oTrigger){let $trigger=$(oTrigger);if($trigger.data('action')!==undefined){$trigger.find('[data-role="spinner"]').removeClass('d-none');$trigger.find('[data-role="btn-icon"]').addClass('d-none');var action={ajax:{async:true,cache:false,dataType:'json',headers:{'cache-control':'no-cache','Access-Control-Allow-Origin':'*'},type:'POST'},data:aviato.fn.filterProperties($trigger.data()),on:{},trigger:$trigger};var target=$trigger.data('target');switch($trigger.data('action')){case'section':action.data.section=$trigger.data('section');if(target===undefined){target='main';action.data.target=target;}
$(target).html('');break;case'upload':action.ajax.contentType=false;action.ajax.enctype='multipart/form-data';action.ajax.processData=false;var oForm=$trigger.closest("form")[0];var formData=new FormData();for(var key in action.data){formData.append(key,action.data[key]);}
formData.append('handler',$(oForm).data('handler'));dataForm=$(oForm).serializeArray();$(dataForm).each(function(){formData.append(this.name,this.value);})
$.each($('#fileUpload')[0].files,function(k,v){formData.append(k,v);})
action.data=formData;break;}
if($trigger.data('serialize')!==undefined&&$trigger.data('serialize')===true){var dataForm=$trigger.closest("form").serializeArray();$(dataForm).each(function(){action.data[this.name]=this.value;})}
if(target!==undefined){aviato.display.selector=target;$(aviato.display.selector).addClass('pending');}
if($trigger.data('dyn')!==undefined){$trigger.removeData('dyn');}
if($trigger.data('before')!==undefined){action.before=$trigger.data('before');}
if($trigger.data('success')!==undefined){action.on.success=aviato.fn.method($trigger.data('success'));}
if($trigger.data('complete')!==undefined){action.on.complete=aviato.fn.method($trigger.data('complete'));}
if($trigger.data('error')!==undefined){action.on.error=aviato.fn.method($trigger.data('error'));}
if($trigger.data('url')!==undefined){action.url=$trigger.data('url');}
else{action.url=location.href;}
if($trigger.data('verbose')!==undefined){action.verbose=($trigger.data('verbose')===true);}
aviato.call.ajax(action);}};aviato.on.clickAgain=function(o){aviato.offcanvas.hide();let trigger=$(o).data('trigger');$(trigger).data('dyn',$(o).data('dyn'));setTimeout(function(){aviato.on.click(trigger);},500);}
aviato.call.ajax=function(o){if(o===undefined){return false;}
let $trigger=$(o.trigger);if(o.before!==undefined){o.before(o);$trigger.find('[data-role="spinner"]').removeClass('d-none');$trigger.find('[data-role="btn-icon"]').addClass('d-none');if($trigger.prop('tagName')==='A'){$trigger.addClass('disabled')}
if($trigger.prop('tagName')==='BUTTON'){$trigger.prop('disabled',true);}}
var ajaxSettings=o.ajax;ajaxSettings.data=o.data;ajaxSettings.error=function(XMLHttpRequest,textStatus,errorThrown){if(o.on.error!==undefined){o.on.error(XMLHttpRequest,textStatus,errorThrown);}}
ajaxSettings.success=function(data,textStatus,jqXHR){if(data.location!==undefined){location=data.location;}
if(typeof data.data==='string'||data.data instanceof String){aviato.display.content(data.data);}
if(data.success!==true||(o.verbose!==undefined&&o.verbose===true)){aviato.display.logs(data.log);}
if(o.on.success!==undefined){o.on.success(data,textStatus,jqXHR);}}
ajaxSettings.complete=function(jqXHR,textStatus){$trigger.find('[data-role="spinner"]').addClass('d-none');$trigger.find('[data-role="btn-icon"]').removeClass('d-none');if($trigger.prop('tagName')==='A'){$trigger.removeClass('disabled')}
if($trigger.prop('tagName')==='BUTTON'){$trigger.prop('disabled',false);}
if(o.on.complete!==undefined){o.on.complete(jqXHR,textStatus);}}
ajaxSettings.url=o.url;$.ajax(ajaxSettings);};aviato.display.content=function(data){if(this.selector!==undefined){if($(this.selector).prop('tagName')==='INPUT'){$(this.selector).val(data);}
else{$(this.selector).html(data);}
$(this.selector).removeClass("pending");aviato.bind(this.selector+' ');}
delete this.selector;};aviato.display.logs=function(logs,targetSelector='#alerts'){$.each(logs,function(){aviato.display.alert(this,targetSelector);});aviato.bind(targetSelector);aviato.offcanvas.show();}
aviato.display.alert=function(data,targetSelector='#alerts'){var style=data.type;if(style==='error'){style='danger';}
if($(targetSelector).length===0){$('body').append('<div id="alerts" class="p-3" data-role="alerts"></div>');}
let alertHtml=''
+'<div class="alert alert-'+style+' alert-dismissible" role="alert">'
+'<span>'+data.message+'</span>'
+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
+'</div>';$(targetSelector).append(alertHtml);};aviato.fn.sort=function(triggerId){var a=[];$('#'+triggerId+' th>button.sort').each(function(){a.push($(this).data('sort'))});var options={valueNames:a};var table=new List(triggerId,options);}