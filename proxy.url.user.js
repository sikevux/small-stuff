// ==UserScript==
// @name          Prx Auto redirect
// @namespace	*
// @description   Auto redirect to prx
// @include       *
// ==/UserScript==

var regExp = /facebook/i;
if (regExp.test(window.location.href))
window.location.replace(window.location.href.replace(/(.*)facebook/, "http://www.fxcxbxxk"));