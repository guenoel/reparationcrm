import{k as y,C as I,Q as h,m as D,D as g,f as n,a as b,u as l,w as x,F as E,o,Z as M,b as t,i as p,A as d,t as f,g as v,S as T}from"./app-BOCkaKV8.js";import{_ as j}from"./AuthenticatedLayout-D_9LhWXv.js";import{d as k}from"./index-Ps8C63Ky.js";import"./ApplicationLogo-DHmw7JHb.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const N={class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},A={key:0},B={key:1},$={class:"devices__create"},P={class:"devices__create__cardWrapper mt-2"},R={class:"devices__create__main"},W={class:"devices__create__main--addInfo card py-2 px-2 bg-white"},q={key:0,style:{color:"red"}},L={key:1,style:{color:"red"}},O={key:2,style:{color:"red"}},Q={class:"devices__create__main--media--images mt-2"},Z={class:"devices__create__main--media--images--list list-unstyled"},z={class:"devices__create__main--media--images--item"},G={class:"devices__create__main--media--images--item--imgWrapper"},H=["src"],J={class:"devices__create__main--media--images--item"},K={class:"devices__create__main--media--images--item--form"},re={__name:"Form",setup(X){const m=y(),s=I({image:"",dealer:"",type:"",brand:"",buy_price:"",sell_price:"",description:""}),_=h(),u=y(!1);let r=y([]);D(()=>{_.props.route&&_.props.route.name==="spare_types.edit"&&(u.value=!0,m.value=_.props.route.params.id,w())});const w=async()=>{try{let i=await g.get(`/api/spare_types/${m.value}/edit`);i.data.spare_type&&(s.image=i.data.spare_type.image,s.dealer=i.data.spare_type.dealer,s.type=i.data.spare_type.type,s.brand=i.data.spare_type.brand,s.buy_price=i.data.spare_type.buy_price,s.sell_price=i.data.spare_type.sell_price,s.description=i.data.spare_type.description)}catch(i){console.error("Error fetching spare_type data:",i)}},S=()=>{let i="/upload/no-image.jpg";return s.image&&(s.image.indexOf("base64")!=-1?i=s.image:i="/upload/"+s.image),i},V=i=>{const e=i.target;let a=e.files?e.files[0]:null;if(a){const c=new FileReader;c.onloadend=Y=>{c.result&&(s.image=c.result)},c.readAsDataURL(a)}},U=(i,e)=>{u.value?F():C()},C=(i,e)=>{g.post("/api/spare_types",s).then(a=>{T.fire({icon:"success",title:"Type de pièce ajouté"}),setTimeout(()=>{k.Inertia.visit("/spare_types/index/")},2e3)}).catch(a=>{a.response&&a.response.status===422?r.value=a.response.data.errors:console.error("Error creating spare_type:",a)})},F=(i,e)=>{g.put(`/api/spare_types/${m.value}`,s).then(a=>{T.fire({icon:"success",title:"Type de pièce modifié"}),setTimeout(()=>{k.Inertia.visit("/spare_types/index/")},2e3)}).catch(a=>{a.response.status===422?r.value=a.response.data.errors:console.error("Error creating spare_type:",a)})};return(i,e)=>(o(),n(E,null,[b(l(M),{title:"Enregistrement Type de pièce"}),b(j,null,{header:x(()=>[t("h2",N,[u.value?(o(),n("span",A,"Modification d'un type de pièce")):(o(),n("span",B,"Nouvel Type de pièce"))])]),default:x(()=>[t("div",$,[e[14]||(e[14]=t("div",{class:"devices__create__titlebar dflex justify-content-between align-items-center"},[t("div",{class:"devices__create__titlebar--item"},[t("button",{class:"btn btn-secondary ml-1"},"Save")])],-1)),t("div",P,[t("div",R,[t("div",W,[e[7]||(e[7]=t("p",{class:"mb-1"},"Fournisseur",-1)),p(t("input",{type:"text",class:"input",id:"dealer",name:"dealer","onUpdate:modelValue":e[0]||(e[0]=a=>s.dealer=a)},null,512),[[d,s.dealer]]),l(r).dealer?(o(),n("small",q,f(l(r).dealer),1)):v("",!0),e[8]||(e[8]=t("p",{class:"mb-1"},"Type",-1)),p(t("input",{type:"text",class:"input",id:"type",name:"type","onUpdate:modelValue":e[1]||(e[1]=a=>s.type=a)},null,512),[[d,s.type]]),l(r).type?(o(),n("small",L,f(l(r).type),1)):v("",!0),e[9]||(e[9]=t("p",{class:"mb-1"},"Marque",-1)),p(t("input",{type:"text",class:"input",id:"brand",name:"brand","onUpdate:modelValue":e[2]||(e[2]=a=>s.brand=a)},null,512),[[d,s.brand]]),e[10]||(e[10]=t("p",{class:"my-1"},"Description (optional)",-1)),p(t("textarea",{cols:"10",rows:"5",class:"textarea",id:"description",name:"description","onUpdate:modelValue":e[3]||(e[3]=a=>s.description=a)},null,512),[[d,s.description]]),l(r).description?(o(),n("small",O,f(l(r).description),1)):v("",!0),e[11]||(e[11]=t("p",{class:"mb-1"},"Prix achat",-1)),p(t("input",{type:"text",class:"input",id:"buy_price",name:"buy_price","onUpdate:modelValue":e[4]||(e[4]=a=>s.buy_price=a)},null,512),[[d,s.buy_price]]),e[12]||(e[12]=t("p",{class:"mb-1"},"Prix vente",-1)),p(t("input",{type:"text",class:"input",id:"sell_price",name:"sell_price","onUpdate:modelValue":e[5]||(e[5]=a=>s.sell_price=a)},null,512),[[d,s.sell_price]]),t("div",Q,[t("ul",Z,[t("li",z,[t("div",G,[t("img",{src:S(),class:"devices__create__main--media--images--item--img",alt:""},null,8,H)])]),t("li",J,[t("form",K,[e[6]||(e[6]=t("label",{class:"devices__create__main--media--images--item--form--label",for:"myfile"},"Add Image",-1)),t("input",{class:"devices__create__main--media--images--item--form--input",type:"file",id:"myfile",onChange:V},null,32)])])])])])])]),t("div",{class:"dflex justify-content-between align-items-center my-3"},[e[13]||(e[13]=t("p",null,null,-1)),t("button",{class:"btn btn-secondary",onClick:U},"Save")])])]),_:1})],64))}};export{re as default};