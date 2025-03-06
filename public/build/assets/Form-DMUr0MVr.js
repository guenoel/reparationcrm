import{k as d,C as W,Q as z,m as G,h as Z,l as V,D as v,f as o,a as E,u,w as $,F as y,o as r,Z as K,b as i,i as m,A as h,E as x,g as c,t as l,G as D,S as A}from"./app-BrQThaKp.js";import{_ as P}from"./AuthenticatedLayout-BzilsnKP.js";import{d as F}from"./index-Br-uvqLY.js";import"./ApplicationLogo-D5-q05GN.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const X={class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},Y={key:0},ee={key:1},se={class:"devices__create"},te={class:"devices__create__cardWrapper mt-2"},ae={class:"devices__create__main"},ie={class:"devices__create__main--addInfo card py-2 px-2 bg-white"},oe={key:0},re={key:0,class:"absolute w-full bg-white border rounded shadow-lg z-10"},le=["onMousedown","innerHTML"],ne={key:1,style:{color:"red"}},de={key:1},ue=["value"],me={key:0,style:{color:"red"}},ce=["disabled"],pe=["value"],_e={key:1,style:{color:"red"}},ve=["disabled"],be=["value"],ge={key:2,style:{color:"red"}},fe={key:2},ye={class:"mb-1"},he={class:"mb-1"},we={class:"mb-1"},xe={class:"mb-1"},ke={class:"mb-1"},Ue={class:"mb-1"},Ne={class:"mb-1"},Ve={class:"devices__create__main--media--images mt-2"},De={class:"devices__create__main--media--images--list list-unstyled"},Me={class:"devices__create__main--media--images--item"},Se={class:"devices__create__main--media--images--item--imgWrapper"},Ce=["src"],Ee={class:"devices__create__main--media--images--item"},$e={class:"devices__create__main--media--images--item--form"},Oe={__name:"Form",setup(Ae){const k=d(),t=W({image:"",user_id:"",brand:"",model_name:"",model_number:"",color:"",serial_number:"",imei:"",description:""}),p=z(),b=d(!1);let n=d([]);const g=d(!1),_=d(""),M=d([]),S=d([]),U=d([]),C=d(!1),w=d(!1);G(()=>{const s=p.props.auth.user;s&&s.role===0&&(g.value=!0,t.user_id=s.id),p.props.route&&p.props.route.name==="devices.edit"?(b.value=!0,k.value=p.props.route.params.id,O()):(j(),T())});const N=Z(()=>_.value.trim()?p.props.users.filter(s=>s.name.toLowerCase().includes(_.value.toLowerCase())):[]),L=s=>{t.user_id=s.id,_.value=s.name,w.value=!1},B=()=>{setTimeout(()=>{w.value=!1},200)},I=s=>{if(!_.value)return s;const e=new RegExp(`(${_.value})`,"gi");return s.replace(e,'<span class="bg-yellow-300">$1</span>')};V(N,s=>{s.length>0&&(t.user_id=s[0].id)}),V(()=>t.brand,async s=>{if(s)try{const e=await v.get(`/api/models/${s}`);S.value=e.data.map(a=>a.modelValue),t.model_name="",U.value=[]}catch(e){console.error("Erreur lors de la récupération des noms de modèle :",e)}}),V(()=>t.model_name,async s=>{if(s)try{const e=await v.get(`/api/model-numbers/${t.brand}/${s}`);U.value=Array.isArray(e.data)?e.data:[],t.model_number=""}catch(e){console.error("Erreur lors de la récupération des numéros de modèle :",e)}});const T=async()=>{try{const s=await v.get("/api/brands");M.value=s.data.map(e=>e.brandValue)}catch(s){console.error("Erreur lors de la récupération des marques :",s)}},j=async()=>{try{C.value=!0;let s=await v.get("/api/users/new_form");p.props.users=s.data.users}catch(s){console.error("Error fetching users:",s)}finally{C.value=!1}},O=async()=>{try{let s=await v.get(`/api/devices/${k.value}/edit`);s.data.users&&(p.props.users=Object.entries(s.data.users).map(([e,a])=>({id:Number(e),name:a}))),s.data.device&&(t.image=s.data.device.image,t.user_id=s.data.device.user_id,t.brand=s.data.device.brand,t.model_name=s.data.device.model_name,t.model_number=s.data.device.model_number,t.color=s.data.device.color,t.serial_number=s.data.device.serial_number,t.imei=s.data.device.imei,t.description=s.data.device.description,t.has_service=!!s.data.device.has_service)}catch(s){console.error("Error fetching device data:",s)}},q=()=>{let s="/upload/no-image.jpg";return t.image&&(t.image.indexOf("base64")!=-1?s=t.image:s="/upload/"+t.image),s},R=s=>{const e=s.target;let a=e.files?e.files[0]:null;if(a){const f=new FileReader;f.onloadend=Fe=>{f.result&&(t.image=f.result)},f.readAsDataURL(a)}},H=(s,e)=>{b.value?Q():J()},J=(s,e)=>{console.log("Form data being sent:",JSON.stringify(t,null,2)),v.post("/api/devices",t).then(a=>{A.fire({icon:"success",title:"Appareil ajouté",timer:2e3,showConfirmButton:!1}),setTimeout(()=>{F.Inertia.visit("/devices/index/")},2e3)}).catch(a=>{a.response&&a.response.status===422?n.value=a.response.data.errors:console.error("Error creating device:",a)}),console.log("Form data being sent:",JSON.stringify(t,null,2))},Q=(s,e)=>{v.put(`/api/devices/${k.value}`,t).then(a=>{A.fire({icon:"success",title:"Appareil modifié"}),setTimeout(()=>{F.Inertia.visit("/devices/index/")},2e3)}).catch(a=>{a.response&&a.response.status===422?n.value=a.response.data.errors:console.error("Error creating device:",a)})};return(s,e)=>(r(),o(y,null,[E(u(K),{title:"Enregistrement Appareil"}),E(P,null,{header:$(()=>[i("h2",X,[b.value?(r(),o("span",Y,"Modification d'un appareil")):(r(),o("span",ee,"Nouvel Appareil"))])]),default:$(()=>[i("div",se,[e[22]||(e[22]=i("div",{class:"devices__create__titlebar dflex justify-content-between align-items-center"},[i("div",{class:"devices__create__titlebar--item"},[i("button",{class:"btn btn-secondary ml-1"},"Save")])],-1)),i("div",te,[i("div",ae,[i("div",ie,[g.value?c("",!0):(r(),o("div",oe,[e[9]||(e[9]=i("p",{class:"mb-1"},"Utilisateur",-1)),m(i("input",{type:"text","onUpdate:modelValue":e[0]||(e[0]=a=>_.value=a),placeholder:"Rechercher un utilisateur...",class:"input mb-2 w-full",onFocus:e[1]||(e[1]=a=>w.value=!0),onBlur:B},null,544),[[h,_.value]]),w.value&&N.value.length?(r(),o("div",re,[i("ul",null,[(r(!0),o(y,null,x(N.value,a=>(r(),o("li",{key:a.id,onMousedown:f=>L(a),class:"p-2 hover:bg-gray-200 cursor-pointer",innerHTML:I(a.name)},null,40,le))),128))])])):c("",!0),u(n).user_id?(r(),o("small",ne,l(u(n).user_id),1)):c("",!0)])),!g.value||!b.value||g.value&&b.value&&!t.has_service?(r(),o("div",de,[e[13]||(e[13]=i("p",{class:"mb-1"},"Marque",-1)),m(i("select",{"onUpdate:modelValue":e[2]||(e[2]=a=>t.brand=a),class:"input"},[e[10]||(e[10]=i("option",{value:""},"Sélectionner une marque",-1)),(r(!0),o(y,null,x(M.value,a=>(r(),o("option",{key:a,value:a},l(a),9,ue))),128))],512),[[D,t.brand]]),u(n).brand?(r(),o("small",me,l(u(n).brand),1)):c("",!0),e[14]||(e[14]=i("p",{class:"mb-1"},"Modèle",-1)),m(i("select",{"onUpdate:modelValue":e[3]||(e[3]=a=>t.model_name=a),class:"input",disabled:!t.brand},[e[11]||(e[11]=i("option",{value:""},"Sélectionner un modèle",-1)),(r(!0),o(y,null,x(S.value,a=>(r(),o("option",{key:a,value:a},l(a),9,pe))),128))],8,ce),[[D,t.model_name]]),u(n).model_name?(r(),o("small",_e,l(u(n).model_name),1)):c("",!0),e[15]||(e[15]=i("p",{class:"mb-1"},"Numéro de modèle",-1)),m(i("select",{"onUpdate:modelValue":e[4]||(e[4]=a=>t.model_number=a),class:"input",disabled:!t.model_name},[e[12]||(e[12]=i("option",{value:""},"Sélectionner un numéro de modèle",-1)),(r(!0),o(y,null,x(U.value,a=>(r(),o("option",{key:a,value:a},l(a),9,be))),128))],8,ve),[[D,t.model_number]]),u(n).model_number?(r(),o("small",ge,l(u(n).model_number),1)):c("",!0),e[16]||(e[16]=i("p",{class:"mb-1"},"Couleur",-1)),m(i("input",{type:"text",class:"input",id:"color",name:"color","onUpdate:modelValue":e[5]||(e[5]=a=>t.color=a)},null,512),[[h,t.color]]),e[17]||(e[17]=i("p",{class:"mb-1"},"No de série",-1)),m(i("input",{type:"text",class:"input",id:"serial_number",name:"serial_number","onUpdate:modelValue":e[6]||(e[6]=a=>t.serial_number=a)},null,512),[[h,t.serial_number]]),e[18]||(e[18]=i("p",{class:"mb-1"},"imei",-1)),m(i("input",{type:"text",class:"input",id:"imei",name:"imei","onUpdate:modelValue":e[7]||(e[7]=a=>t.imei=a)},null,512),[[h,t.imei]]),e[19]||(e[19]=i("p",{class:"my-1"},"Description (optional)",-1)),m(i("textarea",{cols:"10",rows:"5",class:"textarea",id:"description",name:"description","onUpdate:modelValue":e[8]||(e[8]=a=>t.description=a)},null,512),[[h,t.description]])])):c("",!0),g.value&&b.value&&t.has_service?(r(),o("div",fe,[i("p",ye,"Marque: "+l(t.brand),1),i("p",he,"Nom de modèle: "+l(t.model_name),1),i("p",we,"Numéro de modèle: "+l(t.model_number),1),i("p",xe,"Couleur: "+l(t.color),1),i("p",ke,"Numéro de série: "+l(t.serial_number),1),i("p",Ue,"imei: "+l(t.imei),1),i("p",Ne,"Description: "+l(t.description),1)])):c("",!0),i("div",Ve,[i("ul",De,[i("li",Me,[i("div",Se,[i("img",{src:q(),class:"devices__create__main--media--images--item--img",alt:""},null,8,Ce)])]),i("li",Ee,[i("form",$e,[e[20]||(e[20]=i("label",{class:"devices__create__main--media--images--item--form--label",for:"myfile"},"Add Image",-1)),i("input",{class:"devices__create__main--media--images--item--form--input",type:"file",id:"myfile",onChange:R},null,32)])])])])])])]),i("div",{class:"dflex justify-content-between align-items-center my-3"},[e[21]||(e[21]=i("p",null,null,-1)),i("button",{class:"btn btn-secondary",onClick:H},"Save")])])]),_:1})],64))}};export{Oe as default};
