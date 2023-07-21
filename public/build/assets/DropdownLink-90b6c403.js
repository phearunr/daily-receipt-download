import{r as b,x as w,B as x,j as g,o,d as u,a as l,p as r,l as c,u as a,k as y,Q as p,b as $,w as m,n as v,$ as C,c as S,i as B}from"./app-db99a8de.js";const E={class:"relative"},N={__name:"Dropdown",props:{align:{type:String,default:"right"},width:{type:String,default:"48"},contentClasses:{type:Array,default:()=>["py-1","bg-white"]}},setup(t){const s=t;let e=b(!1);const d=i=>{e.value&&i.key==="Escape"&&(e.value=!1)};w(()=>document.addEventListener("keydown",d)),x(()=>document.removeEventListener("keydown",d));const h=g(()=>({48:"w-48"})[s.width.toString()]),k=g(()=>s.align==="left"?"origin-top-left left-0":s.align==="right"?"origin-top-right right-0":"origin-top");return(i,n)=>(o(),u("div",E,[l("div",{onClick:n[0]||(n[0]=f=>c(e)?e.value=!a(e):e=!a(e))},[r(i.$slots,"trigger")]),y(l("div",{class:"fixed inset-0 z-40",onClick:n[1]||(n[1]=f=>c(e)?e.value=!1:e=!1)},null,512),[[p,a(e)]]),$(C,{"enter-active-class":"transition ease-out duration-200","enter-from-class":"transform opacity-0 scale-95","enter-to-class":"transform opacity-100 scale-100","leave-active-class":"transition ease-in duration-75","leave-from-class":"transform opacity-100 scale-100","leave-to-class":"transform opacity-0 scale-95"},{default:m(()=>[y(l("div",{class:v(["absolute z-50 mt-2 rounded-md shadow-lg",[a(h),a(k)]]),style:{display:"none"},onClick:n[2]||(n[2]=f=>c(e)?e.value=!1:e=!1)},[l("div",{class:v(["rounded-md ring-1 ring-black ring-opacity-5",t.contentClasses])},[r(i.$slots,"content")],2)],2),[[p,a(e)]])]),_:3})]))}},z={key:0,type:"submit",class:"block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"},D=["href"],V={__name:"DropdownLink",props:{href:String,as:String},setup(t){return(s,e)=>(o(),u("div",null,[t.as=="button"?(o(),u("button",z,[r(s.$slots,"default")])):t.as=="a"?(o(),u("a",{key:1,href:t.href,class:"block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"},[r(s.$slots,"default")],8,D)):(o(),S(a(B),{key:2,href:t.href,class:"block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"},{default:m(()=>[r(s.$slots,"default")]),_:3},8,["href"]))]))}};export{V as _,N as a};
