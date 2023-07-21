import{r as p,c as l,w as i,o as r,a as t,b as m,d as x,f as h,t as s,q as f}from"./app-db99a8de.js";import{_ as u}from"./DriverAppLayout-1e421c3a.js";import{U as w,I as g}from"./InfiniteScroll-5a3d1ae1.js";import"./ToastList-a27e7632.js";import"./toast-fa86451f.js";import"./BasketButton-5e4097f8.js";import"./lodash-4ae8787a.js";import"./BarcodeSearchVerifyModal-7df29adb.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./transition-3d77d2f5.js";const y={class:"flex justify-between items-center px-4 py-3 border-b"},v={key:0,class:"p-2 flex-1 text-center"},b=t("span",null," No results...",-1),k=[b],N={class:"bg-white shadow rounded mb-2 py-2 px-3 my-2 mx-1"},B={class:"flex flex-row justify-between"},j={class:"flex-1 flex"},I=["src","alt"],T={class:"ml-2"},V={class:"text-xs text-purple-600"},C={class:"text-gray-600 font-semibold"},P={class:"text-[10px] text-purple-900 font-medium"},S={class:"text-gray-600 text-[9px]"},U={class:"text-gray-400"},q={class:"flex items-center"},D=t("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor",class:"w-3 h-3"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M4.5 12.75l6 6 9-13.5"})],-1),E={class:"ml-1 text-[8px]"},K={__name:"IndexNotifications",props:{items:Object},setup(o){const n=o,d=p(n.items.last_page),_=async a=>{if(a>d.value)return;let c=await f.get(route("system.notifications.index",{page:a}));setTimeout(()=>{n.items.data.push(...c.data.data)},100)};return(a,c)=>(r(),l(u,{title:"Notifications"},{header:i(()=>[t("div",y,[m(w,{title:"Notifications"})])]),default:i(()=>[o.items.data.length==0?(r(),x("div",v,k)):(r(),l(g,{key:1,items:o.items.data,onRefetch:_,loadingText:"loading..."},{item:i(({item:e})=>[t("div",N,[t("div",B,[t("div",j,[t("img",{src:e.data.user.profile_photo_url,alt:e.data.user.name,class:"w-11 h-11"},null,8,I),t("div",T,[t("p",V,[h(" @"+s(e.data.user.name)+" ",1),t("span",C,s(e.data.method)+": ",1)]),t("p",P,s(e.data.order_drop.order_sn),1),t("p",S,s(e.created_at),1)])]),t("div",U,[t("p",q,[D,t("span",E,s(e.read_at),1)])])])])]),_:1},8,["items"]))]),_:1}))}};export{K as default};