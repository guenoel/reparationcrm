import{k as f,C as J,Q as P,m as R,h as Q,l as z,D as h,f as i,a as C,u as _,w as N,F as O,o,Z as G,b as s,t as c,g as d,i as u,A as w,E as W,G as Z,d as y,v as b,S as B}from"./app-48GMqJ0X.js";import{_ as H}from"./AuthenticatedLayout-C3C7JhOe.js";import{d as I}from"./index-D9AAl59p.js";import"./ApplicationLogo-BkXIqR07.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const K={class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},X={key:0},Y={key:1},ee={class:"services__create"},te={class:"services__create__cardWrapper mt-2"},se={class:"services__create__main"},ie={class:"services__create__main--addInfo card py-2 px-2 bg-white"},oe={key:0,class:"device-info"},ae={class:"mb-1"},de={key:1,class:"device-info"},re={class:"mb-1"},le={key:2,class:"device-info"},ne={class:"mb-1"},ce={key:3,class:"device-info"},pe={class:"mb-1"},ue={key:4},ve=["value"],me={key:0,style:{color:"red"}},_e={key:5},ye={key:0,style:{color:"red"}},fe={key:6},be={class:"mb-1"},ke={key:7},ge={key:0,style:{color:"red"}},xe={key:8},he={class:"my-1"},we={key:9},Se={class:"mb-1"},Ve={key:10},Ue={key:0,style:{color:"red"}},Ee={key:11},Ae={class:"my-1"},De={key:12},je={key:13},Ce={class:"mb-1"},Ne={key:14},Oe={class:"mb-1"},Be={key:15},Ie={key:16},Me={class:"mb-1"},Le={key:17},Te={key:18},$e={key:19},Fe={class:"mb-1"},qe={key:20},Je={key:21},Pe={key:22},Re={class:"mb-1"},Qe={key:23},ze={key:24},Ye={__name:"Form",setup(Ge){const S=f(),t=J({device_id:"",description:"",accepted:!1,deposit:null,deposit_paid:!1,price:null,price_paid:!1,done:!1}),k=P(),p=f(!1);let v=f([]);const n=f(!1),m=f(null),g=f([]),x=f("");R(()=>{const a=k.props.auth.user;a&&a.role===0&&(n.value=!0),k.props.route&&k.props.route.name==="services.edit"?(p.value=!0,S.value=k.props.route.params.id,L()):M(),console.log("Edit Mode:",p.value)});const V=Q(()=>{if(!x.value.trim())return g.value;const a=x.value.toLowerCase();return Object.fromEntries(Object.entries(g.value).filter(([e,r])=>r.toLowerCase().includes(a)))});z(V,a=>{Object.keys(a).length>0&&(t.device_id=Object.keys(a)[0])});const M=async()=>{const e=new URLSearchParams(window.location.search).get("device_id");try{const r=await h.get(`/api/services/create${e?`?device_id=${e}`:""}`);r.data.device&&(m.value=r.data.device,t.device_id=e,console.log("Device Info:",m.value)),r.data.devices&&(g.value=r.data.devices,console.log("Devices Dropdown:",g.value))}catch(r){console.error("Error fetching data:",r)}},L=async()=>{try{let a=await h.get(`/api/services/${S.value}/edit`);console.log("Service Response:",a.data),a.data.devices&&(k.props.devices=Object.entries(a.data.devices).map(([e,r])=>({id:Number(e),label:r}))),a.data.service&&(t.device_id=a.data.service.device_id,t.device=a.data.service.device,t.description=a.data.service.description,t.accepted=!!a.data.service.accepted,t.deposit=a.data.service.deposit,t.deposit_paid=!!a.data.service.deposit_paid,t.price=a.data.service.price,t.price_paid=!!a.data.service.price_paid,t.done=!!a.data.service.done,t.returned=!!a.data.service.device.returned)}catch(a){console.error("Error fetching service data:",a)}},T=(a,e)=>{p.value?(console.log("Updating service:",JSON.stringify(t,null,2)),F()):(console.log("Creating service:",JSON.stringify(t,null,2)),$())},$=(a,e)=>{h.post("/api/services",t).then(r=>{B.fire({icon:"success",title:"Appareil ajouté"}),setTimeout(()=>{I.Inertia.visit("/services/index/")},2e3)}).catch(r=>{r.response&&r.response.status===422?v.value=r.response.data.errors:r.request?console.error("Erreur de réseau ou serveur injoignable :",r.request):console.error("Error creating service:",r)}),console.log("Form data being sent:",JSON.stringify(t,null,2))},F=(a,e)=>{h.put(`/api/services/${S.value}`,t).then(r=>{B.fire({icon:"success",title:"Appareil modifié"}),setTimeout(()=>{I.Inertia.visit("/services/index/")},2e3)}).catch(r=>{r.response.status===422?v.value=r.response.data.errors:console.error("Error creating service:",r)})};return(a,e)=>(o(),i(O,null,[C(_(G),{title:"Enregistrement Appareil"}),C(H,null,{header:N(()=>[s("h2",K,[p.value?(o(),i("span",X,"Modification d'une prestation")):(o(),i("span",Y,"Nouvelle prestation"))])]),default:N(()=>{var r,U,E,A,D,j;return[s("div",ee,[e[32]||(e[32]=s("div",{class:"services__create__titlebar dflex justify-content-between align-items-center"},[s("div",{class:"services__create__titlebar--item"},[s("button",{class:"btn btn-secondary ml-1"},"Save")])],-1)),s("div",te,[s("div",se,[s("div",ie,[e[30]||(e[30]=s("p",{class:"mb-1"},"Appareil:",-1)),!n.value&&p.value?(o(),i("div",oe,[s("p",ae,c((U=(r=t.device)==null?void 0:r.user)==null?void 0:U.name)+" -> "+c((E=t.device)==null?void 0:E.brand)+" "+c((A=t.device)==null?void 0:A.model_name),1)])):d("",!0),n.value&&p.value?(o(),i("div",de,[s("p",re,c((D=t.device)==null?void 0:D.brand)+" "+c((j=t.device)==null?void 0:j.model_name),1)])):d("",!0),!n.value&&m.value?(o(),i("div",le,[s("p",ne,c(m.value.user.name)+" -> "+c(m.value.brand)+" "+c(m.value.model_name),1)])):d("",!0),n.value&&m.value?(o(),i("div",ce,[s("p",pe,c(m.value.brand)+" "+c(m.value.model_name),1)])):d("",!0),!p.value&&!m.value?(o(),i("div",ue,[u(s("input",{type:"text","onUpdate:modelValue":e[0]||(e[0]=l=>x.value=l),placeholder:"Rechercher par utilisateur, marque ou modèle...",class:"input mb-2"},null,512),[[w,x.value]]),u(s("select",{"onUpdate:modelValue":e[1]||(e[1]=l=>t.device_id=l),class:"input"},[(o(!0),i(O,null,Z(Object.entries(V.value),([l,q])=>(o(),i("option",{key:l,value:l},c(q),9,ve))),128))],512),[[W,t.device_id]]),_(v).device_id?(o(),i("small",me,c(_(v).device_id),1)):d("",!0)])):d("",!0),n.value&&t.price!=null?d("",!0):(o(),i("div",_e,[e[11]||(e[11]=s("p",{class:"my-1"},"Description du service demandé:",-1)),u(s("textarea",{cols:"10",rows:"5",class:"textarea",id:"description",name:"description","onUpdate:modelValue":e[2]||(e[2]=l=>t.description=l)},null,512),[[w,t.description]]),_(v).description?(o(),i("small",ye,c(_(v).description),1)):d("",!0)])),n.value&&t.price!=null?(o(),i("div",fe,[s("p",be,[e[12]||(e[12]=y(" Service demandé:")),e[13]||(e[13]=s("br",null,null,-1)),y(c(t.description),1)])])):d("",!0),!n.value&&t.price_paid==!1?(o(),i("div",ke,[e[14]||(e[14]=s("p",{class:"mb-1"},"Accompte",-1)),u(s("input",{type:"text",class:"input",id:"deposit",name:"deposit","onUpdate:modelValue":e[3]||(e[3]=l=>t.deposit=l)},null,512),[[w,t.deposit]]),_(v).price?(o(),i("small",ge,c(_(v).deposit),1)):d("",!0)])):d("",!0),n.value&&p.value&&t.price_paid==!1?(o(),i("div",xe,[s("p",he,"Accompte: "+c(t.deposit),1)])):d("",!0),!n.value&&t.price!=null&&t.price_paid==!1?(o(),i("div",we,[s("p",Se,[u(s("input",{type:"checkbox",id:"deposit_paid",name:"deposit_paid","onUpdate:modelValue":e[4]||(e[4]=l=>t.deposit_paid=l)},null,512),[[b,t.deposit_paid]]),e[15]||(e[15]=y(" Accompte payé ?"))])])):d("",!0),n.value?d("",!0):(o(),i("div",Ve,[e[16]||(e[16]=s("p",{class:"mb-1"},"Prix",-1)),u(s("input",{type:"text",class:"input",id:"price",name:"price","onUpdate:modelValue":e[5]||(e[5]=l=>t.price=l)},null,512),[[w,t.price]]),_(v).price?(o(),i("small",Ue,c(_(v).price),1)):d("",!0)])),n.value&&p.value&&t.price!=null?(o(),i("div",Ee,[s("p",Ae,"Tarif: "+c(t.price),1)])):d("",!0),p.value&&t.price==null?(o(),i("div",De,e[17]||(e[17]=[s("p",{class:"mb-1"},"En attente d'un tarif",-1)]))):d("",!0),!n.value&&t.price!=null?(o(),i("div",je,[s("p",Ce,[u(s("input",{type:"checkbox",id:"accepted",name:"accepted","onUpdate:modelValue":e[6]||(e[6]=l=>t.accepted=l)},null,512),[[b,t.accepted]]),e[18]||(e[18]=y(" Devis accepté ?"))])])):d("",!0),n.value&&p.value&&t.accepted==!1&&t.price!=null?(o(),i("div",Ne,[s("p",Oe,[u(s("input",{type:"checkbox",id:"accepted",name:"accepted","onUpdate:modelValue":e[7]||(e[7]=l=>t.accepted=l)},null,512),[[b,t.accepted]]),e[19]||(e[19]=y(" Cochez la case pour accepter le devis"))])])):d("",!0),n.value&&p.value&&t.accepted==!0?(o(),i("div",Be,e[20]||(e[20]=[s("p",{class:"my-1"},"Devis accepté",-1)]))):d("",!0),!n.value&&t.price!=null?(o(),i("div",Ie,[s("p",Me,[u(s("input",{type:"checkbox",id:"done",name:"done","onUpdate:modelValue":e[8]||(e[8]=l=>t.done=l)},null,512),[[b,t.done]]),e[21]||(e[21]=y(" Service rendu ?"))])])):d("",!0),t.done==!0?(o(),i("div",Le,e[22]||(e[22]=[s("p",{class:"my-1"},"Votre appareil est prêt !",-1)]))):d("",!0),t.done==!1&&p.value?(o(),i("div",Te,e[23]||(e[23]=[s("p",{class:"my-1"},"Service en cours...",-1)]))):d("",!0),!n.value&&t.price!=null?(o(),i("div",$e,[s("p",Fe,[u(s("input",{type:"checkbox",id:"price_paid",name:"price_paid","onUpdate:modelValue":e[9]||(e[9]=l=>t.price_paid=l)},null,512),[[b,t.price_paid]]),e[24]||(e[24]=y(" Service payé ?"))])])):d("",!0),t.price_paid==!0?(o(),i("div",qe,e[25]||(e[25]=[s("p",{class:"my-1"},"Payé !",-1)]))):d("",!0),t.price_paid==!1&&t.done==!0?(o(),i("div",Je,e[26]||(e[26]=[s("p",{class:"my-1"},"En attente de paiement",-1)]))):d("",!0),n.value?d("",!0):(o(),i("div",Pe,[s("p",Re,[u(s("input",{type:"checkbox",id:"returned",name:"returned","onUpdate:modelValue":e[10]||(e[10]=l=>t.returned=l)},null,512),[[b,t.returned]]),e[27]||(e[27]=y(" Appareil restitué ?"))])])),t.returned==!0?(o(),i("div",Qe,e[28]||(e[28]=[s("p",{class:"my-1"},"Appareil restitué",-1)]))):d("",!0),t.returned==!1?(o(),i("div",ze,e[29]||(e[29]=[s("p",{class:"my-1"},"Appareil en magasin",-1)]))):d("",!0)])])]),s("div",{class:"dflex justify-content-between align-items-center my-3"},[e[31]||(e[31]=s("p",null,null,-1)),s("button",{class:"btn btn-secondary",onClick:T},"Save")])])]}),_:1})],64))}};export{Ye as default};
