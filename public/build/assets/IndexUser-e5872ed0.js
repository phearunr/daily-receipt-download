import{l as S}from"./lodash-4ae8787a.js";import{_ as M}from"./AppLayout-1ab2dada.js";import{o as c,d,a as e,t as a,n as f,k as g,A as v,P as k,e as P,s as A,F as p,g as _,i as q,c as B,w as x,z as m,b as u,v as N,f as V}from"./app-db99a8de.js";import{_ as b}from"./_plugin-vue_export-helper-c27b6911.js";import"./ToastList-a27e7632.js";import"./toast-fa86451f.js";import"./DropdownLink-90b6c403.js";const E={name:"Pagination",props:{pagination:Object},data(){return{page:this.pagination.current_page}},watch:{"pagination.current_page":function(l){this.page=l}},methods:{loadPage(l){this.$inertia.get(this.$page.url,{page:l},{preserveState:!0})}},computed:{noPreviousPage(){return this.pagination.current_page-1<=0},noNextPage(){return this.pagination.current_page+1>this.pagination.last_page}}},I={class:"inline-flex justify-center items-center"},U={class:"hidden mr-2 text-sm text-gray-600 lg:block"},L={key:0,class:"flex space-x-1 items-top"},$=["disabled"],z=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-4 h-4 lg:h-3 lg:w-3",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M11 19l-7-7 7-7m8 14l-7-7 7-7"})],-1),D=[z],F=["disabled"],K=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-4 h-4 lg:h-3 lg:w-3",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M15 19l-7-7 7-7"})],-1),O=[K],T={class:"flex flex-col space-y-2 md:flex-row md:space-y-0 md:items-center md:space-x-1"},H={class:"px-2 text-gray-600 lg:text-sm"},R=["disabled"],G=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-4 h-4 lg:h-3 lg:w-3",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M9 5l7 7-7 7"})],-1),J=[G],Q=["disabled"],W=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-4 h-4 lg:h-3 lg:w-3",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M13 5l7 7-7 7M5 5l7 7-7 7"})],-1),X=[W];function Y(l,t,n,w,i,o){return c(),d("div",I,[e("div",U,a(n.pagination.total)+" items",1),n.pagination.last_page>1?(c(),d("div",L,[e("button",{disabled:o.noPreviousPage,class:f([{"opacity-50":o.noPreviousPage},"inline-flex justify-center items-center w-11 h-11 text-gray-700 bg-white rounded border border-gray-200 shadow-sm outline-none hover:bg-gray-50 lg:h-9 lg:w-9 lg:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500"]),onClick:t[0]||(t[0]=r=>o.loadPage(1))},D,10,$),e("button",{disabled:o.noPreviousPage,class:f([{"opacity-50":o.noPreviousPage},"inline-flex justify-center items-center w-11 h-11 text-gray-700 bg-white rounded border border-gray-200 shadow-sm outline-none hover:bg-gray-50 lg:h-9 lg:w-9 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"]),onClick:t[1]||(t[1]=r=>o.loadPage(n.pagination.current_page-1))},O,10,F),e("div",T,[g(e("input",{type:"number",onKeydown:t[2]||(t[2]=k(r=>o.loadPage(i.page),["enter"])),"onUpdate:modelValue":t[3]||(t[3]=r=>i.page=r),class:"px-2 w-11 h-11 text-center rounded border border-gray-400 shadow-sm lg:h-9 lg:w-11 lg:text-sm focus:ring-blue-500 focus:border-blue-500"},null,544),[[v,i.page]]),e("div",H,"of "+a(n.pagination.last_page),1)]),e("button",{disabled:o.noNextPage,class:f([{"opacity-50":o.noNextPage},"inline-flex justify-center items-center w-11 h-11 text-gray-700 bg-white rounded border border-gray-300 shadow-sm outline-none hover:bg-gray-50 lg:h-9 lg:w-9 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"]),onClick:t[4]||(t[4]=r=>o.loadPage(n.pagination.current_page+1))},J,10,R),e("button",{disabled:o.noNextPage,class:f([{"opacity-50":o.noNextPage},"inline-flex justify-center items-center w-11 h-11 text-gray-700 bg-white rounded border border-gray-300 shadow-sm outline-none hover:bg-gray-50 lg:h-9 lg:w-9 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"]),onClick:t[5]||(t[5]=r=>o.loadPage(n.pagination.last_page))},X,10,Q)])):P("",!0)])}const Z=b(E,[["render",Y]]),ee={name:"SelectAction",props:{pagers:Array,actions:Array},data(){return{pagerId:15,actionId:null}}},te={class:"space-x-2 flex"},se=["value"];function oe(l,t,n,w,i,o){return c(),d("div",te,[g(e("select",{"onUpdate:modelValue":t[0]||(t[0]=r=>i.actionId=r),"aria-label":"Action",name:"action",class:"pr-10 pl-3 w-full h-11 rounded border-gray-300 shadow-sm lg:h-9 lg:text-sm sm:w-48 focus:outline-none focus:ring-blue-500 focus:border-blue-500"},[(c(!0),d(p,null,_(n.actions,(r,h)=>(c(),d("option",{value:r.id,key:h},a(r.label),9,se))),128))],512),[[A,i.actionId]]),e("button",{onClick:t[1]||(t[1]=r=>l.$emit("execute",i.actionId)),type:"button",class:"inline-flex items-center px-4 h-11 font-medium text-gray-700 bg-white rounded border border-gray-300 shadow-sm lg:h-9 lg:text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"}," Apply ")])}const ne=b(ee,[["render",oe]]),le={components:{AppLayout:M,Pagination:Z,SelectAction:ne,Link:q},props:{entries:Object,months:Array,queryParams:Object},data(){return{actions:[{id:null,label:"Bulk actions"},{id:"delete",label:"Delete"}],query:{status:this.queryParams.status,term:this.queryParams.term,role:this.queryParams.role,month:this.queryParams.month}}},methods:{deleteEnty(l){confirm("Are you sure?")&&this.$inertia.delete(route("system.users.destroy"),{preserveState:!1,data:{entryIds:[l]}})},toggleSelectAll(l){this.entries.data.forEach(t=>t.selected=l.target.checked)},executeAction(l){const t=this.entries.data.filter(n=>n.selected).map(n=>n.id);if(t.length)switch(l){case"delete":confirm("Are you sure?")&&this.$inertia.delete(route("system.users.destroy"),{preserveState:!1,data:{entryIds:t}});break}},filter(){this.$inertia.get(route("system.users.index"),S.pickBy(this.query),{preserveState:!0})}},computed:{allMonths(){return[{value:null,label:"Any date"},...this.months]}}},re=e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Users",-1),ie={class:"max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"},ae={class:"flex flex-col p-4 mb-4 space-y-4 bg-white shadow sm:rounded lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:p-2"},ce={class:"flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-2"},de=["value"],ue={class:"flex flex-col"},ge=e("label",{for:"search",class:"text-sm font-medium text-gray-700 sr-only"},"Search",-1),he={class:"flex flex-col items-center space-y-4 mb-4 md:space-y-0 md:flex-row md:justify-between"},fe={class:"flex flex-row space-x-2"},me=["href"],xe=e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor",class:"w-4 h-4"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"})],-1),pe=[xe],_e={class:"mb-4"},be={class:"min-w-full bg-white shadow table-fixed sm:rounded"},we={class:"border-b border-gray-200"},ye={class:"px-2 w-10 text-center"},ve=e("th",{class:"text-left"},[e("span",{class:"flex relative z-10 items-center p-2 space-x-2 font-normal text-blue-600 group lg:text-sm focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-blue-500"}," Name ")],-1),ke=e("th",{class:"hidden text-left lg:table-cell"},[e("span",{class:"inline-block p-2 font-normal text-blue-600 lg:text-sm"}," Roles ")],-1),Pe=e("th",{class:"hidden w-28 text-left lg:table-cell"},[e("span",{class:"flex relative z-10 items-center p-2 space-x-2 font-normal text-blue-600 group lg:text-sm focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-blue-500"}," Status ")],-1),Ae=e("th",{class:"hidden w-32 text-left lg:table-cell"},[e("span",{class:"p-2 font-normal text-blue-600 lg:text-sm"}," Last login at ")],-1),Ce=e("th",{class:"hidden w-32 text-left lg:table-cell"},[e("span",{class:"flex relative z-10 items-center p-2 space-x-2 font-normal text-blue-600 group lg:text-sm focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-blue-500"}," Date ")],-1),je={class:"divide-y divide-gray-100"},Se={class:"p-2 w-10 text-center"},Me=["onUpdate:modelValue"],qe={class:"p-2 text-left"},Be={class:"flex space-x-4"},Ne={class:"overflow-hidden flex-shrink-0 w-12 h-12 bg-gray-100 rounded lg:w-16 lg:h-16"},Ve=["src"],Ee={class:"text-sm font-semibold text-blue-600 break-all rounded focus:outline-none focus:ring-2 focus:ring-blue-500"},Ie={class:"text-xs text-gray-500 break-all"},Ue={class:"text-xs text-blue-400 break-all"},Le={class:"flex items-center mt-2 space-x-2 md:invisible group-hover:visible"},$e=e("span",{class:"text-xs text-gray-300"},"|",-1),ze=["onClick"],De={class:"hidden p-2 text-left lg:table-cell"},Fe={href:"#",class:"text-blue-600 rounded lg:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"},Ke={class:"hidden p-2 text-left lg:table-cell"},Oe={href:"#",class:"text-blue-600 rounded lg:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"},Te={class:"hidden p-2 text-left lg:table-cell"},He={class:"text-gray-600 lg:text-sm"},Re={class:"hidden p-2 text-left lg:table-cell"},Ge={class:"text-gray-600 lg:text-sm"},Je={key:0,class:"align-top"},Qe=e("td",{colspan:"4",class:"p-2 text-sm text-gray-700"}," No items found. ",-1),We=[Qe],Xe={class:"flex flex-col items-center space-y-4 mb-4 md:space-y-0 md:flex-row md:justify-between"};function Ye(l,t,n,w,i,o){const r=m("select-action"),h=m("pagination"),C=m("Link"),j=m("AppLayout");return c(),B(j,{title:"Users"},{header:x(()=>[re]),default:x(()=>[e("div",null,[e("div",ie,[e("section",ae,[e("div",ce,[g(e("select",{"onUpdate:modelValue":t[0]||(t[0]=s=>i.query.month=s),"aria-label":"Media date",id:"date",class:"pr-10 pl-3 w-full h-11 rounded border-gray-300 shadow-sm lg:h-9 lg:text-sm sm:w-44 focus:outline-none focus:ring-blue-500 focus:border-blue-500"},[(c(!0),d(p,null,_(o.allMonths,s=>(c(),d("option",{value:s.value},a(s.label),9,de))),256))],512),[[A,i.query.month]]),e("button",{onClick:t[1]||(t[1]=s=>o.filter()),type:"button",class:"inline-flex items-center px-4 h-11 font-medium text-gray-700 bg-white rounded border border-gray-300 shadow-sm lg:h-9 lg:text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"}," Filter ")]),e("div",ue,[ge,g(e("input",{"onUpdate:modelValue":t[2]||(t[2]=s=>i.query.term=s),onKeydown:t[3]||(t[3]=k(s=>o.filter(),["enter"])),type:"search",id:"search",class:"w-full h-11 rounded border-gray-300 shadow-sm lg:h-9 lg:text-sm lg:w-64 focus:ring-blue-500 focus:border-blue-500",placeholder:"Search for...",autocomplete:"off"},null,544),[[v,i.query.term]])])]),e("section",he,[e("div",fe,[u(r,{actions:i.actions,onExecute:o.executeAction},null,8,["actions","onExecute"]),e("a",{href:l.route("system.users.create"),class:"inline-flex items-center px-4 h-11 font-medium text-gray-700 bg-white rounded border border-gray-300 shadow-sm lg:h-9 lg:text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"},pe,8,me)]),u(h,{pagination:n.entries.meta},null,8,["pagination"])]),e("section",_e,[e("table",be,[e("thead",null,[e("tr",we,[e("th",ye,[e("input",{type:"checkbox",onChange:t[4]||(t[4]=(...s)=>o.toggleSelectAll&&o.toggleSelectAll(...s)),class:"w-6 h-6 text-blue-600 rounded border-gray-300 lg:w-4 lg:h-4 focus:ring-blue-500"},null,32)]),ve,ke,Pe,Ae,Ce])]),e("tbody",je,[(c(!0),d(p,null,_(n.entries.data,(s,Ze)=>(c(),d("tr",{class:"align-top group",key:s.id},[e("td",Se,[g(e("input",{type:"checkbox","onUpdate:modelValue":y=>s.selected=y,class:"w-6 h-6 text-blue-600 rounded border-gray-300 lg:w-4 lg:h-4 focus:ring-blue-500"},null,8,Me),[[N,s.selected]])]),e("td",qe,[e("div",Be,[e("div",Ne,[e("img",{src:s.profile_photo_url,class:"object-cover"},null,8,Ve)]),e("div",null,[e("span",Ee,a(s.name),1),e("p",Ie,a(s.email),1),e("p",Ue," Verified_at: "+a(s.email_verified_at),1),e("div",Le,[u(C,{href:l.route("system.users.edit",s.id),class:"text-xs text-blue-600 rounded hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"},{default:x(()=>[V(" Edit ")]),_:2},1032,["href"]),$e,e("button",{onClick:y=>o.deleteEnty(s.id),class:"text-xs text-red-600 rounded hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-blue-500"}," Delete ",8,ze)])])])]),e("td",De,[e("a",Fe,a(s.role??null),1)]),e("td",Ke,[e("a",Oe,a(s.status),1)]),e("td",Te,[e("span",He,a(s.last_activity_at??null),1)]),e("td",Re,[e("span",Ge,a(s.created_at),1)])]))),128)),n.entries.data.length?P("",!0):(c(),d("tr",Je,We))])])]),e("section",Xe,[u(r,{actions:i.actions,onExecute:o.executeAction},null,8,["actions","onExecute"]),u(h,{pagination:n.entries.meta},null,8,["pagination"])])])])]),_:1})}const it=b(le,[["render",Ye]]);export{it as default};