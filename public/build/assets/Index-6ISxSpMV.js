import{Q as j,k as g,m as V,l as E,h as I,D as k,f as r,a as b,u as c,w as v,F as C,o,Z as L,b as n,j as x,d as h,i as U,A as H,H as Q,n as s,G as F,t as d,g as $}from"./app-CwCXP5kg.js";import{_ as R}from"./AuthenticatedLayout-CmOhoxlP.js";import{d as w}from"./index-Dwx7afOm.js";import"./ApplicationLogo-DC9Ptwe5.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const Y={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},q={class:"devices__list table"},z={class:"customers__titlebar dflex justify-content-between align-items-center"},G={class:"customers__titlebar--item"},Z={class:"relative"},J={class:"legend--services"},K=["onClick"],O=["onClick"],W={key:0},X={key:1},ee={class:"table--items devices__list__bottom"},te={class:"pagination"},ne=["innerHTML","onClick"],ue={__name:"Index",setup(ae){const P=j();let m=g([]),y=g([]),u=g("");const f=g(!1),l=g([]);V(async()=>{const e=P.props.auth.user;e&&e.role===0&&(f.value=!0),_()}),E(u,()=>{_()});const N=e=>!e.price_paid&&!e.accepted&&e.device.returned?"bg-gray-200":!e.price_paid&&!e.accepted&&!e.done?"bg-orange-300":e.price_paid&&!e.accepted&&!e.done?"bg-orange-500":!e.price_paid&&e.accepted&&!e.done?"bg-beige-300":!e.price_paid&&e.accepted&&e.done&&!e.device.returned?"bg-beige-500":e.price_paid&&e.accepted&&!e.done&&!e.device.returned?"bg-green-300":e.price_paid&&e.accepted&&e.done&&!e.device.returned?"bg-green-700":e.price_paid&&e.accepted&&e.done&&e.device.returned?"bg-gray-500":!e.price_paid&&e.accepted&&e.done&&e.device.returned?"bg-red-500":"",T=I(()=>l.value.length===0?m.value:m.value.filter(e=>l.value.includes(N(e)))),i=e=>{l.value.includes(e)?l.value=l.value.filter(t=>t!==e):l.value.push(e)},_=async()=>{try{const e=await k.get("/api/services?&searchQuery="+u.value);m.value=e.data.services.data,y.value=e.data.services.links}catch(e){console.error("Error fetching services:",e)}},A=e=>{w.Inertia.visit(`/tasks/create?service_id=${e}`)},B=e=>{w.Inertia.visit(`/spares/create?service_id=${e}`)},M=e=>{!e.url||e.active||k.get(e.url).then(t=>{m.value=t.data.services.data,y.value=t.data.services.links})},S=e=>{w.Inertia.visit(`/services/${e}/edit`)},D=e=>{Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete it!"}).then(t=>{t.isConfirmed&&k.delete(`/api/services/${e}`).then(()=>{Swal.fire({title:"Deleted!",text:"Your file has been deleted.",icon:"success"}),_()})})};return(e,t)=>(o(),r(C,null,[b(c(L),{title:"Enregistrement prestation"}),b(R,null,{header:v(()=>t[10]||(t[10]=[n("h2",{class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},[n("span",null,"Prestations")],-1)])),default:v(()=>[n("div",Y,[n("div",q,[n("div",z,[t[12]||(t[12]=n("div",{class:"customers__titlebar--item"},[n("h1",null,"Prestations")],-1)),n("div",G,[b(c(x),{href:"/services/create",class:"btn btn-secondary my-1"},{default:v(()=>t[11]||(t[11]=[h(" Ajouter une prestation ")])),_:1})])]),n("div",Z,[U(n("input",{class:"search-input",type:"text",name:"search",placeholder:"Recherche prestation...","onUpdate:modelValue":t[0]||(t[0]=a=>Q(u)?u.value=a:u=a)},null,512),[[H,c(u)]])]),t[17]||(t[17]=n("div",{class:"legend--title"},[n("p",null,"Légende et filtre:")],-1)),n("div",J,[n("span",{class:s(["bg-orange-300",{"active-filter":l.value.includes("bg-orange-300")}]),onClick:t[1]||(t[1]=a=>i("bg-orange-300"))}," Non payé, non accepté, non terminé, non rendu ",2),n("span",{class:s(["bg-orange-500",{"active-filter":l.value.includes("bg-orange-500")}]),onClick:t[2]||(t[2]=a=>i("bg-orange-500"))}," Payé, non accepté, non terminé, non rendu ",2),n("span",{class:s(["bg-gray-200",{"active-filter":l.value.includes("bg-gray-200")}]),onClick:t[3]||(t[3]=a=>i("bg-gray-200"))}," Non payé, non accepté, non terminé, rendu ",2),n("span",{class:s(["bg-beige-300",{"active-filter":l.value.includes("bg-beige-300")}]),onClick:t[4]||(t[4]=a=>i("bg-beige-300"))}," Non Payé, accepté, non terminé, non rendu ",2),n("span",{class:s(["bg-beige-500",{"active-filter":l.value.includes("bg-beige-500")}]),onClick:t[5]||(t[5]=a=>i("bg-beige-500"))}," Non payé, accepté, terminé, non rendu ",2),n("span",{class:s(["bg-gray-500",{"active-filter":l.value.includes("bg-gray-500")}]),onClick:t[6]||(t[6]=a=>i("bg-gray-500"))}," Payé, accepté, terminé, rendu ",2),n("span",{class:s(["bg-green-300",{"active-filter":l.value.includes("bg-green-300")}]),onClick:t[7]||(t[7]=a=>i("bg-green-300"))}," Payé, accepté, non terminé, non rendu ",2),n("span",{class:s(["bg-green-700",{"active-filter":l.value.includes("bg-green-700")}]),onClick:t[8]||(t[8]=a=>i("bg-green-700"))}," Payé, accepté, terminé, non rendu ",2),n("span",{class:s(["bg-red-500",{"active-filter":l.value.includes("bg-red-500")}]),onClick:t[9]||(t[9]=a=>i("bg-red-500"))}," Non payé, accepté, terminé, rendu ",2)]),t[18]||(t[18]=n("div",{class:"table--heading mt-2 services__list__heading",style:{"padding-top":"20px",background:"#FFF"}},[n("p",{class:"table--heading--col1"},"Utilisateur"),n("p",{class:"table--heading--col2"},"Appareil"),n("p",{class:"table--heading--col3"},"Marque"),n("p",{class:"table--heading--col4"},"Nom Modèle"),n("p",{class:"table--heading--col5"},"No Modèle"),n("p",{class:"table--heading--col6"},"Description de la prestation"),n("p",{class:"table--heading--col7"},"Prix"),n("p",{class:"table--heading--col8"},"Actions")],-1)),(o(!0),r(C,null,F(T.value,a=>(o(),r("div",{class:s(["table--items services__list__item",N(a)]),key:a.id},[n("p",null,d(a.device.user.name),1),n("p",null,d(a.device_id),1),n("p",null,d(a.device.brand),1),n("p",null,d(a.device.model_name),1),n("p",null,d(a.device.model_number),1),n("p",null,d(a.description),1),n("p",null,d(a.price),1),n("div",null,[n("button",{class:"btn-icon btn-icon-success",onClick:p=>S(a.id)},t[13]||(t[13]=[n("i",{class:"fas fa-pencil-alt"},null,-1)]),8,K),!f.value||!a.price?(o(),r("button",{key:0,class:"btn-icon btn-icon-danger",onClick:p=>D(a.id)},t[14]||(t[14]=[n("i",{class:"far fa-trash-alt"},null,-1)]),8,O)):$("",!0)]),f.value?$("",!0):(o(),r("div",W,[b(c(x),{href:"/tasks/create",class:"btn btn-secondary my-1",onClick:p=>A(a.id)},{default:v(()=>t[15]||(t[15]=[h(" Ajouter une tâche ")])),_:2},1032,["onClick"])])),f.value?$("",!0):(o(),r("div",X,[b(c(x),{href:"/spares/create",class:"btn btn-secondary my-1",onClick:p=>B(a.id)},{default:v(()=>t[16]||(t[16]=[h(" Ajouter une pièce ")])),_:2},1032,["onClick"])]))],2))),128)),n("div",ee,[n("ul",te,[(o(!0),r(C,null,F(c(y),(a,p)=>(o(),r("a",{href:"#",class:s(["btn btn-secondary",{active:a.active,disable:!a.url}]),key:p,innerHTML:a.label,onClick:le=>M(a)},null,10,ne))),128))])])])])]),_:1})],64))}};export{ue as default};
