import{k as f,C as j,Q as N,m as T,D as m,f as d,a as b,u as r,w as x,F as h,o as n,Z as B,b as a,i as c,E as k,G as S,t as p,g as _,A as v,S as w}from"./app-C9vR_Gzm.js";import{_ as $}from"./AuthenticatedLayout-DGMLU6Id.js";import{d as D}from"./index-D1IcRyCj.js";import"./ApplicationLogo-A6nw8Az8.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const L={class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},R={key:0},W={key:1},G={class:"spares__create"},O={class:"spares__create__cardWrapper mt-2"},P={class:"spares__create__main"},Q={class:"spares__create__main--addInfo card py-2 px-2 bg-white"},Z=["value"],q={key:0,style:{color:"red"}},z=["value"],H={key:1,style:{color:"red"}},J={key:2,style:{color:"red"}},K={key:3,style:{color:"red"}},X={key:4,style:{color:"red"}},Y={key:5,style:{color:"red"}},ee={class:"devices__create__main--media--images mt-2"},se={class:"devices__create__main--media--images--list list-unstyled"},te={class:"devices__create__main--media--images--item"},ae={class:"devices__create__main--media--images--item--imgWrapper"},ie=["src"],re={class:"devices__create__main--media--images--item"},oe={class:"devices__create__main--media--images--item--form"},ue={__name:"Form",setup(de){const y=f(),i=j({image:"",service_id:"",spare_type_id:"",purchase_date:"",reception_date:"",description:""}),l=N(),g=f(!1);let o=f([]);T(()=>{l.props.route&&l.props.route.name==="spares.edit"?(g.value=!0,y.value=l.props.route.params.id,I()):(V(),E())});const V=async()=>{try{let t=await m.get("/api/services");l.props.services=t.data.services.data}catch(t){console.error("Error fetching services:",t)}},E=async()=>{try{let t=await m.get("/api/spare_types");l.props.spare_types=t.data.spare_types.data}catch(t){console.error("Error fetching spare_types:",t)}},I=async()=>{try{let t=await m.get(`/api/spares/${y.value}/edit`);t.data.spare&&(i.image=t.data.spare.image,i.service_id=t.data.spare.service_id,i.spare_type_id=t.data.spare.spare_type_id,i.description=t.data.spare.description,i.purchase_date=t.data.spare.purchase_date,i.reception_date=t.data.spare.reception_date,i.return_date=t.data.spare.return_date),t.data.services&&(l.props.services=t.data.services),t.data.spare_type_id&&(l.props.spare_type_id=t.data.spare_type_id)}catch(t){console.error("Error fetching spare data:",t)}},U=()=>{let t="/upload/no-image.jpg";return i.image&&(i.image.indexOf("base64")!=-1?t=i.image:t="/upload/"+i.image),t},C=t=>{const e=t.target;let s=e.files?e.files[0]:null;if(s){const u=new FileReader;u.onloadend=ne=>{u.result&&(i.image=u.result)},u.readAsDataURL(s)}},A=(t,e)=>{g.value?M():F()},F=(t,e)=>{m.post("/api/spares",i).then(s=>{w.fire({icon:"success",title:"Appareil ajouté"}),setTimeout(()=>{D.Inertia.visit("/spares/index/")},2e3)}).catch(s=>{s.response&&s.response.status===422?o.value=s.response.data.errors:console.error("Error creating spare:",s)})},M=(t,e)=>{m.put(`/api/spares/${y.value}`,i).then(s=>{w.fire({icon:"success",title:"Appareil modifié"}),setTimeout(()=>{D.Inertia.visit("/spares/index/")},2e3)}).catch(s=>{s.response.status===422?o.value=s.response.data.errors:console.error("Error creating spare:",s)})};return(t,e)=>(n(),d(h,null,[b(r(B),{title:"Enregistrement d'une pièce"}),b($,null,{header:x(()=>[a("h2",L,[g.value?(n(),d("span",R,"Modification d'une pièce")):(n(),d("span",W,"Nouvelle pièce"))])]),default:x(()=>[a("div",G,[e[14]||(e[14]=a("div",{class:"spares__create__titlebar dflex justify-content-between align-items-center"},[a("div",{class:"spares__create__titlebar--item"},[a("button",{class:"btn btn-secondary ml-1"},"Save")])],-1)),a("div",O,[a("div",P,[a("div",Q,[e[7]||(e[7]=a("p",{class:"mb-1"},"Service ID",-1)),c(a("select",{"onUpdate:modelValue":e[0]||(e[0]=s=>i.service_id=s),class:"input",id:"service_id",name:"service_id"},[(n(!0),d(h,null,S(r(l).props.services,s=>(n(),d("option",{key:s.id,value:s.id},p(s.description),9,Z))),128))],512),[[k,i.service_id]]),r(o).service_id?(n(),d("small",q,p(r(o).service_id),1)):_("",!0),e[8]||(e[8]=a("p",{class:"mb-1"},"Pièce type ID",-1)),c(a("select",{"onUpdate:modelValue":e[1]||(e[1]=s=>i.spare_type_id=s),class:"input",id:"spare_type_id",name:"spare_type_id"},[(n(!0),d(h,null,S(r(l).props.spare_types,s=>(n(),d("option",{key:s.id,value:s.id},p(s.dealer)+" "+p(s.type),9,z))),128))],512),[[k,i.spare_type_id]]),r(o).spare_type_id?(n(),d("small",H,p(r(o).spare_type_id),1)):_("",!0),e[9]||(e[9]=a("p",{class:"my-1"},"Description",-1)),c(a("textarea",{cols:"10",rows:"5",class:"textarea",id:"description",name:"description","onUpdate:modelValue":e[2]||(e[2]=s=>i.description=s)},null,512),[[v,i.description]]),r(o).description?(n(),d("small",J,p(r(o).description),1)):_("",!0),e[10]||(e[10]=a("p",{class:"mb-1"},"Date d'achat",-1)),c(a("input",{type:"datetime-local",class:"input",id:"purchase_date",name:"purchase_date","onUpdate:modelValue":e[3]||(e[3]=s=>i.purchase_date=s)},null,512),[[v,i.purchase_date]]),r(o).purchase_date?(n(),d("small",K,p(r(o).purchase_date),1)):_("",!0),e[11]||(e[11]=a("p",{class:"mb-1"},"Date de reception",-1)),c(a("input",{type:"datetime-local",class:"input",id:"reception_date",name:"reception_date","onUpdate:modelValue":e[4]||(e[4]=s=>i.reception_date=s)},null,512),[[v,i.reception_date]]),r(o).reception_date?(n(),d("small",X,p(r(o).reception_date),1)):_("",!0),e[12]||(e[12]=a("p",{class:"mb-1"},"Date de retour",-1)),c(a("input",{type:"datetime-local",class:"input",id:"return_date",name:"return_date","onUpdate:modelValue":e[5]||(e[5]=s=>i.return_date=s)},null,512),[[v,i.return_date]]),r(o).return_date?(n(),d("small",Y,p(r(o).return_date),1)):_("",!0),a("div",ee,[a("ul",se,[a("li",te,[a("div",ae,[a("img",{src:U(),class:"devices__create__main--media--images--item--img",alt:""},null,8,ie)])]),a("li",re,[a("form",oe,[e[6]||(e[6]=a("label",{class:"devices__create__main--media--images--item--form--label",for:"myfile"},"Add Image",-1)),a("input",{class:"devices__create__main--media--images--item--form--input",type:"file",id:"myfile",onChange:C},null,32)])])])])])])]),a("div",{class:"dflex justify-content-between align-items-center my-3"},[e[13]||(e[13]=a("p",null,null,-1)),a("button",{class:"btn btn-secondary",onClick:A},"Save")])])]),_:1})],64))}};export{ue as default};
