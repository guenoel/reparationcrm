import{k as f,C as T,Q as j,m as A,D as _,f as n,a as y,u as o,w as h,F as b,o as l,Z as M,b as s,i as p,E as N,G as B,t as c,g as u,A as k,S as x}from"./app-3uOG7p_d.js";import{_ as L}from"./AuthenticatedLayout-Cg1DGBdF.js";import{d as w}from"./index-y_yQgmwI.js";import"./ApplicationLogo-CwqhdOuY.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const R={class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},$={key:0},O={key:1},W={class:"tasks__create"},G={class:"tasks__create__cardWrapper mt-2"},P={class:"tasks__create__main"},Q={class:"tasks__create__main--addInfo card py-2 px-2 bg-white"},Z=["value"],q={key:0,style:{color:"red"}},z={key:1,style:{color:"red"}},H={key:2,style:{color:"red"}},J={key:3,style:{color:"red"}},K={class:"devices__create__main--media--images mt-2"},X={class:"devices__create__main--media--images--list list-unstyled"},Y={class:"devices__create__main--media--images--item"},ee={class:"devices__create__main--media--images--item--imgWrapper"},se=["src"],te={class:"devices__create__main--media--images--item"},ae={class:"devices__create__main--media--images--item--form"},me={__name:"Form",setup(ie){const v=f(),i=T({service_id:"",start:"",end:"",description:""}),d=j(),g=f(!1);let r=f([]);A(()=>{d.props.route&&d.props.route.name==="tasks.edit"?(g.value=!0,v.value=d.props.route.params.id,D()):(S(),E())});const S=async()=>{try{let a=await _.get("/api/services?all=true");d.props.services=a.data.services;const e=new URLSearchParams(window.location.search);i.service_id=e.get("service_id")}catch(a){console.error("Error fetching services:",a)}},E=async()=>{try{i.user_id=d.props.auth.user.id}catch(a){console.error("Error fetching user:",a)}},D=async()=>{try{let a=await _.get(`/api/tasks/${v.value}/edit`);a.data.services&&(d.props.services=Object.entries(a.data.services).map(([e,t])=>({id:Number(e),description:t}))),a.data.task&&(i.service_id=a.data.task.service_id,i.start=a.data.task.start,i.end=a.data.task.end,i.description=a.data.task.description)}catch(a){console.error("Error fetching task data:",a)}},I=()=>{let a="/upload/no-image.jpg";return i.image&&(i.image.indexOf("base64")!=-1?a=i.image:a="/upload/"+i.image),a},U=a=>{const e=a.target;let t=e.files?e.files[0]:null;if(t){const m=new FileReader;m.onloadend=re=>{m.result&&(i.image=m.result)},m.readAsDataURL(t)}},V=(a,e)=>{g.value?F():C()},C=(a,e)=>{_.post("/api/tasks",i).then(t=>{x.fire({icon:"success",title:"Appareil ajouté"}),setTimeout(()=>{w.Inertia.visit("/tasks/index/")},2e3)}).catch(t=>{t.response&&t.response.status===422?r.value=t.response.data.errors:console.error("Error creating task:",t)})},F=(a,e)=>{_.put(`/api/tasks/${v.value}`,i).then(t=>{x.fire({icon:"success",title:"Appareil modifié"}),setTimeout(()=>{w.Inertia.visit("/tasks/index/")},2e3)}).catch(t=>{t.response.status===422?r.value=t.response.data.errors:console.error("Error creating task:",t)})};return(a,e)=>(l(),n(b,null,[y(o(M),{title:"Enregistrement d'une tâche"}),y(L,null,{header:h(()=>[s("h2",R,[g.value?(l(),n("span",$,"Modification d'une tâche")):(l(),n("span",O,"Nouvelle tâche"))])]),default:h(()=>[s("div",W,[e[10]||(e[10]=s("div",{class:"tasks__create__titlebar dflex justify-content-between align-items-center"},[s("div",{class:"tasks__create__titlebar--item"},[s("button",{class:"btn btn-secondary ml-1"},"Save")])],-1)),s("div",G,[s("div",P,[s("div",Q,[e[5]||(e[5]=s("p",{class:"mb-1"},"Service ID",-1)),p(s("select",{"onUpdate:modelValue":e[0]||(e[0]=t=>i.service_id=t),class:"input",id:"service_id",name:"service_id"},[(l(!0),n(b,null,B(o(d).props.services,t=>(l(),n("option",{key:t.id,value:t.id},c(t.description),9,Z))),128))],512),[[N,i.service_id]]),o(r).service_id?(l(),n("small",q,c(o(r).service_id),1)):u("",!0),e[6]||(e[6]=s("p",{class:"mb-1"},"Début de la tâche",-1)),p(s("input",{type:"datetime-local",class:"input",id:"start",name:"start","onUpdate:modelValue":e[1]||(e[1]=t=>i.start=t)},null,512),[[k,i.start]]),o(r).start?(l(),n("small",z,c(o(r).start),1)):u("",!0),e[7]||(e[7]=s("p",{class:"mb-1"},"Fin de la tâche",-1)),p(s("input",{type:"datetime-local",class:"input",id:"end",name:"end","onUpdate:modelValue":e[2]||(e[2]=t=>i.end=t)},null,512),[[k,i.end]]),o(r).end?(l(),n("small",H,c(o(r).end),1)):u("",!0),e[8]||(e[8]=s("p",{class:"my-1"},"Description",-1)),p(s("textarea",{cols:"10",rows:"5",class:"textarea",id:"description",name:"description","onUpdate:modelValue":e[3]||(e[3]=t=>i.description=t)},null,512),[[k,i.description]]),o(r).description?(l(),n("small",J,c(o(r).description),1)):u("",!0),s("div",K,[s("ul",X,[s("li",Y,[s("div",ee,[s("img",{src:I(),class:"devices__create__main--media--images--item--img",alt:""},null,8,se)])]),s("li",te,[s("form",ae,[e[4]||(e[4]=s("label",{class:"devices__create__main--media--images--item--form--label",for:"myfile"},"Add Image",-1)),s("input",{class:"devices__create__main--media--images--item--form--input",type:"file",id:"myfile",onChange:U},null,32)])])])])])])]),s("div",{class:"dflex justify-content-between align-items-center my-3"},[e[9]||(e[9]=s("p",null,null,-1)),s("button",{class:"btn btn-secondary",onClick:V},"Save")])])]),_:1})],64))}};export{me as default};
