import{_ as p}from"./DriverAppLayout-1e421c3a.js";import{U as f,I as _}from"./InfiniteScroll-5a3d1ae1.js";import u from"./BasketDrop-98cfbb38.js";import{r as h,c as r,w as s,o as i,a as n,b as m,d as x}from"./app-db99a8de.js";import"./ToastList-a27e7632.js";import"./toast-fa86451f.js";import"./BasketButton-5e4097f8.js";import"./lodash-4ae8787a.js";import"./BarcodeSearchVerifyModal-7df29adb.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./transition-3d77d2f5.js";import"./ProductBasketDrop-4ec21434.js";const y={class:"flex justify-between items-center px-4 py-3 border-b"},g={key:0,class:"p-2 flex-1 text-center"},b=n("span",null," No results...",-1),k=[b],C={__name:"IndexHistory",props:{items:Object},setup(t){const o=t,c=h(o.items.meta.last_page),l=async e=>{if(e>c.value)return;let a=await axios.get(route("drivers.history.index",{page:e}));setTimeout(()=>{o.items.data.push(...a.data.data)},100)};return(e,a)=>(i(),r(p,{title:"History"},{header:s(()=>[n("div",y,[m(f,{title:"History"})])]),default:s(()=>[t.items.data.length==0?(i(),x("div",g,k)):(i(),r(_,{key:1,items:t.items.data,onRefetch:l,loadingText:"loading..."},{item:s(({item:d})=>[m(u,{item:d},null,8,["item"])]),_:1},8,["items"]))]),_:1}))}};export{C as default};