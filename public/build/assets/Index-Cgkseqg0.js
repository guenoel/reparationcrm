import{k as u,m as k,l as w,D as g,f as i,a as h,u as r,w as v,F as m,o as n,Z as C,b as e,i as U,A as F,H as E,G as b,t as o,n as I}from"./app-929ikU7m.js";import{_ as M}from"./AuthenticatedLayout-wQM5iXEG.js";import{d as T}from"./index-3ddl9PSD.js";import"./ApplicationLogo-CG5iv4N8.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const B={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},D={class:"devices__list table"},H={class:"relative"},L=["src"],N=["onClick"],R={class:"table--items devices__list__bottom"},V={class:"pagination"},$=["innerHTML","onClick"],Z={__name:"Index",setup(Q){let c=u([]),d=u([]),l=u("");k(async()=>{p()}),w(l,()=>{p()});const f=t=>"/upload/"+t,p=async()=>{try{const t=await g.get("/api/users?&searchQuery="+l.value);c.value=t.data.users.data,d.value=t.data.users.links}catch(t){console.error("Error fetching users:",t)}},x=t=>{!t.url||t.active||g.get(t.url).then(a=>{c.value=a.data.users.data,d.value=a.data.users.links})},y=t=>{T.Inertia.visit(`/users/${t}/edit`)};return(t,a)=>(n(),i(m,null,[h(r(C),{title:"Enregistrement Utilisateur"}),h(M,null,{header:v(()=>a[1]||(a[1]=[e("h2",{class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},[e("span",null,"Utilisateurs")],-1)])),default:v(()=>[e("div",B,[e("div",D,[a[3]||(a[3]=e("div",{class:"customers__titlebar dflex justify-content-between align-items-center"},[e("div",{class:"customers__titlebar--item"},[e("h1",null,"Utilisateurs")])],-1)),e("div",H,[U(e("input",{class:"search-input",type:"text",name:"search",placeholder:"Recherche d'utilisateur...","onUpdate:modelValue":a[0]||(a[0]=s=>E(l)?l.value=s:l=s)},null,512),[[F,r(l)]])]),a[4]||(a[4]=e("div",{class:"table--heading mt-2 devices__list__heading",style:{"padding-top":"20px",background:"#FFF"}},[e("p",{class:"table--heading--col1"},"Image"),e("p",{class:"table--heading--col2"},"Nom"),e("p",{class:"table--heading--col3"},"e-mail"),e("p",{class:"table--heading--col4"},"Téléphone"),e("p",{class:"table--heading--col5"},"Rôle"),e("p",{class:"table--heading--col8"},"actions")],-1)),(n(!0),i(m,null,b(r(c),s=>(n(),i("div",{class:"table--items devices__list__item",key:s.id},[e("img",{src:f(s.image)},null,8,L),e("p",null,o(s.name),1),e("p",null,o(s.email),1),e("p",null,o(s.phone),1),e("p",null,o(s.role),1),e("div",null,[e("button",{class:"btn-icon btn-icon-success",onClick:_=>y(s.id)},a[2]||(a[2]=[e("i",{class:"fas fa-pencil-alt"},null,-1)]),8,N)])]))),128)),e("div",R,[e("ul",V,[(n(!0),i(m,null,b(r(d),(s,_)=>(n(),i("a",{href:"#",class:I(["btn btn-secondary",{active:s.active,disable:!s.url}]),key:_,innerHTML:s.label,onClick:j=>x(s)},null,10,$))),128))])])])])]),_:1})],64))}};export{Z as default};
