(()=>{"use strict";var e={5311:e=>{e.exports=jQuery}},t={};function i(n){var o=t[n];if(void 0!==o)return o.exports;var s=t[n]={exports:{}};return e[n](s,s.exports,i),s.exports}i.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return i.d(t,{a:t}),t},i.d=(e,t)=>{for(var n in t)i.o(t,n)&&!i.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},i.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e=i(5311),t=i.n(e);document.addEventListener("DOMContentLoaded",(function(){n.init()}));let n={interval:[],init:function(e){this.holder=document.querySelectorAll(".qi-block-cards-slider"),this.holder.length&&[...this.holder].map((t=>{n.initItem(t,e)}))},getRealCurrentItem:function(e){return"string"==typeof e&&""!==e&&(e=qiBlocksEditor.qodefGetCurrentBlockElement.get(e)),e},initItem:function(e,t){const i=t?e:0;if(!(e=n.getRealCurrentItem(e)))return;("object"!=typeof qiBlocksEditor?qiBlocks:qiBlocksEditor).qodefWaitForImages.check(e,(function(){n.sliderLoop(e,t,i)}))},sliderLoop:function(e,i,o){let s,r=t()(e),c=e.querySelectorAll(".qodef-m-card"),a=e.getAttribute("data-orientation"),d=r.find(".qodef--next"),l=r.find(".qodef--prev"),f=!1;switch("reinit"===i&&clearInterval(n.interval[o]),a){case"left":s="-10%";break;case"right":s="10%"}function u(){let i=c[c.length-1],n=c[0];if(!i.classList.contains("qodef-out")){i.classList.add("qodef-out");const o=t()(i);o.off().animate({right:s},350,"swing",(function(){o.detach().insertBefore(n).animate({right:"0%"},450,"swing",(function(){setTimeout((function(){i.classList.remove("qodef-out")}),10)})),c=e.querySelectorAll(".qodef-m-card")}))}}n.interval[o]=setInterval((function(){!f&&e.classList.contains("qodef-in-view")&&u()}),3e3),n.isInView(e),"object"==typeof qiBlocks&&qiBlocks.windowWidth>1024||document.body.classList.contains("qi-preview-screen-desktop")?r.on("mouseenter",(function(){f=!0})).on("mouseleave",(function(){f=!1})):r.on("touchstart",(function(){f=!0})).on("touchend",(function(){setTimeout((function(){f=!1}),2e3)})),d.on("click",u),l.on("click",(function(){let i=c[c.length-1],n=c[0];if(!n.classList.contains("qodef-in")){e.classList.add("qodef-backwards"),n.classList.add("qodef-in");const o=t()(n);o.off().animate({right:s},350,"swing",(function(){o.detach().insertAfter(i).animate({right:"0"},450,"swing",(function(){n.classList.remove("qodef-in"),e.classList.remove("qodef-backwards")})),c=e.querySelectorAll(".qodef-m-card")}))}}))},isInView:function(e){new IntersectionObserver((function(t){!0===t[0].isIntersecting?e.classList.add("qodef-in-view"):e.classList.remove("qodef-in-view")}),{threshold:[.15]}).observe(e),document.addEventListener("visibilitychange",(function(){"visible"===document.visibilityState?e.classList.add("qodef-in-view"):e.classList.remove("qodef-in-view")}))}}})()})();