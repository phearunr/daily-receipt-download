import{d as s,a as t,t as o,f as n,F as c,o as r}from"./app-db99a8de.js";const l={class:"overflow-hidden border border-gray-100 flex-shrink-0 w-16 h-16 bg-gray-100 rounded lg:w-16 lg:h-16"},a=["src"],d={class:"text-sm font-semibold text-gray-600 break-all rounded focus:outline-none focus:ring-2 focus:ring-blue-500"},i={class:"text-sm text-gray-500 break-all"},u={class:"text-gray-600 font-semibold"},_={class:"text-sm text-gray-500 break-all flex items-center"},h={class:"text-gray-600 font-semibold"},g={class:"ml"},p={key:0,xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor",class:"w-5 h-5 text-red-600"},x=t("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M6 18L18 6M6 6l12 12"},null,-1),m=[x],k={key:1,xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor",class:"w-5 h-5 text-purple-600"},w=t("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M4.5 12.75l6 6 9-13.5"},null,-1),f=[w],B={__name:"ProductBasketDrop",props:{product:Object,currency:String},setup(e){return(y,b)=>(r(),s(c,null,[t("div",l,[t("img",{src:e.product.product_image,class:"object-cover"},null,8,a)]),t("div",null,[t("span",d,o(e.product.product_name),1),t("p",i,[n(" Unit Price: "),t("span",u,o(e.product.product_price)+o(e.currency)+" x "+o(e.product.order_quantity),1)]),t("p",_,[n(" Drop Quantity: "),t("span",h,o(e.product.drop_quantity),1),t("button",g,[e.product.drop_status==0?(r(),s("svg",p,m)):(r(),s("svg",k,f))])])])],64))}};export{B as default};