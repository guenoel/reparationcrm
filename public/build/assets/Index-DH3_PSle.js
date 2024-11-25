import{k as m,m as w,l as C,D as p,f as n,a as h,u as i,w as b,F as g,o,Z as T,b as e,j as B,d as D,i as F,A as I,H as $,G as v,t as r,n as A}from"./app-BOCkaKV8.js";import{_ as E}from"./AuthenticatedLayout-D_9LhWXv.js";import{d as M}from"./index-Ps8C63Ky.js";import"./ApplicationLogo-DHmw7JHb.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const S={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},V={class:"devices__list table"},j={class:"customers__titlebar dflex justify-content-between align-items-center"},H={class:"customers__titlebar--item"},L={class:"relative"},N=["src"],Y=["onClick"],Q=["onClick"],R={class:"table--items devices__list__bottom"},z={class:"pagination"},G=["innerHTML","onClick"],W={__name:"Index",setup(P){let c=m([]),d=m([]),l=m("");w(async()=>{u()}),C(l,()=>{u()});const f=a=>"/upload/"+a,u=async()=>{try{const a=await p.get("/api/tasks?&searchQuery="+l.value);c.value=a.data.tasks.data,d.value=a.data.tasks.links}catch(a){console.error("Error fetching tasks:",a)}},x=a=>{!a.url||a.active||p.get(a.url).then(t=>{c.value=t.data.tasks.data,d.value=t.data.tasks.links})},k=a=>{M.Inertia.visit(`/tasks/${a}/edit`)},y=a=>{Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete it!"}).then(t=>{t.isConfirmed&&p.delete(`/api/tasks/${a}`).then(()=>{Swal.fire({title:"Deleted!",text:"Your file has been deleted.",icon:"success"}),u()})})};return(a,t)=>(o(),n(g,null,[h(i(T),{title:"Enregistrement tâche"}),h(E,null,{header:b(()=>t[1]||(t[1]=[e("h2",{class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},[e("span",null,"Tâches")],-1)])),default:b(()=>[e("div",S,[e("div",V,[e("div",j,[t[3]||(t[3]=e("div",{class:"customers__titlebar--item"},[e("h1",null,"Tâches")],-1)),e("div",H,[h(i(B),{href:"/tasks/create",class:"btn btn-secondary my-1"},{default:b(()=>t[2]||(t[2]=[D(" Ajouter une tâche ")])),_:1})])]),e("div",L,[F(e("input",{class:"search-input",type:"text",name:"search",placeholder:"Recherche tâche...","onUpdate:modelValue":t[0]||(t[0]=s=>$(l)?l.value=s:l=s)},null,512),[[I,i(l)]])]),t[6]||(t[6]=e("div",{class:"table--heading mt-2 services__list__heading",style:{"padding-top":"20px",background:"#FFF"}},[e("p",{class:"table--heading--col1"},"Image"),e("p",{class:"table--heading--col2"},"Service ID"),e("p",{class:"table--heading--col3"},"Début"),e("p",{class:"table--heading--col4"},"Fin"),e("p",{class:"table--heading--col5"},"Description"),e("p",{class:"table--heading--col6"},"Actions")],-1)),(o(!0),n(g,null,v(i(c),s=>(o(),n("div",{class:"table--items services__list__item",key:s.id},[e("img",{src:f(s.image)},null,8,N),e("p",null,r(s.service_id),1),e("p",null,r(s.start),1),e("p",null,r(s.end),1),e("p",null,r(s.description),1),e("div",null,[e("button",{class:"btn-icon btn-icon-success",onClick:_=>k(s.id)},t[4]||(t[4]=[e("i",{class:"fas fa-pencil-alt"},null,-1)]),8,Y),e("button",{class:"btn-icon btn-icon-danger",onClick:_=>y(s.id)},t[5]||(t[5]=[e("i",{class:"far fa-trash-alt"},null,-1)]),8,Q)])]))),128)),e("div",R,[e("ul",z,[(o(!0),n(g,null,v(i(d),(s,_)=>(o(),n("a",{href:"#",class:A(["btn btn-secondary",{active:s.active,disable:!s.url}]),key:_,innerHTML:s.label,onClick:U=>x(s)},null,10,G))),128))])])])])]),_:1})],64))}};export{W as default};