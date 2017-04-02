/* jQuery Form Styler v1.6.1 | (c) Dimox | https://github.com/Dimox/jQueryFormStyler */
(function(c){"function"===typeof define&&define.amd?define(["jquery"],c):"object"===typeof exports?module.exports=c(require("jquery")):c(jQuery)})(function(c){c.fn.styler=function(v){var e=c.extend({wrapper:"form",idSuffix:"-styler",filePlaceholder:"\u0424\u0430\u0439\u043b \u043d\u0435 \u0432\u044b\u0431\u0440\u0430\u043d",fileBrowse:"\u041e\u0431\u0437\u043e\u0440...",selectPlaceholder:"\u0412\u044b\u0431\u0435\u0440\u0438\u0442\u0435...",selectSearch:!1,selectSearchLimit:10,selectSearchNotFound:"\u0421\u043e\u0432\u043f\u0430\u0434\u0435\u043d\u0438\u0439 \u043d\u0435 \u043d\u0430\u0439\u0434\u0435\u043d\u043e",
selectSearchPlaceholder:"\u041f\u043e\u0438\u0441\u043a...",selectVisibleOptions:0,singleSelectzIndex:"100",selectSmartPositioning:!0,onSelectOpened:function(){},onSelectClosed:function(){},onFormStyled:function(){}},v);return this.each(function(){function A(){var c="",n="",b="",h="";void 0!==a.attr("id")&&""!==a.attr("id")&&(c=' id="'+a.attr("id")+e.idSuffix+'"');void 0!==a.attr("title")&&""!==a.attr("title")&&(n=' title="'+a.attr("title")+'"');void 0!==a.attr("class")&&""!==a.attr("class")&&(b=
" "+a.attr("class"));var d=a.data(),g;for(g in d)""!==d[g]&&(h+=" data-"+g+'="'+d[g]+'"');this.id=c+h;this.title=n;this.classes=b}var a=c(this);if(a.is(":checkbox"))a.each(function(){if(1>a.parent("div.jq-checkbox").length){var e=function(){var e=new A,b=c("<div"+e.id+' class="jq-checkbox'+e.classes+'"'+e.title+'><div class="jq-checkbox__div"></div></div>');a.css({position:"absolute",zIndex:"-1",opacity:0,margin:0,padding:0}).after(b).prependTo(b);b.attr("unselectable","on").css({"-webkit-user-select":"none",
"-moz-user-select":"none","-ms-user-select":"none","-o-user-select":"none","user-select":"none",display:"inline-block",position:"relative",overflow:"hidden"});a.is(":checked")&&b.addClass("checked");a.is(":disabled")&&b.addClass("disabled");b.on("click.styler",function(){b.is(".disabled")||(a.is(":checked")?(a.prop("checked",!1),b.removeClass("checked")):(a.prop("checked",!0),b.addClass("checked")),a.change());return!1});a.closest("label").add('label[for="'+a.attr("id")+'"]').click(function(a){c(a.target).is("a")||
(b.click(),a.preventDefault())});a.on("change.styler",function(){a.is(":checked")?b.addClass("checked"):b.removeClass("checked")}).on("keydown.styler",function(a){32==a.which&&b.click()}).on("focus.styler",function(){b.is(".disabled")||b.addClass("focused")}).on("blur.styler",function(){b.removeClass("focused")})};e();a.on("refresh",function(){a.off(".styler").parent().before(a).remove();e()})}});else if(a.is(":radio"))a.each(function(){if(1>a.parent("div.jq-radio").length){var s=function(){var n=
new A,b=c("<div"+n.id+' class="jq-radio'+n.classes+'"'+n.title+'><div class="jq-radio__div"></div></div>');a.css({position:"absolute",zIndex:"-1",opacity:0,margin:0,padding:0}).after(b).prependTo(b);b.attr("unselectable","on").css({"-webkit-user-select":"none","-moz-user-select":"none","-ms-user-select":"none","-o-user-select":"none","user-select":"none",display:"inline-block",position:"relative"});a.is(":checked")&&b.addClass("checked");a.is(":disabled")&&b.addClass("disabled");b.on("click.styler",
function(){b.is(".disabled")||(b.closest(e.wrapper).find('input[name="'+a.attr("name")+'"]').prop("checked",!1).parent().removeClass("checked"),a.prop("checked",!0).parent().addClass("checked"),a.change());return!1});a.closest("label").add('label[for="'+a.attr("id")+'"]').click(function(a){c(a.target).is("a")||(b.click(),a.preventDefault())});a.on("change.styler",function(){a.parent().addClass("checked")}).on("focus.styler",function(){b.is(".disabled")||b.addClass("focused")}).on("blur.styler",function(){b.removeClass("focused")})};
s();a.on("refresh",function(){a.off(".styler").parent().before(a).remove();s()})}});else if(a.is(":file"))a.css({position:"absolute",top:0,right:0,width:"100%",height:"100%",opacity:0,margin:0,padding:0}).each(function(){if(1>a.parent("div.jq-file").length){var s=function(){var n=new A,b=a.data("placeholder");void 0===b&&(b=e.filePlaceholder);var h=a.data("browse");if(void 0===h||""===h)h=e.fileBrowse;var d=c("<div"+n.id+' class="jq-file'+n.classes+'"'+n.title+' style="display: inline-block; position: relative; overflow: hidden"></div>'),
g=c('<div class="jq-file__name">'+b+"</div>").appendTo(d);c('<div class="jq-file__browse">'+h+"</div>").appendTo(d);a.after(d);d.append(a);a.is(":disabled")&&d.addClass("disabled");a.on("change.styler",function(){var c=a.val();if(a.is("[multiple]"))for(var c="",e=a[0].files,n=0;n<e.length;n++)c+=(0<n?", ":"")+e[n].name;g.text(c.replace(/.+[\\\/]/,""));""===c?(g.text(b),d.removeClass("changed")):d.addClass("changed")}).on("focus.styler",function(){d.addClass("focused")}).on("blur.styler",function(){d.removeClass("focused")}).on("click.styler",
function(){d.removeClass("focused")})};s();a.on("refresh",function(){a.off(".styler").parent().before(a).remove();s()})}});else if(a.is("select"))a.each(function(){if(1>a.parent("div.jqselect").length){var s=function(){function n(a){a.off("mousewheel DOMMouseScroll").on("mousewheel DOMMouseScroll",function(a){var b=null;"mousewheel"==a.type?b=-1*a.originalEvent.wheelDelta:"DOMMouseScroll"==a.type&&(b=40*a.originalEvent.detail);b&&(a.stopPropagation(),a.preventDefault(),c(this).scrollTop(b+c(this).scrollTop()))})}
function b(){for(var a=0,c=g.length;a<c;a++){var b="",e="",n=b="",d="",p="",w="";g.eq(a).prop("selected")&&(e="selected sel");g.eq(a).is(":disabled")&&(e="disabled");g.eq(a).is(":selected:disabled")&&(e="selected sel disabled");void 0!==g.eq(a).attr("class")&&(d=" "+g.eq(a).attr("class"),w=' data-jqfs-class="'+g.eq(a).attr("class")+'"');var u=g.eq(a).data(),f;for(f in u)""!==u[f]&&(n+=" data-"+f+'="'+u[f]+'"');""!==e+d&&(b=' class="'+e+d+'"');b="<li"+w+n+b+">"+g.eq(a).html()+"</li>";g.eq(a).parent().is("optgroup")&&
(void 0!==g.eq(a).parent().attr("class")&&(p=" "+g.eq(a).parent().attr("class")),b="<li"+w+' class="'+e+d+" option"+p+'">'+g.eq(a).html()+"</li>",g.eq(a).is(":first-child")&&(b='<li class="optgroup'+p+'">'+g.eq(a).parent().attr("label")+"</li>"+b));s+=b}}function h(){var d=new A,r="",k=a.data("placeholder"),y=a.data("search"),h=a.data("search-limit"),x=a.data("search-not-found"),p=a.data("search-placeholder"),w=a.data("z-index"),u=a.data("smart-positioning");void 0===k&&(k=e.selectPlaceholder);if(void 0===
y||""===y)y=e.selectSearch;if(void 0===h||""===h)h=e.selectSearchLimit;if(void 0===x||""===x)x=e.selectSearchNotFound;void 0===p&&(p=e.selectSearchPlaceholder);if(void 0===w||""===w)w=e.singleSelectzIndex;if(void 0===u||""===u)u=e.selectSmartPositioning;var f=c("<div"+d.id+' class="jq-selectbox jqselect'+d.classes+'" style="display: inline-block; position: relative; z-index:'+w+'"><div class="jq-selectbox__select"'+d.title+' style="position: relative"><div class="jq-selectbox__select-text"></div><div class="jq-selectbox__trigger"><div class="jq-selectbox__trigger-arrow"></div></div></div></div>');
a.css({margin:0,padding:0}).after(f).prependTo(f);var E=c("div.jq-selectbox__select",f),t=c("div.jq-selectbox__select-text",f),d=g.filter(":selected");b();y&&(r='<div class="jq-selectbox__search"><input type="search" autocomplete="off" placeholder="'+p+'"></div><div class="jq-selectbox__not-found">'+x+"</div>");var l=c('<div class="jq-selectbox__dropdown" style="position: absolute">'+r+'<ul style="position: relative; list-style: none; overflow: auto; overflow-x: hidden">'+s+"</ul></div>");f.append(l);
var q=c("ul",l),m=c("li",l),z=c("input",l),v=c("div.jq-selectbox__not-found",l).hide();m.length<h&&z.parent().hide();""===a.val()?t.text(k).addClass("placeholder"):t.text(d.text());var B=0,F=0;m.each(function(){var a=c(this);a.css({display:"inline-block"});a.innerWidth()>B&&(B=a.innerWidth(),F=a.width());a.css({display:""})});r=f.clone().appendTo("body").width("auto");k=r.find("select").outerWidth();r.remove();k==f.width()&&t.width(F);B>f.width()&&l.width(B);t.is(".placeholder")&&t.width()>B&&t.width(t.width());
""===g.first().text()&&""!==a.data("placeholder")&&m.first().hide();a.css({position:"absolute",left:0,top:0,width:"100%",height:"100%",opacity:0});var G=f.outerHeight(),C=z.outerHeight(),D=q.css("max-height"),r=m.filter(".selected");1>r.length&&m.first().addClass("selected sel");void 0===m.data("li-height")&&m.data("li-height",m.outerHeight());var H=l.css("top");"auto"==l.css("left")&&l.css({left:0});"auto"==l.css("top")&&l.css({top:G});l.hide();r.length&&(g.first().text()!=d.text()&&f.addClass("changed"),
f.data("jqfs-class",r.data("jqfs-class")),f.addClass(r.data("jqfs-class")));if(a.is(":disabled"))return f.addClass("disabled"),!1;E.click(function(){c("div.jq-selectbox").filter(".opened").length&&e.onSelectClosed.call(c("div.jq-selectbox").filter(".opened"));a.focus();if(!navigator.userAgent.match(/(iPad|iPhone|iPod)/i)){var b=c(window),p=m.data("li-height"),d=f.offset().top,r=b.height()-G-(d-b.scrollTop()),k=a.data("visible-options");if(void 0===k||""===k)k=e.selectVisibleOptions;var y=5*p,h=p*
k;0<k&&6>k&&(y=h);0===k&&(h="auto");var k=function(){l.height("auto").css({bottom:"auto",top:H});var a=function(){q.css("max-height",Math.floor((r-20-C)/p)*p)};a();q.css("max-height",h);"none"!=D&&q.css("max-height",D);r<l.outerHeight()+20&&a()},t=function(){l.height("auto").css({top:"auto",bottom:H});var a=function(){q.css("max-height",Math.floor((d-b.scrollTop()-20-C)/p)*p)};a();q.css("max-height",h);"none"!=D&&q.css("max-height",D);d-b.scrollTop()-20<l.outerHeight()+20&&a()};!0===u||1===u?r>y+
C+20?(k(),f.removeClass("dropup").addClass("dropdown")):(t(),f.removeClass("dropdown").addClass("dropup")):(!1===u||0===u)&&r>y+C+20&&(k(),f.removeClass("dropup").addClass("dropdown"));c("div.jqselect").css({zIndex:w-1}).removeClass("opened");f.css({zIndex:w});l.is(":hidden")?(c("div.jq-selectbox__dropdown:visible").hide(),l.show(),f.addClass("opened focused"),e.onSelectOpened.call(f)):(l.hide(),f.removeClass("opened dropup dropdown"),c("div.jq-selectbox").filter(".opened").length&&e.onSelectClosed.call(f));
z.length&&(z.val("").keyup(),v.hide(),z.keyup(function(){var b=c(this).val();m.each(function(){c(this).html().match(RegExp(".*?"+b+".*?","i"))?c(this).show():c(this).hide()});""===g.first().text()&&""!==a.data("placeholder")&&m.first().hide();1>m.filter(":visible").length?v.show():v.hide()}));m.filter(".selected").length&&(0!==q.innerHeight()/p%2&&(p/=2),q.scrollTop(q.scrollTop()+m.filter(".selected").position().top-q.innerHeight()/2+p));n(q);return!1}});m.hover(function(){c(this).siblings().removeClass("selected")});
m.filter(".selected").text();m.filter(".selected").text();m.filter(":not(.disabled):not(.optgroup)").click(function(){a.focus();var b=c(this),p=b.text();if(!b.is(".selected")){var d=b.index(),d=d-b.prevAll(".optgroup").length;b.addClass("selected sel").siblings().removeClass("selected sel");g.prop("selected",!1).eq(d).prop("selected",!0);t.text(p);f.data("jqfs-class")&&f.removeClass(f.data("jqfs-class"));f.data("jqfs-class",b.data("jqfs-class"));f.addClass(b.data("jqfs-class"));a.change()}l.hide();
f.removeClass("opened dropup dropdown");e.onSelectClosed.call(f)});l.mouseout(function(){c("li.sel",l).addClass("selected")});a.on("change.styler",function(){t.text(g.filter(":selected").text()).removeClass("placeholder");m.removeClass("selected sel").not(".optgroup").eq(a[0].selectedIndex).addClass("selected sel");g.first().text()!=m.filter(".selected").text()?f.addClass("changed"):f.removeClass("changed")}).on("focus.styler",function(){f.addClass("focused");c("div.jqselect").not(".focused").removeClass("opened dropup dropdown").find("div.jq-selectbox__dropdown").hide()}).on("blur.styler",
function(){f.removeClass("focused")}).on("keydown.styler keyup.styler",function(c){var b=m.data("li-height");t.text(g.filter(":selected").text());m.removeClass("selected sel").not(".optgroup").eq(a[0].selectedIndex).addClass("selected sel");38!=c.which&&37!=c.which&&33!=c.which&&36!=c.which||q.scrollTop(q.scrollTop()+m.filter(".selected").position().top);40!=c.which&&39!=c.which&&34!=c.which&&35!=c.which||q.scrollTop(q.scrollTop()+m.filter(".selected").position().top-q.innerHeight()+b);13==c.which&&
(c.preventDefault(),l.hide(),f.removeClass("opened dropup dropdown"),e.onSelectClosed.call(f))}).on("keydown.styler",function(a){32==a.which&&(a.preventDefault(),E.click())});c(document).on("click",function(a){c(a.target).parents().hasClass("jq-selectbox")||"OPTION"==a.target.nodeName||(c("div.jq-selectbox").filter(".opened").length&&e.onSelectClosed.call(c("div.jq-selectbox").filter(".opened")),z.length&&z.val("").keyup(),l.hide().find("li.sel").addClass("selected"),f.removeClass("focused opened dropup dropdown"))})}
function d(){var e=new A,d=c("<div"+e.id+' class="jq-select-multiple jqselect'+e.classes+'"'+e.title+' style="display: inline-block; position: relative"></div>');a.css({margin:0,padding:0}).after(d);b();d.append("<ul>"+s+"</ul>");var k=c("ul",d).css({position:"relative","overflow-x":"hidden","-webkit-overflow-scrolling":"touch"}),h=c("li",d).attr("unselectable","on"),e=a.attr("size"),v=k.outerHeight(),x=h.outerHeight();void 0!==e&&0<e?k.css({height:x*e}):k.css({height:4*x});v>d.height()&&(k.css("overflowY",
"scroll"),n(k),h.filter(".selected").length&&k.scrollTop(k.scrollTop()+h.filter(".selected").position().top));a.prependTo(d).css({position:"absolute",left:0,top:0,width:"100%",height:"100%",opacity:0});if(a.is(":disabled"))d.addClass("disabled"),g.each(function(){c(this).is(":selected")&&h.eq(c(this).index()).addClass("selected")});else if(h.filter(":not(.disabled):not(.optgroup)").click(function(b){a.focus();var d=c(this);b.ctrlKey||b.metaKey||d.addClass("selected");b.shiftKey||d.addClass("first");
b.ctrlKey||(b.metaKey||b.shiftKey)||d.siblings().removeClass("selected first");if(b.ctrlKey||b.metaKey)d.is(".selected")?d.removeClass("selected first"):d.addClass("selected first"),d.siblings().removeClass("first");if(b.shiftKey){var e=!1,f=!1;d.siblings().removeClass("selected").siblings(".first").addClass("selected");d.prevAll().each(function(){c(this).is(".first")&&(e=!0)});d.nextAll().each(function(){c(this).is(".first")&&(f=!0)});e&&d.prevAll().each(function(){if(c(this).is(".selected"))return!1;
c(this).not(".disabled, .optgroup").addClass("selected")});f&&d.nextAll().each(function(){if(c(this).is(".selected"))return!1;c(this).not(".disabled, .optgroup").addClass("selected")});1==h.filter(".selected").length&&d.addClass("first")}g.prop("selected",!1);h.filter(".selected").each(function(){var a=c(this),b=a.index();a.is(".option")&&(b-=a.prevAll(".optgroup").length);g.eq(b).prop("selected",!0)});a.change()}),g.each(function(a){c(this).data("optionIndex",a)}),a.on("change.styler",function(){h.removeClass("selected");
var a=[];g.filter(":selected").each(function(){a.push(c(this).data("optionIndex"))});h.not(".optgroup").filter(function(b){return-1<c.inArray(b,a)}).addClass("selected")}).on("focus.styler",function(){d.addClass("focused")}).on("blur.styler",function(){d.removeClass("focused")}),v>d.height())a.on("keydown.styler",function(a){38!=a.which&&37!=a.which&&33!=a.which||k.scrollTop(k.scrollTop()+h.filter(".selected").position().top-x);40!=a.which&&39!=a.which&&34!=a.which||k.scrollTop(k.scrollTop()+h.filter(".selected:last").position().top-
k.innerHeight()+2*x)})}var g=c("option",a),s="";if(a.is("[multiple]")){var v=navigator.userAgent.match(/Android/i)?!0:!1,I=navigator.userAgent.match(/(iPad|iPhone|iPod)/i)?!0:!1;v||I||d()}else h()};s();a.on("refresh",function(){a.off(".styler").parent().before(a).remove();s()})}});else if(a.is(":reset"))a.on("click",function(){setTimeout(function(){a.closest(e.wrapper).find("input, select").trigger("refresh")},1)})}).promise().done(function(){e.onFormStyled.call()})}});