import{k as m,m as w,l as C,D as _,f as n,a as v,u as o,w as b,F as h,o as r,Z as k,b as e,j as B,d as M,i as D,A as F,H as N,G as f,t as l,n as S}from"./app-gyy7AzGw.js";import{_ as T}from"./AuthenticatedLayout-ejZzCHZw.js";import{d as $}from"./index-BTWyWh5k.js";import"./ApplicationLogo--aYsc0Kz.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const A={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},E={class:"devices__list table"},P={class:"customers__titlebar dflex justify-content-between align-items-center"},V={class:"customers__titlebar--item"},j={class:"relative"},H=["onClick"],I=["onClick"],L={class:"table--items devices__list__bottom"},Y={class:"pagination"},Q=["innerHTML","onClick"],K={__name:"Index",setup(R){let c=m([]),d=m([]),i=m("");w(async()=>{u()}),C(i,()=>{u()});const u=async()=>{try{const a=await _.get("/api/services?&searchQuery="+i.value);c.value=a.data.services.data,d.value=a.data.services.links}catch(a){console.error("Error fetching services:",a)}},g=a=>{!a.url||a.active||_.get(a.url).then(t=>{c.value=t.data.services.data,d.value=t.data.services.links})},x=a=>{$.Inertia.visit(`/services/${a}/edit`)},y=a=>{Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete it!"}).then(t=>{t.isConfirmed&&_.delete(`/api/services/${a}`).then(()=>{Swal.fire({title:"Deleted!",text:"Your file has been deleted.",icon:"success"}),u()})})};return(a,t)=>(r(),n(h,null,[v(o(k),{title:"Enregistrement prestation"}),v(T,null,{header:b(()=>t[1]||(t[1]=[e("h2",{class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},[e("span",null,"Prestations")],-1)])),default:b(()=>[e("div",A,[e("div",E,[e("div",P,[t[3]||(t[3]=e("div",{class:"customers__titlebar--item"},[e("h1",null,"Prestations")],-1)),e("div",V,[v(o(B),{href:"/services/create",class:"btn btn-secondary my-1"},{default:b(()=>t[2]||(t[2]=[M(" Ajouter une prestation ")])),_:1})])]),e("div",j,[D(e("input",{class:"search-input",type:"text",name:"search",placeholder:"Recherche prestation...","onUpdate:modelValue":t[0]||(t[0]=s=>N(i)?i.value=s:i=s)},null,512),[[F,o(i)]])]),t[6]||(t[6]=e("div",{class:"table--heading mt-2 services__list__heading",style:{"padding-top":"20px",background:"#FFF"}},[e("p",{class:"table--heading--col1"},"Utilisateur"),e("p",{class:"table--heading--col2"},"Id appareil"),e("p",{class:"table--heading--col3"},"Marque"),e("p",{class:"table--heading--col4"},"Nom Modèle"),e("p",{class:"table--heading--col5"},"No Modèle"),e("p",{class:"table--heading--col6"},"Description de la prestation"),e("p",{class:"table--heading--col7"},"Price"),e("p",{class:"table--heading--col8"},"Actions")],-1)),(r(!0),n(h,null,f(o(c),s=>(r(),n("div",{class:"table--items services__list__item",key:s.id},[e("p",null,l(s.device.user.name),1),e("p",null,l(s.device_id),1),e("p",null,l(s.device.brand),1),e("p",null,l(s.device.model_name),1),e("p",null,l(s.device.model_number),1),e("p",null,l(s.description),1),e("p",null,l(s.price),1),e("div",null,[e("button",{class:"btn-icon btn-icon-success",onClick:p=>x(s.id)},t[4]||(t[4]=[e("i",{class:"fas fa-pencil-alt"},null,-1)]),8,H),e("button",{class:"btn-icon btn-icon-danger",onClick:p=>y(s.id)},t[5]||(t[5]=[e("i",{class:"far fa-trash-alt"},null,-1)]),8,I)])]))),128)),e("div",L,[e("ul",Y,[(r(!0),n(h,null,f(o(d),(s,p)=>(r(),n("a",{href:"#",class:S(["btn btn-secondary",{active:s.active,disable:!s.url}]),key:p,innerHTML:s.label,onClick:U=>g(s)},null,10,Q))),128))])])])])]),_:1})],64))}};export{K as default};
