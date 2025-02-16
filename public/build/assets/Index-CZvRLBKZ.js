import{k as r,m as T,l as I,h as j,D as h,f as i,a as g,u,w as m,F as y,o,Z as L,b as e,j as k,d as w,i as $,A as N,H as P,n as b,G as A,E as H,t as c,g as R}from"./app-CWrOUGrC.js";import{_ as z}from"./AuthenticatedLayout-DSwbZh_W.js";import{d as B}from"./index-BtVjSjZl.js";import"./ApplicationLogo-DChB-njM.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const Q={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},U={class:"devices__list table"},q={class:"customers__titlebar dflex justify-content-between align-items-center"},G={class:"customers__titlebar--item"},Z={class:"relative"},J={class:"legend--devices"},K=["src"],O=["onClick"],W=["onClick"],X={class:"table--items devices__list__bottom"},Y={class:"pagination"},ee=["innerHTML","onClick"],re={__name:"Index",setup(te){let d=r([]),f=r([]),n=r("");const a=r([]),_=r(10);T(async()=>{p()}),I(n,()=>{p()});const x=s=>s.returned?"bg-gray-200":"bg-green-300",D=j(()=>a.value.length===0?d.value:d.value.filter(s=>a.value.includes(x(s)))),C=s=>{a.value.includes(s)?a.value=a.value.filter(t=>t!==s):a.value.push(s)},F=s=>"/upload/"+s,p=async()=>{try{const s=await h.get(`/api/devices?searchQuery=${n.value}&perPage=${_.value}`);d.value=s.data.devices.data||[],f.value=s.data.devices.links||[]}catch(s){console.error("Error fetching devices:",s)}},M=s=>{B.Inertia.visit(`/services/create?device_id=${s}`)},V=s=>{!s.url||s.active||h.get(s.url).then(t=>{d.value=t.data.devices.data,f.value=t.data.devices.links})},E=s=>{B.Inertia.visit(`/devices/${s}/edit`)},S=s=>{Swal.fire({title:"Etes vous sur ?",text:"Vous ne pourrez pas annuler cette action !",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"oui, supprimer!"}).then(t=>{t.isConfirmed&&h.delete(`/api/devices/${s}`).then(()=>{Swal.fire({title:"Supprimé!",text:"Appareil supprimé avec succès.",icon:"success",timer:2e3,showConfirmButton:!1}),p()})})};return(s,t)=>(o(),i(y,null,[g(u(L),{title:"Enregistrement Appareil"}),g(z,null,{header:m(()=>t[4]||(t[4]=[e("h2",{class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},[e("span",null,"Appareils")],-1)])),default:m(()=>[e("div",Q,[e("div",U,[e("div",q,[t[6]||(t[6]=e("div",{class:"customers__titlebar--item"},[e("h1",null,"Appareils")],-1)),e("div",G,[g(u(k),{href:"/devices/create",class:"btn btn-secondary my-1"},{default:m(()=>t[5]||(t[5]=[w(" Ajouter un appareil ")])),_:1})])]),e("div",Z,[$(e("input",{class:"search-input",type:"text",name:"search",placeholder:"Recherche d'appareil...","onUpdate:modelValue":t[0]||(t[0]=l=>P(n)?n.value=l:n=l)},null,512),[[N,u(n)]])]),t[11]||(t[11]=e("div",{class:"legend--title"},[e("p",null,"Légende:")],-1)),e("div",J,[e("span",{class:b(["bg-gray-200",{"active-filter":a.value.includes("bg-gray-200")}]),onClick:t[1]||(t[1]=l=>C("bg-gray-200"))},"Appareil rendu",2),e("span",{class:b(["bg-green-300",{"active-filter":a.value.includes("bg-green-300")}]),onClick:t[2]||(t[2]=l=>C("bg-green-300"))},"Appareil non rendu",2)]),t[12]||(t[12]=e("div",{class:"table--heading mt-2 devices__list__heading",style:{"padding-top":"20px",background:"#FFF"}},[e("p",{class:"table--heading--col1"},"Image"),e("p",{class:"table--heading--col2"},"Client"),e("p",{class:"table--heading--col3"},"Marque"),e("p",{class:"table--heading--col4"},"Modèle"),e("p",{class:"table--heading--col5"},"Couleur"),e("p",{class:"table--heading--col6"},"Description de l'appareil"),e("p",{class:"table--heading--col7"},"actions")],-1)),(o(!0),i(y,null,A(D.value,l=>(o(),i("div",{class:b(["table--items devices__list__item",x(l)]),key:l.id},[e("img",{src:F(l.image)},null,8,K),e("p",null,c(l.user.name),1),e("p",null,c(l.brand),1),e("p",null,c(l.model_name),1),e("p",null,c(l.color),1),e("p",null,c(l.description),1),e("div",null,[e("button",{class:"btn-icon btn-icon-success",onClick:v=>E(l.id)},t[7]||(t[7]=[e("i",{class:"fas fa-pencil-alt"},null,-1)]),8,O),l.has_service?R("",!0):(o(),i("button",{key:0,class:"btn-icon btn-icon-danger",onClick:v=>S(l.id)},t[8]||(t[8]=[e("i",{class:"far fa-trash-alt"},null,-1)]),8,W))]),e("div",null,[g(u(k),{href:"/services/create",class:"btn btn-secondary my-1",onClick:v=>M(l.id)},{default:m(()=>t[9]||(t[9]=[w(" Ajouter une prestation ")])),_:2},1032,["onClick"])])],2))),128)),e("div",X,[e("ul",Y,[(o(!0),i(y,null,A(u(f),(l,v)=>(o(),i("a",{href:"#",class:b(["btn btn-secondary",{active:l.active,disable:!l.url}]),key:v,innerHTML:l.label,onClick:se=>V(l)},null,10,ee))),128))]),$(e("select",{"onUpdate:modelValue":t[3]||(t[3]=l=>_.value=l),onChange:p,class:"select-pagination"},t[10]||(t[10]=[e("option",{value:"5"},"5",-1),e("option",{value:"10"},"10",-1),e("option",{value:"50"},"50",-1),e("option",{value:"100"},"100",-1),e("option",{value:"200"},"200",-1),e("option",{value:"500"},"500",-1),e("option",{value:"1000"},"1000",-1)]),544),[[H,_.value]])])])])]),_:1})],64))}};export{re as default};
